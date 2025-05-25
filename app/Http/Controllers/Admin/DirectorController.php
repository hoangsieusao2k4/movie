<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DirectorController extends Controller
{
    //
    public function index()
    {
        $directors = Director::query()->paginate(5);
        // dd($categories);
        return view('admin.directors.index', compact("directors"));
    }
    public function create()
    {
        return view('admin.directors.create');
    }
    public function store(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => 'required|unique:directors|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Định dạng ảnh không hợp lệ.',
        ]);
        $data = $request->all();

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Lưu file vào storage/app/public/directors
            $path = $file->storeAs('directors', $filename);

            // Gán đường dẫn truy cập public
            $data['avatar'] = 'directors/' . $filename;
        }

        Director::create($data);
        // 4. Chuyển hướng và thông báo
        Session::flash('success', 'Thêm đạo diễn thành công!');
        return redirect()->route('admin.directors.index');
    }
    public function show(Director $director)
    {

        return view('admin.directors.show', compact("director"));
    }
    public function edit(Director  $director)
    {


        return view('admin.directors.edit', compact("director"));
    }
    public function update(Request $request, Director  $director)
    {


        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('directors')->ignore($director->id),
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'Tên đạo diễn là bắt buộc.',
            'name.unique' => 'Tên đạo diễn này đã tồn tại.',
            'name.max' => 'Tên đạo diễn không được quá 255 ký tự.',
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Định dạng ảnh không hợp lệ.',
        ]);

        $data = $request->all();
        // dd($data);
        // Xử lý ảnh mới (nếu có)
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($director->avatar && Storage::exists($director->avatar)) {
                Storage::delete($director->avatar);
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('directors', $filename);
            $data['avatar'] = 'directors/' . $filename;
        }

        $director->update($data);

        Session::flash('success', 'Cập nhật đạo diễn thành công!');
        return redirect()->route('admin.directors.index');
    }

    public function destroy( Director  $director)
    {

        // if ($category->movies()->count() > 0) {
        //     Session::flash('error', 'Không thể xóa danh mục này vì vẫn còn phim thuộc về nó.');
        //     return redirect()->route('admin.genres.index');
        // }

        // 4. Xóa danh mục
        $director->delete();

        // 5. Chuyển hướng và thông báo
        Session::flash('success', 'Xóa đạo diễn  thành công!');
        return redirect()->route('admin.directors.index');
    }
}

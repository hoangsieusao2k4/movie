<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ActorController extends Controller
{
    //
    public function index()
    {
        $actors = Actor::query()->paginate(5);
        // dd($categories);
        return view('admin.actors.index', compact("actors"));
    }
    public function create()
    {
        return view('admin.actors.create');
    }
    public function store(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => 'required|unique:actors|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ], [
            'name.required' => 'Tên diễn viên là bắt buộc.',
            'name.unique' => 'Tên diễn viên này đã tồn tại.',
            'name.max' => 'Tên diễn viên không được quá 255 ký tự.',
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Định dạng ảnh không hợp lệ.',
        ]);
        $data = $request->all();

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Lưu file vào storage/app/public/directors
            $path = $file->storeAs('actors', $filename);

            // Gán đường dẫn truy cập public
            $data['avatar'] = 'actors/' . $filename;
        }

        Actor::create($data);
        // 4. Chuyển hướng và thông báo
        Session::flash('success', 'Thêm diễn viên thành công!');
        return redirect()->route('admin.actors.index');
    }
    public function show(Actor $actor)
    {
        // dd($actor);
        return view('admin.actors.show', compact("actor"));
    }
    public function edit(Actor  $actor)
    {


        return view('admin.actors.edit', compact("actor"));
    }
    public function update(Request $request, Actor  $actor)
    {


        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('directors')->ignore($actor->id),
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
            if ($actor->avatar && Storage::exists($actor->avatar)) {
                Storage::delete($actor->avatar);
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('actors', $filename);
            $data['avatar'] = 'actors/' . $filename;
        }

        $actor->update($data);

        Session::flash('success', 'Cập nhật diễn viên thành công!');
        return redirect()->route('admin.actors.index');
    }

    public function destroy(Actor  $actor)
    {

        // if ($category->movies()->count() > 0) {
        //     Session::flash('error', 'Không thể xóa danh mục này vì vẫn còn phim thuộc về nó.');
        //     return redirect()->route('admin.genres.index');
        // }

        // 4. Xóa danh mục
        $actor->delete();

        // 5. Chuyển hướng và thông báo
        Session::flash('success', 'Xóa diễn viên  thành công!');
        return redirect()->route('admin.actors.index');
    }
}

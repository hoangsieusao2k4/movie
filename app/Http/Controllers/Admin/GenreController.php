<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    //
    public function index()
    {
        $genres = Genre::query()->paginate(5);
        // dd($categories);
        return view('admin.genres.index', compact("genres"));
    }
    public function create()
    {
        return view('admin.genres.create');
    }
    public function store(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => 'required|unique:genres|max:255',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

        ]);

        // 2. Tạo slug nếu trường slug trống


        // 3. Lưu dữ liệu vào database
        Genre::create($request->all());

        // 4. Chuyển hướng và thông báo
        Session::flash('success', 'Thêm thể loại phim thành công!');
        return redirect()->route('admin.genres.index');
    }
    public function show($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();
        return view('admin.genres.show', compact("genre"));
    }
    public function edit($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();
       
        return view('admin.genres.edit', compact("genre"));
    }
    public function update(Request $request,$slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();

        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('genres')->ignore($genre->id),
            ],

        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

        ]);

        // 2. Tạo/cập nhật slug nếu trường slug trống hoặc có thay đổi tên


        // 3. Cập nhật dữ liệu trong database
        $genre->update($request->all());

        // 4. Chuyển hướng và thông báo
        Session::flash('success', 'Cập nhật thể loại thành công!');
        return redirect()->route('admin.genres.index'); // Hoặc redirect()->route('admin.genres.index');
    }
    public function destroy(Genre $genre)
    {

        // if ($category->movies()->count() > 0) {
        //     Session::flash('error', 'Không thể xóa danh mục này vì vẫn còn phim thuộc về nó.');
        //     return redirect()->route('admin.genres.index');
        // }

        // 4. Xóa danh mục
        $genre->delete();

        // 5. Chuyển hướng và thông báo
        Session::flash('success', 'Xóa danh mục phim thành công!');
        return redirect()->route('admin.genres.index');
    }
}

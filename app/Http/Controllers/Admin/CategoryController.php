<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::query()->paginate(5);
        // dd($categories);
        return view('admin.categories.index', compact("categories"));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

        ]);

        // 2. Tạo slug nếu trường slug trống


        // 3. Lưu dữ liệu vào database
        Category::create($request->all());

        // 4. Chuyển hướng và thông báo
        Session::flash('success', 'Thêm danh mục phim thành công!');
        return redirect()->route('admin.categories.index');
    }
    public function show($id)
    {
        $category = Category::find($id);
        return view('admin.categories.show', compact("category"));
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact("category"));
    }
    public function update(Request $request, Category $category)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],

        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

        ]);

        // 2. Tạo/cập nhật slug nếu trường slug trống hoặc có thay đổi tên


        // 3. Cập nhật dữ liệu trong database
        $category->update($request->all());

        // 4. Chuyển hướng và thông báo
        Session::flash('success', 'Cập nhật danh mục phim thành công!');
        return redirect()->route('admin.categories.index'); // Hoặc redirect()->route('admin.categories.index');
    }
    public function destroy(Category $category)
    {

        // if ($category->movies()->count() > 0) {
        //     Session::flash('error', 'Không thể xóa danh mục này vì vẫn còn phim thuộc về nó.');
        //     return redirect()->route('admin.categories.index');
        // }

        // 4. Xóa danh mục
        $category->delete();

        // 5. Chuyển hướng và thông báo
        Session::flash('success', 'Xóa danh mục phim thành công!');
        return redirect()->route('admin.categories.index');
    }
}

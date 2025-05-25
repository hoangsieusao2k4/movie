@extends('admin.master')

@section('title', 'Thêm danh mục phim') @section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">🎬 Sửa đạo diễn </h1>
        </div>

    <div class="row">
        <div class="col-md-6"> <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin đạo diễn</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.directors.update',$director->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên đạo diễn</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$director->name}}"  value="{{$director->name}}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar"  value="{{ old('avatar') }}">
                            <img src="{{Storage::url($director->avatar)}}" alt="" width="100">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Sửa thể loại
                        </button>
                        <a href="{{ route('admin.directors.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

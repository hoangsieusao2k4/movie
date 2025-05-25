@extends('admin.master')

@section('title', 'Thêm danh mục phim') @section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">🎬 Sửa thể loại phim</h1>
        </div>

    <div class="row">
        <div class="col-md-6"> <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin thể loại</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.genres.update',$genre->slug) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên thể loại</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"  value="{{$genre->name}}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Sửa thể loại
                        </button>
                        <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@extends('admin.master')
@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-folder-open mr-2"></i> Chi tiết diễn viên: <span class="font-weight-bold">{{ $actor->name }}</span>
        </h1>
        <div>
            <a href="{{ route('admin.actors.edit', $actor->id) }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.actors.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin chung</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tên diễn viên
                            <span class="font-weight-bold">{{ $actor->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Avatar:
                            @if($actor->avatar)
                                <img src="{{ Storage::url($actor->avatar) }}" alt="Avatar" width="80" height="80" style="object-fit: cover; border-radius: 8px;">
                            @else
                                <span class="text-muted">Chưa có ảnh</span>
                            @endif
                        </li>

                    </ul>
                </div>
            </div>
        </div>
{{--
        @if ($movies && count($movies) > 0)
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Các phim thuộc danh mục</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên phim</th>
                                    <th>Ngày phát hành</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($movies as $movie)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $movie->title }}</td>
                                    <td>{{ $movie->release_date ? $movie->release_date->format('d/m/Y') : 'Chưa xác định' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif --}}

    </div>

</div>
@endsection

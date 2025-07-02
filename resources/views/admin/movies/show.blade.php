@extends('admin.master')
@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-film mr-2"></i> Chi tiết phim: <span class="font-weight-bold">{{ $movie->title }}</span>
            </h1>
            <div>
                <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin phim</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tên phim
                                <span class="font-weight-bold">{{ $movie->title }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Avatar:
                                @if ($movie->thumbnail)
                                    <img src="{{ Storage::url($movie->thumbnail) }}" alt="Poster" width="80"
                                        height="100" style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">Chưa có ảnh</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Năm phát hành
                                <span>{{ $movie->year ? $movie->year : 'Chưa xác định' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Đạo diễn
                                <span class="font-weight-bold">{{ $movie->director->name ?? 'Chưa có' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Premium
                                @if ($movie->is_premium)
                                    <span class="badge badge-warning">Chỉ dành cho tài khoản Premium</span>
                                @else
                                    <span class="badge badge-info">Tài khoản thường cũng xem được</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Trạng thái
                                @switch($movie->status)
                                    @case('public')
                                        <span class="badge badge-success">Công khai</span>
                                    @break

                                    @case('private')
                                        <span class="badge badge-danger">Riêng tư</span>
                                    @break

                                    @case('draft')
                                        <span class="badge badge-secondary">Bản nháp</span>
                                    @break

                                    @default
                                        <span class="badge badge-light">Không xác định</span>
                                @endswitch
                            </li>

                            <li class="list-group-item">
                                Mô tả
                                <div class="mt-2 text-muted" style="white-space: pre-line;">
                                    {{ $movie->description ?? 'Không có mô tả' }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Thể loại và Diễn viên -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin bổ sung</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Thể loại:</strong>
                            @forelse ($movie->genres as $genre)
                                <span class="badge badge-info mr-1">{{ $genre->name }}</span>
                            @empty
                                <span class="text-muted">Không có</span>
                            @endforelse
                        </p>
                        <p><strong>Diễn viên:</strong>
                            @forelse ($movie->actors as $actor)
                                <span class="badge badge-secondary mr-1">{{ $actor->name }}</span>
                            @empty
                                <span class="text-muted">Không có</span>
                            @endforelse
                        </p>
                    </div>
                </div>
            </div>

        </div>
        @if ($movie->type === 'series')
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách tập phim</h6>
                </div>
                <div class="card-body">
                    @if ($movie->episodes->count())
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tập số</th>
                                    <th>Tiêu đề</th>
                                    <th>Thời lượng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movie->episodes->sortBy('episode_number') as $ep)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Tập {{ $ep->episode_number }}</td>
                                        <td>{{ $ep->title }}</td>
                                        <td>{{ $ep->duration .' phút' ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.episodes.edit', $ep->id) }}"
                                                class="btn btn-sm btn-primary">Sửa</a>

                                            <form action="{{ route('admin.episodes.destroy', $ep->id) }}" method="POST"
                                                style="display:inline-block"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Chưa có tập phim nào.</p>
                    @endif

                    <hr>
                    <h5 class="mt-4">Thêm tập mới</h5>
                    <form action="{{ route('admin.episodes.store', $movie->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-2">
                                <input type="number" name="episode_number" class="form-control" placeholder="Tập số"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="title" class="form-control" placeholder="Tiêu đề" required>
                            </div>
                            <div class="col-md-4">
                                <input type="file" name="video_url" class="form-control" 
                                    required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="duration" class="form-control" placeholder="Thời lượng">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success btn-block">Thêm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
@endsection

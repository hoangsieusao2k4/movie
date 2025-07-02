@extends('admin.master')

@section('title', 'Sửa tập phim')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">✏️ Sửa tập phim: <strong>{{ $episode->title }}</strong></h1>
        <a href="{{ route('admin.movies.show', $episode->movie->slug) }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại phim
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin tập phim</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.episodes.update', $episode->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="mb-3">
                            <label for="episode_number" class="form-label">Số tập</label>
                            <input type="number" name="episode_number" id="episode_number"
                                   class="form-control @error('episode_number') is-invalid @enderror"
                                   value="{{ old('episode_number', $episode->episode_number) }}" min="1" required>
                            @error('episode_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề tập phim</label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $episode->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video_url" class="form-label"> Video</label>
                            <input type="file" name="video_url" id="video_url"
                                   class="form-control @error('video_url') is-invalid @enderror"
                                   value="{{ old('video_url', $episode->video_url) }}" >
                                    @if ($episode->video_url)
                                            <p class="mt-2">Đã có video:
                                                <a href="{{ Storage::url($episode->video_url) }}" target="_blank">Xem video
                                                    hiện tại</a>
                                            </p>
                                        @endif

                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Thời lượng (phút)</label>
                            <input type="number" name="duration" id="duration"
                                   class="form-control @error('duration') is-invalid @enderror"
                                   value="{{ old('duration', $episode->duration) }}" min="0">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.movies.show', $episode->movie->slug) }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại phim
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

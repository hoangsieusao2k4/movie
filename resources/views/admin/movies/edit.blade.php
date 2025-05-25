@extends('admin.master')

@section('title', 'Chỉnh sửa phim')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">🎬 Chỉnh sửa phim</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cập nhật thông tin phim</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.movies.update', $movie->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Cột trái -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Tên phim</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $movie->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô tả</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="Mô tả ngắn (tùy chọn)">{{ old('description', $movie->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="year" class="form-label">Năm phát hành</label>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror"
                                            id="year" min="1950" max="{{ date('Y') }}" name="year"
                                            value="{{ old('year', $movie->year) }}">
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Ảnh đại diện (URL)</label>
                                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" name="thumbnail">
                                        @if ($movie->thumbnail)
                                            <img src="{{ Storage::url($movie->thumbnail) }}" class="img-thumbnail mt-2"
                                                style="max-width: 150px;">
                                        @endif
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="trailer_url" class="form-label">Trailer URL</label>
                                        <input type="text"
                                            class="form-control @error('trailer_url') is-invalid @enderror" id="trailer_url"
                                            name="trailer_url" value="{{ old('trailer_url', $movie->trailer_url) }}">
                                        @error('trailer_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Loại phim</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type"
                                            name="type">
                                            <option value="movie"
                                                {{ old('type', $movie->type) == 'movie' ? 'selected' : '' }}>Phim lẻ
                                            </option>
                                            <option value="series"
                                                {{ old('type', $movie->type) == 'series' ? 'selected' : '' }}>Phim bộ
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cột phải -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="public"
                                                {{ old('status', $movie->status) == 'public' ? 'selected' : '' }}>Công khai
                                            </option>
                                            <option value="private"
                                                {{ old('status', $movie->status) == 'private' ? 'selected' : '' }}>Riêng tư
                                            </option>
                                            <option value="draft"
                                                {{ old('status', $movie->status) == 'draft' ? 'selected' : '' }}>Bản nháp
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="country_id" class="form-label">Quốc gia</label>
                                        <select class="form-control @error('country_id') is-invalid @enderror"
                                            id="country_id" name="country_id">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id', $movie->country_id) == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="director_id" class="form-label">Đạo diễn</label>
                                        <select class="form-control @error('director_id') is-invalid @enderror"
                                            id="director_id" name="director_id">
                                            @foreach ($directors as $director)
                                                <option value="{{ $director->id }}"
                                                    {{ old('director_id', $movie->director_id) == $director->id ? 'selected' : '' }}>
                                                    {{ $director->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('director_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="genres" class="form-label">Thể loại</label>
                                        <select class="form-control select2 @error('genres') is-invalid @enderror"
                                            id="genres" name="genres[]" multiple>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->id }}"
                                                    {{ in_array($genre->id, old('genres', $movie->genres->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('genres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="actors" class="form-label">Diễn viên</label>
                                        <select class="form-control select2 @error('actors') is-invalid @enderror"
                                            id="actors" name="actors[]" multiple>
                                            @foreach ($actors as $actor)
                                                <option value="{{ $actor->id }}"
                                                    {{ in_array($actor->id, old('actors', $movie->actors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $actor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('actors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_premium"
                                            name="is_premium" value="1"
                                            {{ old('is_premium', $movie->is_premium) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_premium">Dành cho người dùng
                                            Premium</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Cập nhật phim
                            </button>
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Chọn diễn viên",
                allowClear: true

            });
        });
    </script>
@endsection

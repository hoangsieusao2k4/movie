@extends('admin.master')

@section('title', 'Thêm phim mới')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">🎬 Thêm phim mới</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin phim</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Cột trái -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Tên phim</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="mb-3">
                                    <label for="slug" class="form-label">Slug (URL)</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" placeholder="Ví dụ: the-matrix" value="{{ old('slug') }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô tả</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="Mô tả ngắn (tùy chọn)">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="year" class="form-label">Năm phát hành</label>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror"
                                            id="year" name="year" value="{{ old('year', date('Y')) }}" min="1950" max="{{ date('Y') }}"
                                            placeholder="Chọn năm phát hành" min="1950"
                                            max="{{ date('Y') }}" required>
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Ảnh đại diện (URL)</label>
                                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="trailer_url" class="form-label">Trailer URL</label>
                                        <input type="text"
                                            class="form-control @error('trailer_url') is-invalid @enderror" id="trailer_url"
                                            name="trailer_url" value="{{ old('trailer_url') }}">
                                        @error('trailer_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Loại phim</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                            <option value="movie" {{ old('type') == 'movie' ? 'selected' : '' }}>Phim lẻ</option>
                                            <option value="series" {{ old('type') == 'series' ? 'selected' : '' }}>Phim bộ</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group" id="video_url_field" style="display: none;">
                                        <label for="video_url">Video URL</label>
                                        <input type="file" name="video_url" id="video_url" class="form-control" required>
                                        <small class="form-text text-muted">Nhập URL video cho phim lẻ (ví dụ: YouTube, Vimeo,...).</small>
                                    </div>
                                </div>

                                <!-- Cột phải -->
                                <div class="col-md-6">


                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="public"
                                                {{ old('status', 'public') == 'public' ? 'selected' : '' }}>Công khai
                                            </option>
                                            <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>
                                                Riêng tư</option>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Bản
                                                nháp</option>
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
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
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
                                                    {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                                    {{ $director->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('director_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="genres" class="form-label">Thể loại</label>
                                        <select class="form-control select-genre @error('genres') is-invalid @enderror"
                                            id="genres" name="genres[]" multiple>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->id }}"
                                                    {{ in_array($genre->id, old('genres', [])) ? 'selected' : '' }}>
                                                    {{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('genres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="actors" class="form-label">Diễn viên</label>
                                        <select class="form-control select-actor @error('actors') is-invalid @enderror"
                                            id="actors" name="actors[]" multiple>
                                            @foreach ($actors as $actor)
                                                <option value="{{ $actor->id }}"
                                                    {{ in_array($actor->id, old('actors', [])) ? 'selected' : '' }}>
                                                    {{ $actor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('actors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_premium"
                                            name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_premium">Dành cho người dùng
                                            Premium</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Lưu phim
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
    $(document).ready(function () {
        // Các select2 khởi tạo sẵn của bạn ở đây...
        $('.select-actor').select2({
            placeholder: "Chọn diễn viên",
            allowClear: true
        });

        $('.select-genre').select2({
            placeholder: "Chọn thể loại",
            allowClear: true
        });

        // Hàm bật/tắt trường video_url
        function toggleVideoUrlField(type) {
            if (type === 'movie') {
                $('#video_url_field').show();
                $('#video_url').prop('required', true);
            } else {
                $('#video_url_field').hide();
                $('#video_url').prop('required', false);
                $('#video_url').val(''); // xóa giá trị nếu có
            }
        }

        // Lấy giá trị hiện tại lúc load trang
        let currentType = $('#type').val();
        toggleVideoUrlField(currentType);

        // Lắng nghe thay đổi loại phim
        $('#type').change(function () {
            toggleVideoUrlField($(this).val());
        });
    });
</script>

@endsection

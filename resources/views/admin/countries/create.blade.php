@extends('admin.master')

@section('title', 'Thêm quốc gia') @section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">🎬 Thêm quốc gia </h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin quốc gia</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.countries.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Chọn quốc gia</label>
                            <select class="form-control select2" name="name" required>
                                <option value="">-- Chọn quốc gia --</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                            @endforeach
                            </select>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Lưu quốc gia
                        </button>
                        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary ms-2">
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
            width: '100%',
            placeholder: 'Chọn quốc gia',
        });
    });
</script>


@endsection

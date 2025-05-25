@extends('admin.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Phim</h6>
        </div>
        {{-- Hiển thị thông báo thành công --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Hiển thị thông báo lỗi --}}
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('admin.movies.create') }}" class="btn btn-success"><i class="fas fa-plus mr-2"></i>
                    Thêm phim</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên Phim</th>
                            <th>Thể Loại</th>
                            <th>Năm Phát Hành</th>
                            <th>Đạo Diễn</th>
                            <th>Quốc gia</th>
                            <th>Hành Động</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movies as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @foreach($item->genres as $genre)
                                        <span>{{ $genre->name }}</span>@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>{{$item->year}}</td>
                                <td>{{ $item->director->name ?? 'N/A' }}</td>
                                <td>{{ $item->country->name ?? 'N/A' }}</td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.movies.show', $item->slug) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.movies.edit', $item->slug) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.movies.destroy', $item->slug) }}" method="post" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

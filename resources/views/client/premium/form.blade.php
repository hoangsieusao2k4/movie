@extends('client.master');
@section('content')
    <h2 style="color: white">Gói Premium - 100.000đ/tháng</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form action="{{ route('vnpay.payment') }}" method="POST">
        @csrf
        <button href="{{ route('vnpay.payment') }}" name="redirect" class="btn btn-primary">Thanh toán với VNPay</button>
    </form>
@endsection

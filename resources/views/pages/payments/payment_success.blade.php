@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="card text-center">
        <div class="card-header bg-success text-white">
            <h2>Cảm ơn bạn đã thanh toán!</h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">Thanh toán của bạn đã thành công.</h4>
            <p>Chúng tôi sẽ sớm liên hệ với bạn để xác nhận chi tiết.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Quay lại trang chủ</a>
        </div>
        <div class="card-footer text-muted">
            Nếu bạn có bất kỳ thắc mắc nào, vui lòng <a href="{{ route('home') }}">liên hệ với chúng tôi</a>.
        </div>
    </div>
</div>
@endsection

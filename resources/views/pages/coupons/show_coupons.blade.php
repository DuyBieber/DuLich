@extends('layout')

@section('content')
<div class="container box-container-tour">
    <div class="coupon-list">
        <h1>Danh sách mã giảm giá</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Luôn hiển thị danh sách mã giảm giá -->
        <div class="row gx-4 gy-4">
            @foreach ($coupons as $coupon)
                <div class="col-md-6 mb-6" style="padding:10px;">
                    <div class="coupon-item card p-3 border">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('frontend/imgs/coupon.png') }}" alt="Coupon Image" class="img-fluid coupon-image" style="width:150px;">
                            </div>
                            <div class="col-md-6">
                                <h4 class="coupon-name">{{ $coupon->coupon_name }}</h4>
                                <p>Giảm giá: <strong>{{ $coupon->coupon_number }}%</strong></p>
                                <p>Còn lại: <strong>{{ $coupon->coupon_quantity }}</strong> mã</p>

                                <!-- Kiểm tra nếu người dùng đã đăng nhập -->
                                @if (session()->has('customer_id'))
                                    <button onclick="addToWallet('{{ $coupon->id }}')" class="btn btn-primary mt-2">Thêm vào ví</button>
                                @else
                                    <button onclick="alert('Vui lòng đăng nhập để thêm mã vào ví!')" class="btn btn-secondary mt-2">Thêm vào ví</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function addToWallet(couponId) {
        fetch(`/customer/add-coupon/${couponId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Tải lại trang để cập nhật danh sách mã còn lại
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }
</script>
@endsection

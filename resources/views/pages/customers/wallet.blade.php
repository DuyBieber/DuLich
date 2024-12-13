@extends('layout')

@section('content')
<div class="container box-container-tour">
<div class="coupon-list">
        <h1>Ví Coupon của bạn</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($coupons->isEmpty() && empty($sessionCoupons))
            <p>Bạn chưa thêm mã giảm giá nào vào ví.</p>
        @else
            <!-- Hiển thị mã giảm giá từ cơ sở dữ liệu -->
            <div class="row gx-4 gy-4">
                @foreach ($coupons as $coupon)
                    <div class="col-md-6 mb-4">
                    <div class="coupon-item card p-3 border">
                    <div class="coupon-label"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('frontend/imgs/coupon.png') }}" alt="Coupon Image" class="img-fluid coupon-image">
                                </div>
                                <div class="col-md-6">
                                    <h4 class="coupon-name">{{ $coupon->coupon_name }}</h4>
                                    <p>Mã: <strong>{{ $coupon->coupon_code }}</strong></p>
                                    <p>Giảm giá: <strong>{{ $coupon->coupon_number }}%</strong></p>
                                    <p>Ngày thêm: <strong>{{ \Carbon\Carbon::parse($coupon->pivot->assigned_at)->format('d/m/Y') }}</strong></p>
                                    <p>Trạng thái: 
                                        <strong>
                                            @if ($coupon->pivot->is_redeemed)
                                                Đã sử dụng
                                            @else
                                                Chưa sử dụng
                                            @endif
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Hiển thị mã giảm giá từ session -->
            @if (!empty($sessionCoupons))
                <h2>Mã Giảm Giá Trong Ví</h2>
                <div class="row gx-4 gy-4">
                    @foreach ($sessionCoupons as $sessionCoupon)
                    <div class="col-md-6 mb-6" style="padding:10px;"> 
                            <div class="coupon-item card p-3 border">
                                <div class="coupon-label"></div>
                                <div class="row">
                                    <div class="col-md-4" >
                                        <img src="{{ asset('frontend/imgs/coupon.png') }}" alt="Coupon Image" class="img-fluid coupon-image">
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="coupon-name">{{ $sessionCoupon['name'] }}</h4>
                                        <p>Mã: <strong>{{ $sessionCoupon['code'] }}</strong></p>
                                        <p>Giảm giá: <strong>{{ $sessionCoupon['discount'] }}%</strong></p>
                                        <p>Ngày thêm: <strong>{{ \Carbon\Carbon::parse($sessionCoupon['added_at'])->format('d/m/Y') }}</strong></p>
                                        <p>Trạng thái: <strong>{{ $sessionCoupon['is_redeemed'] ? 'Đã sử dụng' : 'Chưa sử dụng' }}</strong></p>
                                        <button onclick="deleteCoupon('{{ $sessionCoupon['id'] }}')" class="btn btn-danger">Xóa mã</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>

<script>
    function redeemCoupon(couponId) {
        fetch(`/customer/redeem-coupon/${couponId}`, {
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
                location.reload(); // Tải lại trang để cập nhật trạng thái mã
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }

    function deleteCoupon(couponId) {
        if (confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')) {
            fetch(`/customer/delete-coupon/${couponId}`, {
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
                    location.reload(); // Tải lại trang để cập nhật danh sách mã
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Lỗi:', error));
        }
    }
</script>
@endsection

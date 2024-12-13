@extends('layout')
@section('content')
<div class="container box-container-tour">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
            <li class="active"><a href="#">Booking</a></li>
        </ul>
    </div>
</div>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container box-container-tour">
  
    <div class="wrapper">
        <div class="row">
            <div class="mda-content">
            <div class="mda-contents">
                <input type="hidden" id="is-overseastour" value="1">
                <div id="mda-tour">
                    <div class="mda-info">
                        <div class="mda-info-img">
                            <img src="{{ asset('public/uploads/tours/' . $tourData['image']) }}" alt="{{ $tourData['name'] }}" style="width:600px; height:350px">
                        </div>
                        <div class="mda-info-caption">
                            <h2>
                                <a href="#">{{ $tourData['name'] }}</a>
                            </h2>
                            <div class="mda-info-list">
                                <div class="mda-row">
                                    <span class="be">Mã tour:</span> 
                                    <span class="font-weight-bold">{{ $tourData['tour_code'] }}</span>
                                </div>
                                <div class="mda-row">
                                    <span class="be">Thời gian:</span> 
                                    <span class="font-weight-bold">{{ $tourData['times'] }}</span>
                                </div>
                                <div class="mda-row">
                                    <span class="be">Giá:</span>
                                    <span class="font-weight-bold" id="total-all">{{ number_format($tourData['adult_price'], 0, ',', '.') }}</span> đ
                                </div>
                                <div class="mda-row">
                                    <span class="be">Ngày khởi hành:</span>
                                    <span class="font-weight-bold">{{ \Carbon\Carbon::parse($tourData['departure_date'])->format('d/m/Y') }}</span>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Kết thúc mda-contents -->
            </div> <!-- Kết thúc mda-content -->
        </div> <!-- Kết thúc row -->
    </div> <!-- Kết thúc wrapper -->
    <div style="width: 100%; height: 2px; background-color: black; margin: 20px 0;"></div>
</div> <!-- Kết thúc container -->
<div class="container box-container-tour">
    <div class="col-md-12 col-xs-9">
        <form action="{{ route('payment.update') }}" method="POST">
            @csrf
            @method('PUT') <!-- Thêm dòng này để chỉ định phương thức PUT -->
            
            <div class="mda-tilte-3">
                <span class="mda-tilte-name"><i class="fa fa-info-circle" aria-hidden="true"></i> Thông Tin Liên Hệ</span>
            </div>
            
            <input type="hidden" name="booking_id" value="{{ $bookingId }}"> 
            <input type="hidden" name="customer_id" value="{{ Session::get('customer_id') }}">
            
            <div id="mda-guest-b">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Họ Tên:</label>
                        <input type="text" name="Name" class="form-control" value="{{ $customerInfo['Name'] ?? '' }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Email:</label>
                        <input type="email" name="Mail" id="email" class="form-control" value="{{ $customerInfo['Mail'] ?? '' }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số Điện Thoại:</label>
                        <input type="text" name="Phone" id="phone" class="form-control" value="{{ $customerInfo['Phone'] ?? '' }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Địa Chỉ:</label>
                        <textarea name="AddressShow" class="form-control" required>{{ $customerInfo['AddressShow'] ?? '' }}</textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Ghi Chú:</label>
                        <textarea name="Note" class="form-control">{{ $customerInfo['Note'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số Lượng Người Lớn:</label>
                        <input type="number" name="QAdult" class="form-control" value="{{ $customerInfo['QAdult'] ?? 1 }}" min="1" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số Lượng Trẻ Em:</label>
                        <input type="number" name="QChild" class="form-control" value="{{ $customerInfo['QChild'] ?? 0 }}" min="0">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số Lượng Bé Sơ Sinh:</label>
                        <input type="number" name="QInfant" class="form-control" value="{{ $customerInfo['QInfant'] ?? 0 }}" min="0">
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Số Lượng Bé Nhỏ:</label>
                        <input type="number" name="QBaby" class="form-control" value="{{ $customerInfo['QBaby'] ?? 0 }}" min="0">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số Phòng Đơn:</label>
                        <input type="number" name="slphongdon" class="form-control" value="{{ $customerInfo['slphongdon'] ?? 0 }}" min="0">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số Visa:</label>
                        <input type="number" name="slvisa" class="form-control" value="{{ $customerInfo['slvisa'] ?? 0 }}" min="0">
                    </div>
                
                <div class="form-group col-md-3">
                        <label for="coupon_id">Chọn mã giảm giá</label>
                        <select name="coupon_id" id="coupon_id" class="form-control" onchange="updateCouponCode()">
                            <option value="" {{ !Session::get('customer_info.coupon_code') ? 'selected' : '' }}>
                                {{ Session::get('customer_info.coupon_code') ?? 'Chọn mã giảm giá' }}
                            </option>
                            @forelse($coupons as $coupon)
                                @if(Session::get('customer_info.coupon_code') !== $coupon->coupon_code)
                                    <option value="{{ $coupon->id }}" data-code="{{ $coupon->coupon_code }}">
                                        {{ $coupon->coupon_code }} (Giảm {{ $coupon->coupon_number }}%)
                                    </option>
                                @endif
                            @empty
                                <option value="" disabled>Không có mã giảm giá nào khả dụng</option>
                            @endforelse
                        </select>
                        
                        <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::get('customer_info.coupon_code') ?? '' }}">
                        
                        
                        <button type="button" id="remove-coupon" class="btn btn-danger" style="margin-top: 10px;">Xóa mã giảm giá</button>
                    </div>
                </div>
                </div>
                    
                <div class="form-group col-md-3">
                        <span class="be">Tổng giá tour:</span>
                        <span class="mda-price-summary"style="font-size: 20px;line-height: 28px;color: #ed0080;font-weight: 600;" id="final-price">
                            {{ number_format($customerInfo['total_price'] ?? 0, 0, ',', '.') }} VND
                        </span>
                        <div class="form-group col-md-3" style="margin-top: 25px;">
                    
                </div>
                    </div>
                <div class="form-group col-md-3" >
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="container box-container-tour">
    <div class="mda-tilte-3"> <span class="mda-tilte-name"><i class="fa fa-money" aria-hidden="true"></i> Phương thức thanh toán</span> </div>

    <!-- Hiển thị các phương thức thanh toán nếu chưa thanh toán -->
    <div class="payment-options">
        
        <!-- Thanh toán tại quầy -->
        <div class="col-lg-3 col-md-3 payment-option">
            <form action="{{ route('payment.store') }}" method="POST" class="payment-form">
                @csrf
                <input type="hidden" name="booking_id" value="{{ session('booking_id') }}">
                <input type="hidden" name="payment_name" value="Thanh toán tại quầy Duy Travel">
                <input type="hidden" name="payment_method" value="COD">
                <button type="submit" class="btn btn-primary">
                    <div class="icon-text">
                        <i class="fa fa-store" aria-hidden="true"></i>
                        <span>Thanh toán tại quầy Duy Travel</span>
                    </div>
                </button>
            </form>
        </div>
        
        <!-- Thanh toán chuyển khoản -->
        <div class="col-lg-3 col-md-3 payment-option">
            <div class="bank-toggle-container">
               
                <button type="button" class="btn btn-primary bank-btn"onclick="toggleBankInfo()">
                    <div class="icon-text">
                        <i class="fa fa-university" aria-hidden="true"></i>
                        <span>Thanh toán chuyển khoản qua ngân hàng</span>
                    </div>
                </button>
                
            </div>
            <!-- Danh sách thông tin chuyển khoản ẩn -->
            <div id="bank-info" class="bank-info">
                <form action="{{ route('payment.store') }}" method="POST" class="payment-form">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ session('booking_id') }}">
                    <input type="hidden" name="payment_name" value="Thanh toán chuyển khoản qua ngân hàng">
                    <input type="hidden" name="payment_method" value="Bank Transfer">
                    <ul>
                        <li>Quý khách chuyển khoản qua ngân hàng sau:</li>
                        <li>Ngân hàng MB BANK: Tài khoản 2 3333 666 9999 – CHI NHÁNH GIA ĐỊNH, TPHCM</li>
                        <li>Ngân hàng ACB: Tài khoản 1818386868 – CHI NHÁNH BÌNH THẠNH, TPHCM</li>
                        <li>Tên tài khoản: "CÔNG TY CỔ PHẦN TRUYỀN THÔNG DUY TRAVEL"</li>
                    </ul>
                    <button type="submit" class="btn btn-success mt-2">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
        
        <!-- Thanh toán qua VNPay -->
        <div class="col-lg-3 col-md-3 payment-option">
    <form action="{{ route('vnpay.payment') }}" method="POST" class="payment-form">
        @csrf
        <input type="hidden" name="booking_id" value="{{ session('booking_id') }}">
        <input type="hidden" name="redirect" value="true">
        <button type="submit" name="redirect" class="btn btn-primary">
            <div class="icon-text">
                <img src="{{asset('frontend/imgs/vnpay.png')}}" alt="VNPay Logo" style="width: 20px; height: 20px;">
                <span>Thanh toán qua VNPay</span>
            </div>
        </button>
    </form>
</div>

<!-- Thanh toán qua MoMo -->


<script>
    function toggleBankInfo() {
        var bankInfo = document.getElementById('bank-info');
        if (bankInfo.style.display === 'none') {
            bankInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
        }
    }
</script>




<script>
    function calculateTotal() {
    const qAdult = parseInt(document.querySelector('input[name="QAdult"]').value) || 0;
    const qChild = parseInt(document.querySelector('input[name="QChild"]').value) || 0;
    const qBaby = parseInt(document.querySelector('input[name="QBaby"]').value) || 0;
    const qInfant = parseInt(document.querySelector('input[name="QInfant"]').value) || 0;
    const qVisa = parseInt(document.querySelector('input[name="slvisa"]').value) || 0;
    const qSingleRoom = parseInt(document.querySelector('input[name="slphongdon"]').value) || 0;

    // Tính toán tổng tiền dựa trên các hạng mục
    const adults_total = qAdult * (adultPrice || 0);
    const children_total = qChild * (childPrice || 0);
    const babies_total = qBaby * (babyPrice || 0);
    const infants_total = qInfant * (infantPrice || 0);
    const visa_total = qVisa * (visaPrice || 0);
    const single_room_total = qSingleRoom * (singleRoomPrice || 0);

    // Tính tổng tiền
    let totalPrice = adults_total + children_total + babies_total + infants_total + visa_total + single_room_total;

    // Kiểm tra số lượng ghế có sẵn
    const totalQuantity = qAdult + qChild + qBaby + qInfant;
    if (totalQuantity > availableSeats) {
        // Hiển thị thông báo khi số chỗ không đủ
        alert('Không đủ chỗ cho số lượng bạn đã chọn! Số chỗ còn lại: ' + availableSeats);
        return; // Dừng hàm nếu không đủ chỗ
    }

    // Áp dụng mã giảm giá nếu có
    const discountAmount = (totalPrice * discountPercentage) / 100;
    totalPrice -= discountAmount;

    // Cập nhật tổng giá tour
    document.getElementById('final-price').innerText = formatCurrency(totalPrice);
}

function updateCouponCode() {
    // Lấy giá trị của mã giảm giá từ dropdown
    const selectedOption = document.querySelector('#coupon_id option:checked');
    const couponCode = selectedOption.dataset.code || '';
    
    // Cập nhật giá trị vào hidden input
    document.getElementById('coupon_code').value = couponCode;

    alert(`Mã giảm giá đã được cập nhật: ${couponCode}`);
}
function applyCoupon() {
    // Kiểm tra các trường thông tin bắt buộc
    const requiredFields = ['Name', 'Mail', 'Phone', 'AddressShow'];
    for (const field of requiredFields) {
        const inputField = document.querySelector(`[name="${field}"]`);
        if (!inputField || !inputField.value.trim()) {
            alert(`Vui lòng điền đầy đủ thông tin: ${field}`);
            return;
        }
    }

    const couponCode = document.getElementById('coupon_code').value.trim();

    if (!couponCode) {
        alert('Vui lòng chọn mã giảm giá trước khi áp dụng.');
        return;
    }

    // Gửi yêu cầu kiểm tra mã giảm giá
    fetch('/check-coupon', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ code: couponCode }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const discountPercentage = data.discount;
                alert(`Áp dụng mã giảm giá thành công! Giảm ${discountPercentage}%`);
                calculateTotal(discountPercentage); // Tính toán lại tổng sau khi áp dụng mã giảm giá
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
        });
}

function removeCoupon() {
    // Đặt lại giá trị giảm giá và hidden input
    document.getElementById('coupon_code').value = '';
    alert('Mã giảm giá đã được xóa!');
    calculateTotal(0); // Tính toán lại tổng khi không áp dụng mã giảm giá
}

// Hàm tính toán lại tổng giá
function calculateTotal(discountPercentage = 0) {
    const totalPriceElement = document.getElementById('final-price');
    const originalPrice = {{ $customerInfo['total_price'] ?? 0 }};
    const discountedPrice = originalPrice * (1 - discountPercentage / 100);

    // Hiển thị lại tổng giá
    totalPriceElement.textContent = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    }).format(discountedPrice);
}
document.getElementById('apply-coupon').addEventListener('click', applyCoupon);
document.getElementById('remove-coupon').addEventListener('click', removeCoupon);


// Gán sự kiện cho tất cả các input số lượng
const quantityInputs = document.querySelectorAll('.quantity');
quantityInputs.forEach(input => {
    input.addEventListener('change', calculateTotal);
});

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy các phần tử input
        const emailInput = document.getElementById("email");
        const phoneInput = document.getElementById("phone");

        // Kiểm tra định dạng email
        emailInput.addEventListener("blur", function() {
            const email = emailInput.value;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                document.getElementById("bookEmailError").textContent = "Email không hợp lệ!";
            } else {
                document.getElementById("bookEmailError").textContent = "";
            }
        });

        // Kiểm tra định dạng số điện thoại
        phoneInput.addEventListener("blur", function() {
            const phone = phoneInput.value;
            const phoneRegex = /^(0[3|5|7|8|9])+([0-9]{8})$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById("bookPhoneError").textContent = "Số điện thoại không hợp lệ!";
            } else {
                document.getElementById("bookPhoneError").textContent = "";
            }
        });
    });
</script>
@endsection

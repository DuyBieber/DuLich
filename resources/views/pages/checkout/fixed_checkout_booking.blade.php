@extends('layout')
@section('content')
<div class="container box-container-tour">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
            <li class="active"><a href="#">booking</a></li>
        </ul>
    </div>
</div>
<div class="container box-container-tour">
  
    <div class="wrapper">
        <div class="row">
            <div class="mda-content">
                <div class="mda-contents">
                    <input type="hidden" id="is-overseastour" value="1">
                    <div id="mda-tour">
                        <div class="mda-info">
                            <div class="mda-info-img">
                                <img src="{{ asset('public/uploads/tours/' . $tour->image) }}" alt="{{ $tour->title_tours }}" style="width:600px; height:350px">
                            </div>
                            <div class="mda-info-caption">
                                <h2>
                                    <a href="#">{{ $tour->title_tours }}</a>
                                </h2>
                                <div class="mda-info-list">
                                    <div class="mda-row">
                                        <span class="be">Mã tour:</span> 
                                        <span class="font-weight-bold">{{ $tour->tour_code }}</span>
                                    </div>
                                    <div class="mda-row">
                                        <span class="be">Thời gian:</span> 
                                        <span class="font-weight-bold">{{ $tour->tour_time }}</span>
                                    </div>
                                    <input type="hidden" id="total-all-hidden" value="{{ $tour->price }}">
                                    <div class="mda-row">
                                        <span class="be">Giá:</span>
                                        <span class="font-weight-bold" id="total-all">{{ number_format($tour->price, 0, ',', '.') }}</span> đ
                                    </div>
                                   

                                    <div class="mda-row">
                                        <span class="be">Ngày khởi hành:</span>
                                        @if(session('departure_date'))
                                        {{ session('departure_date') ? \Carbon\Carbon::parse(session('departure_date'))->format('d/m/Y') : 'N/A' }}</span>
@else
    <span class="font-weight-bold">N/A</span>
@endif
                                    </div>
                                    </div>
                                    <div class="mda-row">
                                        <span class="be">Nơi khởi hành:</span>
                                        <span class="font-weight-bold">{{ $tour->tour_from }}</span>
                                    </div>
                                    <div class="mda-row">
                                    <span class="be">Số chổ còn nhận:</span>
                                     @if($departureDate)
                                      <span class="font-weight:bold">{{ $departureDate->available_seats }}</span>
                                  @else
                                      <span class="font-weight-bold">Hết chổ</span>
                                  @endif
                                </div>
                                </div>
                            </div>
                        </div>
                        <ul class="mda-list-design">
                            <li>
                                <span class="text-danger">Các khoản phí phát sinh (nếu có) như: phụ thu dành cho khách nước ngoài, việt kiều; phụ thu phòng đơn; phụ thu chênh lệch giá tour…</span>
                            </li>
                            <li class="text-justify">
                                <span class="text-danger">Trường hợp quý khách không đồng ý các khoản phát sinh, phiếu xác nhận booking của quý khách sẽ không có hiệu lực.</span>
                            </li>
                        </ul>
                        <div id="MdaPrice">
                        <div class="mda-tilte-3">
                    <span class="mda-tilte-name"><i class="fa fa-money" aria-hidden="true"></i>  Bảng giá tour chi tiết</span>
                </div>
                            <div class="mda-price-tour-r clearfix">
                                <div class="table-wrapper">
                                    <div class="mda-table-container">
                                        <table class="mda-table chitiet_gia" >
                                            <tbody>
                                                <tr>
                                                    <td><span><b>Loại giá\Độ tuổi</b></span></td>
                                                    <td>Người lớn (Trên 11 tuổi)</td>
                                                    <td>Trẻ em (5 - 11 tuổi)</td>
                                                    <td>Trẻ nhỏ (2 - 5 tuổi)</td>
                                                    <td>Sơ sinh (&lt; 2 tuổi)</td>
                                                </tr>
                                                <tr>
                                                    <td><span><b>Giá</b></span></td>
                                                    <td><span class="mda-money">{{ number_format($tourPriceDetail->adult_price, 0, ',', '.') }}</span> đ</td>
                                                    <td><span class="mda-money">{{ number_format($tourPriceDetail->child_price, 0, ',', '.') }}</span> đ</td>
                                                    <td><span class="mda-money">{{ number_format($tourPriceDetail->infant_price, 0, ',', '.') }}</span> đ</td>
                                                    <td><span class="mda-money">{{ number_format($tourPriceDetail->baby_price, 0, ',', '.') }}</span> đ</td>
                                                </tr>
                                                <tr>
                                                    <td><span><b>Phụ thu Khách Nước Ngoài</b></span></td>
                                                    <td colspan="4" style="text-align: center;"><span class="mda-money">{{ number_format($tourPriceDetail->foreign_surcharge, 0, ',', '.') }}</span> đ</td>
                
                                                </tr>
                                                <tr>
                                                    <td><span><b>Phụ thu Phòng đơn</b></span></td>
                                                    <td colspan="4" style="text-align: center;"><span class="mda-money">{{ number_format($tourPriceDetail->single_room_surcharge, 0, ',', '.') }}</span> đ</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Kết thúc mda-tour -->
                </div> <!-- Kết thúc mda-contents -->
            </div> <!-- Kết thúc mda-content -->
        </div> <!-- Kết thúc row -->
    </div> <!-- Kết thúc wrapper -->
    <div style="width: 100%; height: 2px; background-color: black; margin: 20px 0;"></div>
</div> <!-- Kết thúc container -->
<div class="container box-container-tour">
   <div class="col-md-12 col-xs-9">
      @if ($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      @if (Session::has('customer_id'))
      <form action="{{ route('booking.store') }}" id="booktour-form" method="POST" style="position:relative; text-align: center;" novalidate="novalidate">
         @csrf
         <input type="hidden" name="trap" id="trap" value="ihim8u5vac4nisem42iadr5">
         <!-- Tổng tiền sẽ được lưu tại đây để gửi đến controller -->
         <input type="hidden" name="customer_id" value="{{ Session::get('customer_id') }}">
         <input type="hidden" name="tour_id" value="{{ $tour->id }}">
         <input type="hidden" name="departure_date_id" value="{{ $departureDate ? $departureDate->id : '' }}">
         <input type="hidden" name="departure_date" value="{{ session('departure_date') }}">
         <div id="MdaPrice">
            <div class="mda-tilte-3">
               <span class="mda-tilte-name"><i class="fa fa-info-circle" aria-hidden="true"></i> Thông Tin Liên Hệ</span>
            </div>
            <div id="mda-guest-b">
            <div class="row">
    <div class="form-group col-md-4">
        <label>HỌ TÊN *:<span id="bookNameError" class="error"></span></label>
        <input data-error="#bookNameError" type="text" name="Name" id="lname" class="form-control" placeholder="Họ tên" value="{{ Session::get('customer_name', '') }}">
    </div>
    <div class="form-group col-md-4">
        <label>Email *:<span id="bookEmailError" class="error"></span></label>
        <input data-error="#bookEmailError" type="text" name="Mail" id="email" class="form-control" placeholder="Email" value="{{ Session::get('customer_email','') }}">
    </div>
    <div class="form-group col-md-4">
        <label>Số điện thoại *:<span id="bookPhoneError" class="error"></span></label>
        <input data-error="#bookPhoneError" type="text" name="Phone" id="phone" class="form-control" placeholder="Số điện thoại" value="{{ Session::get('customer_phone','') }}">
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label>Địa chỉ *:<span id="bookAddressError" class="error"></span></label>
        <textarea data-error="#bookAddressError" name="AddressShow" class="form-control" placeholder="Địa chỉ"> {{ Session::get('customer_address') }}</textarea>
    </div>
    <div class="form-group col-md-6">
        <label>Ghi chú:</label>
        <textarea name="Note" class="form-control" placeholder="Ghi chú"></textarea>
    </div>
</div>
            <div class="row">
            <div class="form-group col-md-3">
                    <label>Người lớn:</label>
                    <input type="number" name="QAdult" class="form-control quantity" value="0" min="1" max="20" placeholder="Người lớn">
                </div>
                <div class="form-group col-md-3">
                    <label>Trẻ em:</label>
                    <input type="number" name="QChild" class="form-control quantity" min="0" value="0" placeholder="Trẻ em">
                </div>
                <div class="form-group col-md-3">
                    <label>Trẻ nhỏ:</label>
                    <input type="number" name="QBaby" class="form-control quantity" min="0" value="0" placeholder="Trẻ nhỏ">
                </div>
                <div class="form-group col-md-3">
                    <label>Sơ sinh:</label>
                    <input type="number" name="QInfant" class="form-control quantity" min="0" value="0" placeholder="Sơ sinh">
                </div>
                
            </div>
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-3">
                <label>Phụ thu khách nước ngoài</label>
                <select class="Visa is-visacharge input-tracking form-control" name="Visa" id="Visa" aria-invalid="false">
                    <option value="0">Không</option>
                    <option value="1">Có</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Số lượng khách nước ngoài</label>
                <input type="number" name="slvisa" id="slvisa" class="form-control" min="0" value="0" placeholder="Số lượng visa" disabled>
            </div>
            <div class="form-group col-md-3">
                <label>Phụ thu phòng đơn</label>
                <select class="SingleRoom is-singleroom input-tracking form-control" name="SingleRoom" id="SingleRoom" aria-invalid="false">
                    <option value="0">Không</option>
                    <option value="1">Có</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Số lượng phòng đơn</label>
                <input type="number" name="slphongdon" id="slphongdon" class="form-control" min="0" value="0" placeholder="Số lượng phòng đơn" disabled>
            </div>
        </div>
        <div class="row">
        <div class="form-group col-md-3">
    <label for="coupon_id">Chọn mã giảm giá</label>
    <select name="coupon_id" id="coupon_id" class="form-control" onchange="updateCouponCodeForBooking()">
        <option value="">Không sử dụng mã giảm giá</option>
        
        @forelse($coupons as $coupon)
            <option value="{{ $coupon->id }}" data-code="{{ $coupon->coupon_code }}">
                {{ $coupon->coupon_code }} (Giảm {{ $coupon->coupon_number }}%)
            </option>
        @empty
            <option value="" disabled>Không có mã giảm giá nào khả dụng</option>
        @endforelse
    </select>

    <!-- Hidden input field to store coupon_code -->
    <input type="hidden" name="coupon_code" id="coupon_code" value="">
</div>
            <div class="form-group col-md-3" style="margin-top: 25px;">
                <button type="button" id="apply-coupon"  class="btn btn-success">Áp mã giảm giá</button>
                <button type="button" id="remove-coupon" class="btn btn-danger">Xóa mã giảm giá</button>
            </div>
            <div class=" form-group col-md-3" style="margin-top: 30px;">
               <span class="be">Tổng giá tour:</span>
               <span class="mda-price-summary" style="font-size: 20px;line-height: 28px;color: #ed0080;font-weight: 600;" id="final-price">0 VND</span>
            </div>
            <div class="form-group col-md-3"style="margin-top: 25px;" >
                <button type="submit" class="btn btn-danger" id="btn-book-tour">Đặt ngay</button>
            </div>  
        </div>
         
            
           
        </form>
        @else
        
        <p>Bạn cần đăng nhập để đặt tour.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
        @endif
    </div>
</div>

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
   
    
<script>
    const adultPrice = {!! json_encode($tourPriceDetail->adult_price) !!};
    const childPrice = {!! json_encode($tourPriceDetail->child_price ?? 0) !!};
    const babyPrice = {!! json_encode($tourPriceDetail->baby_price ?? 0) !!};
    const infantPrice = {!! json_encode($tourPriceDetail->infant_price ?? 0) !!};
    const visaPrice = {!! json_encode($tourPriceDetail->foreign_surcharge ?? 0) !!};
    const singleRoomPrice = {!! json_encode($tourPriceDetail->single_room_surcharge ?? 0) !!};
    const availableSeats = {!! json_encode($availableSeats) !!} || 0;

    let discountPercentage = 0; // Phần trăm giảm giá từ mã coupon

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }

    function calculateTotal() {
        const qAdult = parseInt(document.querySelector('input[name="QAdult"]').value) || 0;
        const qChild = parseInt(document.querySelector('input[name="QChild"]').value) || 0;
        const qBaby = parseInt(document.querySelector('input[name="QBaby"]').value) || 0;
        const qInfant = parseInt(document.querySelector('input[name="QInfant"]').value) || 0;
        const qVisa = parseInt(document.querySelector('input[name="slvisa"]').value) || 0;
        const qSingleRoom = parseInt(document.querySelector('input[name="slphongdon"]').value) || 0;

        // Tính toán từng loại tổng tiền
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

        // Áp dụng giảm giá nếu có
        const discountAmount = (totalPrice * discountPercentage) / 100;
        totalPrice -= discountAmount;

        // Cập nhật hiển thị tổng tiền
        document.getElementById('final-price').innerText = formatCurrency(totalPrice);
    }
    function updateCouponCodeForBooking() {
        var couponSelect = document.getElementById('coupon_id');
        var couponCode = couponSelect.options[couponSelect.selectedIndex].getAttribute('data-code');
        document.getElementById('coupon_code').value = couponCode;
    }
    function applyCoupon() {
        // Kiểm tra các trường cần thiết
        const nameField = document.querySelector('input[name="Name"]'); // Trường tên
        const emailField = document.querySelector('input[name="Mail"]'); // Trường email
        const phoneField = document.querySelector('input[name="Phone"]'); // Trường điện thoại
        const addressField = document.querySelector('textarea[name="AddressShow"]');

        // Kiểm tra nếu có bất kỳ trường nào trống
        if (!nameField.value.trim() || !emailField.value.trim() || !phoneField.value.trim() || !addressField.value.trim()) {
            alert('Vui lòng điền đầy đủ thông tin: Tên, Email, Điện thoại, và Địa chỉ trước khi áp dụng mã giảm giá.');
            return; // Ngừng hàm nếu có trường không hợp lệ
        }

        const couponCode = document.getElementById('coupon_code').value.trim();

        // Gửi yêu cầu kiểm tra mã giảm giá
        fetch('/check-coupon', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: couponCode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            discountPercentage = data.discount;
            alert(`Áp dụng mã giảm giá thành công! Giảm ${discountPercentage}%`);
            calculateTotal(); // Tính toán lại tổng sau khi áp dụng mã giảm giá
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
        discountPercentage = 0;
        document.getElementById('coupon_code').value = ''; // Clear coupon input field
        alert('Mã giảm giá đã được xóa!');
        calculateTotal(); // Recalculate total without discount
    }

    // Gán sự kiện cho nút "Áp mã giảm giá"
    document.getElementById('apply-coupon').addEventListener('click', applyCoupon);
    document.getElementById('remove-coupon').addEventListener('click', removeCoupon);

    // Gán sự kiện cho tất cả các input số lượng
    const quantityInputs = document.querySelectorAll('.quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('change', calculateTotal);

    });
    document.getElementById('place-order').addEventListener('click', function() {
        const couponCode = document.getElementById('coupon_code').value.trim();
        
        fetch('/redeem-coupon', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: couponCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Hiển thị thông báo thành công
                // Thực hiện các bước đặt tour khác...
            } else {
                alert(data.message); // Thông báo lỗi
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lắng nghe sự thay đổi của phụ thu visa
        document.getElementById('Visa').addEventListener('change', function () {
            var slvisaInput = document.getElementById('slvisa');
            if (this.value == '1') {
                slvisaInput.disabled = false;  // Kích hoạt trường số lượng visa
            } else {
                slvisaInput.disabled = true;   // Vô hiệu hóa trường số lượng visa
                slvisaInput.value = 0;         // Đặt giá trị về 0
            }
        });

        // Lắng nghe sự thay đổi của phụ thu phòng đơn
        document.getElementById('SingleRoom').addEventListener('change', function () {
            var slphongdonInput = document.getElementById('slphongdon');
            if (this.value == '1') {
                slphongdonInput.disabled = false;  // Kích hoạt trường số lượng phòng đơn
            } else {
                slphongdonInput.disabled = true;   // Vô hiệu hóa trường số lượng phòng đơn
                slphongdonInput.value = 0;         // Đặt giá trị về 0
            }
        });
    });
</script>

@endsection
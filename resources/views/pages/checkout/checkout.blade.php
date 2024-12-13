@extends('layout')

@section('content')
<div class="container box-container-tour">
    <h2>Thanh toán đặt chỗ</h2>

    <div class="booking-details">
    
               <span class="be">Tổng giá tour:</span>
               <span class="mda-price-summary" style="font-size: 20px;line-height: 28px;color: #ed0080;font-weight: 600;" id="final-price">{{ number_format($booking->total_price, 0, ',', '.') }} VND</span>
            
        
    </div>
    
    <div class="mda-tilte-3">
        <span class="mda-tilte-name">
            <i class="fa fa-money" aria-hidden="true"></i> Phương thức thanh toán
        </span>
    </div>

    <div class="payment-options row">
        <!-- Thanh toán tại quầy -->
        <div class="col-lg-3 col-md-3 payment-option">
            <form action="{{ route('payment.store') }}" method="POST" class="payment-form">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
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
                <button type="button" class="btn btn-primary bank-btn" onclick="toggleBankInfo()">
                    <div class="icon-text">
                        <i class="fa fa-university" aria-hidden="true"></i>
                        <span>Thanh toán chuyển khoản qua ngân hàng</span>
                    </div>
                </button>
            </div>
            <div id="bank-info" class="bank-info" style="display: none;">
                <form action="{{ route('payment.store') }}" method="POST" class="payment-form">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
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
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="redirect" value="true">
                <button type="submit" class="btn btn-primary">
                    <div class="icon-text">
                        <img src="{{ asset('frontend/imgs/vnpay.png') }}" alt="VNPay Logo" style="width: 20px; height: 20px;">
                        <span>Thanh toán qua VNPay</span>
                    </div>
                </button>
            </form>
        </div>

        <!-- Thanh toán qua MoMo -->
        
    </div>
</div>

<script>
    function toggleBankInfo() {
        var bankInfo = document.getElementById('bank-info');
        bankInfo.style.display = bankInfo.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection

@extends('layout')
@section('content')
<div class="container box-list-tour top-30">
    <div class="row">
        <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
            <div class="w100 fl title-tour1">
                <h2 style="color: #ffc700;font-size: 30px;" ><img src="https://vietnamtravel.net.vn/assets/desktop/images/icon_mb.png" alt="icon" style="width: 80px;">Tour Giá Sốc</h2>
            </div>
        </div>
        <div class="col-md-12 col-xs-12 bx-content-lst-tour" >
            <div class="row" >
            @foreach($tours as $tour)
    <div class="col-md-4 col-xs-12 lst-tour-item">
        <div class="w100 fl bx-wap-pr-item">
            <div class="clearfix box-wap-imgpr">
                <a href="{{ route('detail-tour', ['slug' => $tour->slug_tours]) }}">
                    <img src="{{ asset('public/uploads/tours/' . $tour->image) }}" class="img-default" alt="tour" style="height:250px">
                </a>
            </div>
            <div class="clear"></div>
            <h4><a href="{{ route('detail-tour', ['slug' => $tour->slug_tours]) }}">{{ $tour->title_tours }}</a></h4>
            <div class="clear"></div>
            <div class="group-calendar w100 fl">
                <div class="col-md-6 col-xs-7 date-start">
                    <i class="fa fa-calendar"></i>
                    @if ($tour->firstAvailableDepartureDate)
                        {{ \Carbon\Carbon::parse($tour->firstAvailableDepartureDate->departure_date)->format('d/m/Y') }}
                    @else
                        Không có ngày khởi hành
                    @endif
                </div>
                <div class="col-md-6 col-xs-5 date-range">
                    <span class="lst-icon1"><i class="fa fa-clock-o"></i></span><span>{{ $tour->tour_time }} Ngày</span>
                </div>
            </div>
            <div class="group-localtion w100 fl">
                <div class="col-md-6 col-xs-7 map-maker">
                    <span class="lst-icon1"><i class="fa fa-map-marker"></i></span><span> Khởi hành từ {{ $tour->tour_from }}</span>
                </div>
                <div class="col-md-6 col-xs-5 numner-sit">
                    <span class="lst-icon1"><i class="fa fa-users"></i></span><span> Số chỗ:
                        @if ($tour->firstAvailableDepartureDate)
                            {{ $tour->firstAvailableDepartureDate->available_seats ?? 0 }} <!-- Hiển thị số chỗ còn lại -->
                        @else
                            0 <!-- Nếu không có ngày khởi hành -->
                        @endif
                    </span>
                </div>
            </div>
            <div class="note-attack"><i class="fa fa-bell" aria-hidden="true"></i> Khuyến mãi 200K cho nhóm khách 5 người trở lên</div>
            <div class="group-book w100 fl">
                <span class="price-sell">{{ number_format($tour->price, 0, ',', '.') }} VNĐ </span>
                <a href="{{ route('detail-tour', ['slug' => $tour->slug_tours]) }}" class="link-book btn_view_tour0">Xem chi tiết</a>
            </div>
        </div>
    </div>
@endforeach


            </div>
        </div>
        @if(!$tours->count() || $tours->count() >= 9)
            <div class="col-md-12 text-center">
                <a href="{{ route('home', ['show_all' => 1]) }}" class="btn btn-primary">Xem Thêm</a>
            </div>
        @endif
    </div>
</div>
<div class="container box-list-tour top-15">
    <div class="row">
        <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
            <div class="w100 fl title-tour1">
                <h2 style="color: #ffc700; font-size:30px">
                    <img src="https://vietnamtravel.net.vn/assets/desktop/images/icon_mb.png" alt="icon" style="width: 80px;">
                    QUÝ KHÁCH CHỌN ĐỊA ĐIỂM DU LỊCH NÀO
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12 top-30 lst-tour-position">
    <div class="row">
        @foreach($locations as $index => $location)
            <div class="col-md-3 col-xs-6 cl-mb-half-0" style="margin-bottom: 20px;"> <!-- Thêm khoảng cách dưới -->
                <div class="bximg-request-dd">
                    <a href="{{ route('tours.location', ['id' => $location->id]) }}" class="bximg-request-dd" style="display: block; cursor: pointer;">
                        <img src="{{ asset('uploads/locations/' . $location->image) }}" style="height:150px" alt="{{ $location->name }}">
                        <div class="capition-dd">
                            <i class="fa fa-map-marker"></i> {{ $location->name }}
                        </div>
                    </a>
                </div>
            </div>

            <!-- Kiểm tra nếu index chia hết cho 4 để bắt đầu dòng mới -->
            @if (($index + 1) % 4 == 0 && !$loop->last)
                </div><div class="row">
            @endif
        @endforeach
    </div>
</div>


</div>

@endsection

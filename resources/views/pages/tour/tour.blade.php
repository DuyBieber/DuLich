@extends('layout')

@section('content')
<div class="container box-list-tour top-30">
    <div class="row">
        <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
            <div class="w100 fl title-tour1">
                <h2 style="color: #ffc700;font-size: 30px;">
                    <img src="https://vietnamtravel.net.vn/assets/desktop/images/icon_mb.png" alt="icon" style="width: 80px;"> 
                    {{ $tourType->type_name }}
                </h2>
            </div>
        </div>
        <div class="col-md-12 col-xs-12 bx-content-lst-tour">
            <div class="row">
                @foreach($tours as $tour)
                    <div class="col-md-4 col-xs-12 lst-tour-item">
                        <div class="w100 fl bx-wap-pr-item">
                            <div class="clearfix box-wap-imgpr">
                                <a href="{{ route('detail-tour', ['slug' => $tour->slug_tours]) }}">
                                    <img src="{{ asset('public/uploads/tours/' . $tour->image) }}" class="img-default" alt="tour" style="margin-bottom: 6px;height:250px">
                                </a>
                            </div>
                            <div class="clear"></div>
                            <h4><a href="{{ route('detail-tour', ['slug' => $tour->slug_tours]) }}">{{ $tour->title_tours }}</a></h4>
                            <div class="clear"></div>
                            <div class="group-calendar w100 fl">
                                <div class="col-md-6 col-xs-7 date-start">
                                    <i class="fa fa-calendar"></i> 
                                    @if ($tour->departureDates->isNotEmpty())
                                    {{ \Carbon\Carbon::parse($tour->departureDates->first()->departure_date)->format('d/m/Y') }} 
                                    
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
                                    <span class="lst-icon1"><i class="fa fa-users"></i></span><span> Số chỗ:   @if ($tour->departureDates->isNotEmpty())
                                    {{ $tour->departureDates->first()->available_seats ?? 0 }} <!-- Kiểm tra giá trị 'available_seats' -->
                                @else
                                    0 <!-- Nếu không có ngày khởi hành -->
                                @endif</span>
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
    </div>
</div>

@endsection

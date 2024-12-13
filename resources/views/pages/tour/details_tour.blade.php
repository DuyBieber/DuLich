      @extends('layout')
      @section('content')
      <div class="container box-container-tour">
         <div class="row">
            <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                     @if($tour->tourType && $tour->tourType->category)
                        <li><a href="#">{{ $tour->tourType->category->title }} <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                     @endif
                     @if($tour->tourType)
                        <li><a href="#">{{ $tour->tourType->type_name }} <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                     @endif
                     <li class="active"><a href="#">{{ $tour->title_tours }}</a></li>
            </ul>
         </div>
      </div>
      <div class="container box-container-tour">
         <div class="row">
            <div class="col-md-8 col-xs-12">
               <div class="w100 fl">
               <meta name="csrf-token" content="{{ csrf_token() }}">
                  <form action="{{ URL::to('/add-booking-ajax') }}" method="post" id="bookingForm">
                  {{ csrf_field() }}
                  <h1 class="hone-detail-tour"><i class="fa fa-globe"></i> {{ $tour->title_tours }}</h1>
                  <div class="b-detail-primary w100 fl">
                     <div class="w100 fl desc-dtt">
                        <p></p>
                     </div>
                     <div class="row">
                        <div class="col-md-12 col-xs-12">
                           <div class="w100 fl bimg-dt-left">
                              <div class="box-wap-imgpr-dt">
                              <img alt="{{ $tour->title_tours }}" src="{{ asset('public/uploads/tours/' . $tour->image) }}" width="100%" height="70%">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                           <div class="w100 fl bdesc-dt-right">
                              <div class="col-md-7 col-xs-12 bdesc-dt-right-left">
                                 <table class="table tbct-tour">
                                    <tbody>
                                       <tr>
                                          <td class="td-first" style="text-align: left;">Mã Tour:</td>
                                          <td class="td-second">{{ $tour->tour_code }}</td>
                                       </tr>
                                       <tr>
                                          <td style="text-align: left;">Ngày khởi hành:</td>
                                          <td> {{ \Carbon\Carbon::parse(
            $tour->departureDates->firstWhere('available_seats', '>', 0)?->departure_date 
            ?? $tour->departureDates->first()->departure_date
         )->format('d/m/Y') }}</td>
                                       </tr>
                                       <tr>
                                          <td style="text-align: left;">Thời gian:</td>
                                          <td>{{ $tour->tour_time }}</td>
                                       </tr>
                                       <tr>
                                          <td style="text-align: left;">Xuất phát:</td>
                                          <td>{{ $tour->tour_from }}</td>
                                       </tr>
                                       <tr>
                                          <td style="text-align: left;">Điểm du lịch:</td>
                                          <td>{{ $tour->tour_to }}</td>
                                       </tr>
                                       <td style="text-align: left;">Số chổ:</td>
                                       <td> {{ $tour->departureDates->firstWhere('available_seats', '>', 0)?->available_seats 
            ?? $tour->departureDates->first()->available_seats ?? 0 }}</td>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="col-md-5 col-xs-12 bdesc-dt-right-right">
                                 <div class="bprice-dt-tour">
                                    <div class="giachitu">Giá chỉ từ</div>
                                    <div class="price-dt-tour col-xs-12">
                                    {{ number_format($tour->price, 0, ',', '.') }} VNĐ                                                                                 
                                    </div>
                                    <div class="clbook-dt span12">
    <input type="hidden" value="{{ $tour->id }}" class="booking_tour_id">
    <input type="hidden" value="{{ $tour->title_tours }}" class="booking_tour_name">
    <input type="hidden" value="{{ asset('public/uploads/tours/' . $tour->image) }}" class="booking_tour_image">
    <input type="hidden" value="{{ $tour->price }}" class="booking_tour_price">

    @if(session()->has('customer_id'))
        <!-- Hiển thị nút "Đặt Tour" nếu khách đã đăng nhập -->
        <input type="button" value="Đặt Tour" 
               class="btn btn-primary btn-sm btn-book-tour" 
               data-id="{{ $tour->id }}" 
               data-name="{{ $tour->title_tours }}" 
               data-image="{{ asset('public/uploads/tours/' . $tour->image) }}" 
               data-price="{{ $tour->price }}" 
               data-departure_date="{{ \Carbon\Carbon::parse($tour->departureDates->first()->departure_date)->format('Y-m-d') }}">
    @else
        <!-- Hiển thị thông báo yêu cầu đăng nhập -->
        <div class="alert alert-warning mt-2">
            Vui lòng <a href="{{ route('login') }}">đăng nhập</a> hoặc <a href="{{ route('register') }}">đăng ký</a> để đặt tour.
        </div>
    @endif
</div>

                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="w100 fl"></div>
                  <div class="b-detail-ct-tour w100 fl top-20">
                     <ul class="nav nav-tabs tab-dt-tour">
                        <li class="active"><a data-toggle="tab" href="#home">Chi tiết tour</a></li>
                        <li><a data-toggle="tab" href="#menu1">Giá - Lịch khởi hành</a></li>
                        <li id="tit_tab_booking"><a data-toggle="tab" href="#menu2">Bình luận và đánh giá</a></li>
                     </ul>
                     <div class="tab-content">
                     <div id="home" class="tab-pane fade in active">
    <div class="itinerary">
        @foreach($tour->itineraries->groupBy('day') as $day => $itineraries)
            <div class="day-section">
                <div class="day-destination-header" style="cursor: pointer;" onclick="toggleDetails('details-{{ $day }}')">
                    <div class="day-header">Ngày {{ $day }}: 
                        @foreach($itineraries as $itinerary)
                            {{ $itinerary->location }} 
                        @endforeach
                    </div>
                </div>
                <div id="details-{{ $day }}" class="itinerary-details">
                    @foreach($itineraries as $itinerary)
                        <div class="itinerary-item">
                            <div class="itinerary-description">
                                {!! nl2br(e($itinerary->activity_description)) !!}
                            </div>
                            <div class="itinerary-time">
                                @php
                                    try {
                                        $startTime = \Carbon\Carbon::createFromFormat('H:i', $itinerary->start_time)->format('H:i');
                                        $endTime = \Carbon\Carbon::createFromFormat('H:i', $itinerary->end_time)->format('H:i');
                                    } catch (\Exception $e) {
                                        $startTime = 'N/A';
                                        $endTime = 'N/A';
                                    }
                                @endphp
                                {{ $startTime }} - {{ $endTime }}
                            </div>
                            <div class="itinerary-image">
                                @if($itinerary->img)
                                    <img src="{{ asset('public/uploads/itineraries/' . $itinerary->img) }}" alt="Hình ảnh lịch trình" class="itinerary-img">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
    <div id="menu1" class="tab-pane fade">
        <div class="lichtrinhtour-show">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-tr-header">
                        <th class="thtd-code">STT</th>
                        <th class="thtd-date">Ngày khởi hành</th>
                        <th>Đặc điểm</th>
                        <th>Giá từ</th>
                        <th>Số chỗ</th>
                        <th class="thtd-bookt">Book tour</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($departureDates as $key => $departureDate)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($departureDate->departure_date)->format('d/m/Y') }}</td>
            <td>{{ $departureDate->feature }}</td>
            <td>
                <span class="price-sell">{{ number_format($departureDate->price, 0, ',', '.') }} đ</span>
            </td>
            <td>
                @if ($departureDate->available_seats <= 0)
                    <span class="text-danger">Hết chỗ</span>
                @else
                    {{ $departureDate->available_seats }}
                @endif
            </td>
            <td class="thtd-bookt">
                <!-- Đặt Tour -->
                @if (session()->has('customer_id'))
                    @if ($departureDate->available_seats > 0)
                        <span class="booktour-lichtrinh buy-booking-tour" 
                              style="cursor:pointer;" 
                              data-id="{{ $departureDate->tour_id }}" 
                              data-departure_date="{{ $departureDate->id }}"
                              data-price="{{ $departureDate->price }}">
                            Đặt Tour
                        </span>
                    @else
                        <span class="text-danger" style="pointer-events: none; opacity: 0.5;">Không thể đặt</span>
                    @endif
                @else
                    <span class="text-warning">
                        Vui lòng <a href="{{ route('login') }}">đăng nhập</a> hoặc <a href="{{ route('register') }}">đăng ký</a> để đặt tour.
                    </span>
                @endif

                <!-- Chi tiết giá -->
                <span class="btn-view-details" 
                      style="cursor:pointer" 
                      onclick="showPriceDetails({{ $departureDate->id }})">
                    Chi tiết
                </span>
            </td>
        </tr>
    @endforeach
</tbody>

<!-- Modal Chi tiết giá -->
<div id="priceDetailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi Tiết Giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="priceDetailContent">
                <!-- Nội dung chi tiết giá sẽ được tải vào đây -->
            </div>
        </div>
    </div>
</div>

            </table>
        </div>
        <div class="w100 fl">
                              <div class="row">
                                 <div class="col-xs-12 col-md-6">
                                    <div class="tit-service-attach">Giá dịch vụ bao gồm</div>
                                    <ul class="ul-lst-service-attach">
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/bao-hiem.png"> Bảo hiểm du lịch theo quy định</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/bua-an.png"> Các bữa ăn theo chương trình</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/huong-dan-vien.png"> Hướng dẫn viên suốt chương trình</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/ve-tham-quan.png"> Vé tham quan theo chương trình</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/van-chuyen.png"> Các loại hình vận chuyển theo chương trình</li>
                                    </ul>
                                 </div>
                                 <div class="col-xs-12 col-md-6">
                                    <div class="tit-service-attach">Giá dịch vụ không bao gồm</div>
                                    <ul class="ul-lst-service-attach">
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/ho-chieu.png"> Chứng minh thư, hộ chiếu còn hiệu lực 6 tháng</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/hanh-ly.png"> Phí hành lý quá cước và các chi phí cá nhân</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/ho-chieu.png"> Visa tái nhập cho người nước ngoài(nếu có)</li>
                                       <li><img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/money.png"> Tiền Tip cho hướng dẫn viên địa phương</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
    </div>
    <div id="menu2" class="tab-pane fade">
    <div class="col-xs-12">
        <div class="tit-service-attach">Bình luận đánh giá</div>
        <div id="review-form">
            <input type="hidden" id="tour_id" value="{{ $tour->id }}">
            <div>
                <label for="rating">Đánh giá:</label>
                <div id="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
            </div>
            <input type="hidden" id="rating" value="0">
            <div>
                <label for="comment">Bình luận:</label>
                <textarea id="comment" rows="3" style="width:100%;"></textarea>
            </div>
            <button type="button" onclick="submitReview()">Gửi đánh giá</button>
        </div>
        <div id="review-message"></div>
        
        <div id="review-list">
    <h3>Bình luận:</h3>
    <ul id="reviews">
    @foreach($tour->reviews as $review)
    <li data-review-id="{{ $review->id }}" id="review-item-{{ $review->id }}">
        <strong>{{ $review->customer->customer_name ?? 'Khách hàng' }}:</strong>
        <span>{{ str_repeat('⭐', $review->rating) }}</span>
        <div class="comment" data-comment-id="{{ $review->id }}">
            <p id="review-comment-{{ $review->id }}">{{ $review->comment }}</p>
            @if(session('customer_id') === $review->customer_id)
            <button type="button" onclick="editReview({{ $review->id }})">Chỉnh sửa</button>
            <button type="button" onclick="deleteReview({{ $review->id }})">Xóa</button>
            @endif
        </div>
        @if($review->admin_reply)
            <div class="admin-reply">
                <strong>Trả lời từ Admin:</strong>
                <p>{{ $review->admin_reply }}</p>
            </div>
        @endif
    </li>
@endforeach

</ul>

</div>

    </div>
</div>

<style>
    #star-rating .star {
        font-size: 2em;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s;
    }
    #star-rating .star.selected,
    #star-rating .star:hover,
    #star-rating .star:hover ~ .star {
        color: #f5b301;
    }
</style>



</div>
<script>
    function showPriceDetails(departureDateId) {
    $.ajax({
        url: '/get-price-details',
        method: 'GET',
        data: { departure_date_id: departureDateId },
        success: function(response) {
            $('#priceDetailContent').html(response.html);
            $('#priceDetailModal').modal('show');
        },
        error: function() {
            alert('Không thể tải chi tiết giá. Vui lòng thử lại sau.');
        }
    });
}
</script>
<script>
    function toggleDetails(dayId) {
        var details = document.getElementById(dayId);
        if (details.style.display === "none") {
            details.style.display = "block"; // Hiện nội dung
        } else {
            details.style.display = "none"; // Ẩn nội dung
        }
    }
</script>

                  </div>
               </div>
               <div class="row">
                  
               </div>
            </div>
            <div class="col-md-4 col-xs-12 bx-right-bar">
               <div class="w100 fl top-15 box-cldl">
                  
               </div>
               <div class="w100 fl box-lst-tour-sidebar">
    <div class="w100 fl tit-child-larg">
        <h2>Tour Liên Quan</h2>
    </div>
    <div class="clear"></div>
    <ul class="ul-lst-t-right">
       @if($relatedTours->isEmpty())
    <p>Không có tour liên quan.</p>
@else
    <ul class="ul-lst-t-right">
        @foreach ($relatedTours as $relatedTour)
            <li>
                <div class="w100 fl bx-wap-pr-item" style="height: 440px;">
                    <div class="clearfix box-wap-imgpr">
                        <a href="{{ route('detail-tour', $relatedTour->slug_tours) }}">
                            <img src="{{ asset('public/uploads/tours/' . $relatedTour->image) }}" class="list-relation-pr img-default" alt="{{ $relatedTour->title_tours }}" style="height:250px">
                        </a>
                    </div>
                    <div class="clear"></div>
                    <h4><a href="{{ route('detail-tour', $relatedTour->slug_tours) }}">{{ $relatedTour->title_tours }}</a></h4>
                    <div class="clear"></div>
                    <div class="group-calendar w100 fl">
                        <div class="col-md-6 col-xs-7 date-start">
                            <span class="lst-icon1"><i class="fa fa-calendar"></i></span>
                            <span>{{ \Carbon\Carbon::parse($relatedTour->departure_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="col-md-6 col-xs-5 date-range">
                            <span class="lst-icon1"><i class="fa fa-clock-o"></i></span><span> {{ $relatedTour->tour_time }}</span>
                        </div>
                    </div>
                    <div class="group-localtion w100 fl">
                        <div class="col-md-6 col-xs-7 map-maker">
                            <span class="lst-icon1"><i class="fa fa-map-marker"></i></span><span> {{ $relatedTour->tour_from }}</span>
                        </div>
                        <div class="col-md-6 col-xs-5 numner-sit">
                            <span class="lst-icon1"><i class="fa fa-users"></i></span><span> {{ $relatedTour->departureDates->firstWhere('available_seats', '>', 0)?->available_seats 
            ?? $relatedTour->departureDates->first()->available_seats ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="note-attack"><i class="fa fa-bell" aria-hidden="true"></i> Khuyến mãi 200K cho nhóm khách 5 người trở lên</div>
                    <div class="group-book w100 fl">
                        <span class="price-sell">{{ number_format($relatedTour->price, 0, ',', '.') }} VNĐ </span>
                        <a href="{{ route('detail-tour', $relatedTour->slug_tours) }}" class="link-book">Xem chi tiết</a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif

    </ul>
</div>


            </div>
         </div>
      </div>
      <style>
         ul.heateor_sss_sharing_ul {
         list-style: none!important;
         padding-left: 0!important;
         }
         ul.heateor_sss_sharing_ul li {
         float: left!important;
         margin: 0!important;
         padding: 0!important;
         list-style: none!important;
         border: none!important;
         clear: none!important;
         }
         .heateorSssSharing {
         float: left;
         border: none;
         }
         .heateorSssSharing, .heateorSssSharingButton {
         display: block;
         cursor: pointer;
         margin: 2px;
         }
         .heateorSssSharingSvg {
         width: 100%;
         height: 100%;
         }
         .heateorSssTwitterBackground {
         background-color: #55acee;
         }
         .heateorSssTwitterSvg {
         background: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%20viewBox%3D%22-4%20-4%2039%2039%22%3E%0A%3Cpath%20d%3D%22M28%208.557a9.913%209.913%200%200%201-2.828.775%204.93%204.93%200%200%200%202.166-2.725%209.738%209.738%200%200%201-3.13%201.194%204.92%204.92%200%200%200-3.593-1.55%204.924%204.924%200%200%200-4.794%206.049c-4.09-.21-7.72-2.17-10.15-5.15a4.942%204.942%200%200%200-.665%202.477c0%201.71.87%203.214%202.19%204.1a4.968%204.968%200%200%201-2.23-.616v.06c0%202.39%201.7%204.38%203.952%204.83-.414.115-.85.174-1.297.174-.318%200-.626-.03-.928-.086a4.935%204.935%200%200%200%204.6%203.42%209.893%209.893%200%200%201-6.114%202.107c-.398%200-.79-.023-1.175-.068a13.953%2013.953%200%200%200%207.55%202.213c9.056%200%2014.01-7.507%2014.01-14.013%200-.213-.005-.426-.015-.637.96-.695%201.795-1.56%202.455-2.55z%22%20fill%3D%22%23fff%22%3E%3C%2Fpath%3E%0A%3C%2Fsvg%3E') no-repeat center center;
         }
         .heateorSssLinkedinBackground {
         background-color: #0077B5;
         }
         .heateorSssLinkedinSvg {
         background: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%20viewBox%3D%22-2%20-2%2035%2039%22%3E%3Cpath%20d%3D%22M6.227%2012.61h4.19v13.48h-4.19V12.61zm2.095-6.7a2.43%202.43%200%200%201%200%204.86c-1.344%200-2.428-1.09-2.428-2.43s1.084-2.43%202.428-2.43m4.72%206.7h4.02v1.84h.058c.56-1.058%201.927-2.176%203.965-2.176%204.238%200%205.02%202.792%205.02%206.42v7.395h-4.183v-6.56c0-1.564-.03-3.574-2.178-3.574-2.18%200-2.514%201.7-2.514%203.46v6.668h-4.187V12.61z%22%20fill%3D%22%23fff%22%2F%3E%3C%2Fsvg%3E') no-repeat center center;
         }
         .heateorSssPinterestBackground {
         background-color: #CC2329;
         }
         .heateorSssPinterestSvg {
         background: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%20viewBox%3D%22-2%20-2%2035%2035%22%3E%3Cpath%20fill%3D%22%23fff%22%20d%3D%22M16.539%204.5c-6.277%200-9.442%204.5-9.442%208.253%200%202.272.86%204.293%202.705%205.046.303.125.574.005.662-.33.061-.231.205-.816.27-1.06.088-.331.053-.447-.191-.736-.532-.627-.873-1.439-.873-2.591%200-3.338%202.498-6.327%206.505-6.327%203.548%200%205.497%202.168%205.497%205.062%200%203.81-1.686%207.025-4.188%207.025-1.382%200-2.416-1.142-2.085-2.545.397-1.674%201.166-3.48%201.166-4.689%200-1.081-.581-1.983-1.782-1.983-1.413%200-2.548%201.462-2.548%203.419%200%201.247.421%202.091.421%202.091l-1.699%207.199c-.505%202.137-.076%204.755-.039%205.019.021.158.223.196.314.077.13-.17%201.813-2.247%202.384-4.324.162-.587.929-3.631.929-3.631.46.876%201.801%201.646%203.227%201.646%204.247%200%207.128-3.871%207.128-9.053.003-3.918-3.317-7.568-8.361-7.568z%22%2F%3E%3C%2Fsvg%3E') no-repeat center center;
         }
         .heateorSssMeWeBackground {
         background-color: #007da1;
         }
         .heateorSssMeWeSvg {
         background: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%22-3%20-3%2038%2038%22%3E%3Cg%20fill%3D%22%23fff%22%3E%3Cpath%20d%3D%22M9.636%2010.427a1.22%201.22%200%201%201-2.44%200%201.22%201.22%200%201%201%202.44%200zM15.574%2010.431a1.22%201.22%200%200%201-2.438%200%201.22%201.22%200%201%201%202.438%200zM22.592%2010.431a1.221%201.221%200%201%201-2.443%200%201.221%201.221%200%200%201%202.443%200zM29.605%2010.431a1.221%201.221%200%201%201-2.442%200%201.221%201.221%200%200%201%202.442%200zM3.605%2013.772c0-.471.374-.859.859-.859h.18c.374%200%20.624.194.789.457l2.935%204.597%202.95-4.611c.18-.291.43-.443.774-.443h.18c.485%200%20.859.387.859.859v8.113a.843.843%200%200%201-.859.845.857.857%200%200%201-.845-.845V16.07l-2.366%203.559c-.18.276-.402.443-.72.443-.304%200-.526-.167-.706-.443l-2.354-3.53V21.9c0%20.471-.374.83-.845.83a.815.815%200%200%201-.83-.83v-8.128h-.001zM14.396%2014.055a.9.9%200%200%201-.069-.333c0-.471.402-.83.872-.83.415%200%20.735.263.845.624l2.23%206.66%202.187-6.632c.139-.402.428-.678.859-.678h.124c.428%200%20.735.278.859.678l2.187%206.632%202.23-6.675c.126-.346.415-.609.83-.609.457%200%20.845.361.845.817a.96.96%200%200%201-.083.346l-2.867%208.032c-.152.43-.471.706-.887.706h-.165c-.415%200-.721-.263-.872-.706l-2.161-6.328-2.16%206.328c-.152.443-.47.706-.887.706h-.165c-.415%200-.72-.263-.887-.706l-2.865-8.032z%22%3E%3C%2Fpath%3E%3C%2Fg%3E%3C%2Fsvg%3E') no-repeat center center;
         }
         .heateorSssMixBackground {
         background-color: darkgray !important;
         }
         .heateorSssWhatsappBackground {
         background-color: #55EB4C;
         }
      </style>
@endsection
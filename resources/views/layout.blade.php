
</script>
<!DOCTYPE html>
<html lang="en">
   <head>
     
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <link href="{{asset('frontend/css/jquery-ui.min.css')}}" rel="stylesheet">
      <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{asset('frontend/css/owl.carousel.css')}}" rel="stylesheet">
      <link href="{{asset('frontend/css/menu-mobile.min.css')}}" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
      <link href="{{asset('frontend/css/slider.css" rel="stylesheet')}}" type="text/css">
      <link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
      <link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('frontend/css/default.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/light.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/dark.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/bar.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/bar1.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/bar2.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/bar3.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/bar4.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/bar5.css')}}" type="text/css" media="screen" />
      <link rel="stylesheet" href="{{asset('frontend/css/nivo-slider.css')}}" type="text/css" media="screen" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
      <script src="{{asset('frontend/js/jquery-1.11.1.min.js')}}"></script>
      <script src="{{asset('frontend/js/jquery-ui.js')}}"></script>
      <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('frontend/js/script.js')}}"></script>
      <script src="{{asset('frontend/js/owl.carousel.min.js')}}" type="text/javascript"></script>
      <script src="https://apis.google.com/js/platform.js" async defer></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
      <!-- Js menu mobile-->
      <script>
         $(document).ready(function(e) {
             $(".arrown_menu_accordion").click(function() {
                 var val=$(this).attr("val");
                 $("#"+val).toggle();
             });
         });
      </script> 	
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>			
      <script src="{{asset('frontend/js/frame_script.js')}}"></script>
      <script type="text/javascript" src="{{asset('frontend/js/jquery.nivo.slider.js')}}"></script>
      <script type="text/javascript">
         $(window).load(function() {
             $('#slider').nivoSlider();
         });
      </script>
      <script type="application/ld+json">
         "@context" : "https://schema.org/"
      </script>
      <script type="application/ld+json">
         {
             "@context": "http:\/\/schema.org",
             "@type": "LocalBusiness",
             "name": "Spatie",
             "email": "info@spatie.be",
             "contactPoint": {
                 "@type": "ContactPoint",
                 "areaServed": "Worldwide"
             }
         }
      </script>
      <script type="text/javascript">
         jQuery(document).ready(function () {
         	$(".owl-carousel5").owlCarousel({
         		pagination: false,
         		navigation: true,
         		items: 2,
         		autoPlay:true,
         		slideMargin:10,
         		addClassActive: true,
         		itemsCustom : [
         			[0, 1],
         			[320, 1],
         			[480, 1],
         			[660, 2],
         			[700, 2],
         			[768, 2],
         			[992, 2],
         			[1024, 2],
         			[1200, 2],
         			[1400, 2],
         			[1600, 2]
         		]
         	});
         });
      </script>
   </head>
   <bod>
     
      <header id="header-web">
         <div class="header-top w100">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-xs-12 top-5">
                     <div class="cl-logo fl">
                        <h1 class="logo">
                        <a href="{{URL::to('/trang-chu')}}">
                              <img src="{{asset('frontend/imgs/logo.png')}}" alt="logo" />
                           </a>
                        </h1>
                     </div>
                     <div class="cl-bnt fl">
                        <div class="banner-top">
                           <a href="{{URL::to('/trang-chu')}}"><img src="{{asset('frontend/imgs/d2.png')}}" alt="banner top"></a>
                        </div>
                     </div>
                     <div class="cl-right-lang fr">
                        <div class="bx-lang-rh">
                        <ul class="menu-account">
    <li class="menu-item account-dropdown">
        <a href="#" class="account-toggle">
            <i class="fas fa-user"></i>
            <span class="account-text">
                @if (Session::has('customer_name'))
                    {{ Session::get('customer_name') }}
                @else
                    Tài khoản
                @endif
            </span>
        </a>
        <ul class="account-dropdown-menu">
            @if (Session::has('customer_id'))
                <li class="dropdown-item">
                    <a href="{{ route('customer.profile') }}">
                        <i class="fas fa-tachometer-alt"></i> Trang cá nhân
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="{{ route('my.bookings') }}">
                        <i class="fas fa-book"></i> Xem các tour đã đặt
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="{{ route('customer.wallet') }}">
                        <i class="fas fa-ticket-alt"></i> Ví Mã Giảm Giá
                    </a>
                </li>
                <li class="dropdown-item">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: inherit; padding: 0;">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </button>
                    </form>
                </li>
            @else
                <li class="dropdown-item">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                </li>
                <h6 style="width: 100%; float: left; font-size: 12px; margin-top: 7px; font-weight: 600;">
                    Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a> để đặt tour
                </h6>
            @endif
        </ul>
    </li>
    <li class="menu-item account-dropdown">
        <img alt="du lịch" src="https://vietnamtravel.net.vn/assets/desktop/images/vn.png">
        <span>VIỆT NAM</span>
    </li>
</ul>


                           <div class="hot-line-rh">
                                 <a class="title-r1h" href="tel:">Hotline hỗ trợ 24/7</a>
                                 <a class="hotline-r1h" href="tel:">098 667733</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="header-bottom">
            <a class="icon_menu_mobile" href="javascript:void(0)" val="0" rel="nofollow"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-xs-12 box-mainmenu">
                     <nav class="menunav">
<ul class="ulwap-mainmenu">
    <li><a href="{{ route('home') }}" class="mn-home"><i class="fa fa-home"></i></a></li>
   

        @foreach($categories as $category)
            <li class="megamenusub" style="border-color:white">
                 <a href="{{ route('tour.by.category', ['slug' =>  $category->slug]) }}">
                {{ $category->title }}
                </a>

                 @if($category->tourTypes->count())
                <ul>
                    @foreach($category->tourTypes as $tourType)
                        @if(!$tourType->slug)
                            <li>Slug không có!</li>
                        @else
                            <li style="border-color:white">
                                <a href="{{ route('tour.type', ['slug' => $tourType->slug]) }}">
                                    <i class="fa fa-map-marker"></i> {{ $tourType->type_name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
       
        @endforeach
        <li class="discount-code"><a href="{{ route('customer.coupons') }}">Mã Giảm Giá</a></li>

   
    
   
</ul>
                     </nav>
                     <div class="line-menu"></div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      @if (Route::currentRouteName() == 'home')
      <div class="container-fluid">
    <div class="slider-wrapper theme-default">
        <div id="slider-master" class="nivoSlider">
            @foreach($sliders as $slider)
                @if($slider->slider_status)
                    <!-- Kiểm tra xem slider có liên kết với tour hay không -->
                    @if($slider->tour)
                        <!-- Nếu có tour liên kết, tạo liên kết đến chi tiết tour -->
                        <a href="{{ route('detail-tour', ['slug' => $slider->tour->slug_tours]) }}">
                            <img src="{{ asset('uploads/slider/' . $slider->slider_image) }}" alt="{{ $slider->slider_name }}" style="width:250px; height:200px;"/>
                        </a>
                    @else
                        <!-- Nếu không có tour liên kết, chỉ hiển thị ảnh -->
                        <img src="{{ asset('uploads/slider/' . $slider->slider_image) }}" alt="{{ $slider->slider_name }}" style="width:250px; height:200px;"/>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>

@endif

<div class="container" id="form-search">
    <div class="row">
        <div class="w100 fl bx-wap-form-search">
            <form method="GET" action="{{ route('tours.search') }}" accept-charset="UTF-8">
            <div class="row" style="display: flex; flex-wrap: nowrap; justify-content: center; align-items: center;">
                    <!-- Input Tìm kiếm tên tour -->
                    <div class="form-group col-md-2 col-xs-12" style="flex: 0 0 15%;">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm tên tour" value="{{ request('keyword') }}">
                    </div>
                    
                    <!-- Dropdown cho danh mục -->
                    <div class="form-group col-md-2 col-xs-12" style="flex: 0 0 15%;">
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Dropdown cho loại tour -->
                    <div class="form-group col-md-2 col-xs-12" style="flex: 0 0 15%;">
                        <select class="form-control loaitourchose" name="tour-type" id="tour-type">
                            <option value="">Loại Tour</option>
                            @foreach ($tourTypes as $type)
                                <option value="{{ $type->id }}" {{ request('tour-type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Dropdown cho địa điểm -->
                    <div class="form-group col-md-2 col-xs-12" style="flex: 0 0 15%;">
                        <select name="location_id" class="form-control">
                            <option value="">Địa điểm</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Input cho giá tối thiểu -->
                    <div class="form-group col-md-2 col-xs-12" style="flex: 0 0 15%;">
                        <input type="number" name="price_min" class="form-control" placeholder="Giá tối thiểu" value="{{ request('price_min') }}">
                    </div>
                    
                    <!-- Input cho giá tối đa -->
                    <div class="form-group col-md-2 col-xs-12" style="flex: 0 0 15%;">
                        <input type="number" name="price_max" class="form-control" placeholder="Giá tối đa" value="{{ request('price_max') }}">
                    </div>
                    
                    <div class="form-group col-md-2 col-xs-12 bx-fr-right" style="flex: 0 0 10%;">
                        <button type="submit" class="btn btn-red">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>






         </div>
      </div>
      @yield('content')
      </div>
     <button class="chatbot-toggler">
        <span class="material-symbols-rounded">mode_comment</span>
        <span class="material-symbols-outlined">close</span>
    </button>
    <div class="chatbot">
        <header>
            <h2>DUYTRAVEL xin chào! <br>
            Chúng tôi sẵn sàng trả lời câu hỏi của bạn.</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <!-- Hiển thị trực tiếp phần chatbox và input -->
        <ul class="chatbox" id="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p id="welcomeMessage">Xin chào 👋<br>Bạn muốn tìm hiểu gì về DUYTRAVEL</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Enter a message ..." spellcheck="false" required></textarea>
            <span id="send-btn" class="material-symbols-rounded">send</span>
        </div>
    </div>
      <div class="container box-post-home top-15">
         <div class="row">
           
            <div class="col-md-8 col-xs-12 bx-child-ph bx-child-ph2">
               <div class="w100 fl tit-child-larg">
                  <h2 class="not-icon">Tai sao chọn DUYTRAVEL</h2>
               </div>
               <div class="w100 fl item-lst-pos2">
                  <a href="#"><img src="{{asset('frontend/imgs/Untitled-1.jpg')}}" alt="Tốp 10 công ty du lịch hàng đầu  hàng đầu"></a>
                  <a href="#" class="ctlist-right">
                     <h4>Top 10 công ty du lịch hàng đầu  hàng đầu</h4>
                     <p>Vietnam Travel&nbsp;được vinh danh tại giải thưởng&nbsp;du lịch&nbsp;danhh gi&aacute; World Travel Awards với danh hiệu Nh&agrave;...</p>
                  </a>
               </div>
               <div class="w100 fl item-lst-pos2">
                  <a href="#"><img src="{{asset('frontend/imgs/18_kinhnghiem_vn.jpg')}}" alt="Hơn 18 năm kinh nghiệm"></a>
                  <a href="#" class="ctlist-right">
                     <h4>Hơn 18 năm kinh nghiệm</h4>
                     <p>Với 18 năm&nbsp;kinh nghiệm&nbsp;trong lĩnh vực lữ h&agrave;nh, ... mong muốn mang đến cho kh&aacute;ch h&agrave;ng những chuyến...</p>
                  </a>
               </div>
               <div class="w100 fl item-lst-pos2">
                  <a href="#"><img src="{{asset('frontend/imgs/uytin_24_7.jpg')}}" alt="Dịch vụ 24/7"></a>
                  <a href="#" class="ctlist-right">
                     <h4>Dịch vụ 24/7</h4>
                     <p>Đội ngũ c&aacute;n bộ nh&acirc;n vi&ecirc;n nhiệt t&igrave;nh&nbsp;v&agrave; s&aacute;ng tạo. Phục vụ kh&aacute;ch h&agrave;ng tận...</p>
                  </a>
               </div>
            </div>
            <div class="col-md-4 col-xs-12 bx-child-ph bx-child-ph3">
               <div class="w100 fl tit-child-larg">
                  <h2 class="not-icon">Hình ảnh chuyến đi</h2>
               </div>
               <ul class="lst-thumb-video-home top-15" >
                  <li><img src="{{asset('frontend/imgs/image1.png')}}" alt="2"></li>
                  <li><img src="{{asset('frontend/imgs/image2.png')}}" alt="2" ></li>
                  <li><img src="{{asset('frontend/imgs/image.png')}}" alt="2" ></li>
               </ul>
            </div>
         </div>
      </div>
      <div id="footer" class="footer w100 fl top-20">
         <div class="container">
            <div class="row">
               <div class="col-md-9 col-xs-12">
                  <div class="row">
                     <div class="col-md-4 col-xs-12">
                        <div class="w100 fl tit-child-larg">
                           <h2 class="h2titfoot not-icon">Liên hệ với duytravel </h2>
                        </div>
                        <ul class="ulfooter-contact">
                           <li><i class="fa fa-map-marker"></i> 106 Đường Hai Bà Trưng, Tân An, Ninh Kiều, Cần Thơ, Việt Nam</li>
                           <li><i class="fa fa-phone"></i> (098) 667 - 733 ; (0243) 66 7733</li>
                           <li><i class="fa fa-fax"></i> Fax: (024) 3366 7733</li>
                           <li><i class="fa fa-envelope" aria-hidden="true"></i> duytravel@gmail.com</li>
                        </ul>
                       
                     </div>
                     <div class="col-md-8 col-xs-12">
                        <div class="w100 fl tit-child-larg">
                           <h2 class="h2titfoot not-icon">Văn phòng</h2>
                        </div>
                        <div class="row">
                           <div class="col-md-6 col-xs-12">
                              <ul class="ulfooter-contact w50">
                                 <li><i class="fa fa-map-marker"></i> 106 Đường Hai Bà Trưng, Tân An, Ninh Kiều, Cần Thơ, Việt Nam</li>
                                 <li><i class="fa fa-phone"></i> (0904) 677- 356 ; (0904) 877- 548</li>
                                 <li><i class="fa fa-fax"></i> Fax: (025) 1238 86569</li>
                                 <li><i class="fa fa-envelope" aria-hidden="true"></i> ceocantho.duytravel@gmail.com</li>
                              </ul>
                             
                           </div>
                           <div class="col-md-6 col-xs-12">
                              <ul class="ulfooter-contact w50">
                                 <li><i class="fa fa-map-marker"></i> 18E Đường Cộng Hòa (Republic Plaza), Phường 4, Quận Tân Bình, Hồ Chí Minh</li>
                                 <li><i class="fa fa-phone"></i>  (098) 333 - 1844 ; (028) 2880 8086</li>
                                 <li><i class="fa fa-fax"></i> Fax: (028) 2110 22011</li>
                                 <li><i class="fa fa-envelope"></i> ceosaigon.duytravel@gmail.com</li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     
                  </div>
               </div>
               <div class="col-md-3 col-xs-12">
                  <div class="w100 fl">
                     <div class="w100 fl tit-child-larg">
                        <h2 class="h2titfoot not-icon">Kết nối với chúng tôi</h2>
                     </div>
                     <div class="fb-page" data-href="#" data-small-header="false" data-adapt-container-width="true"  data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
                        <div class="fb-xfbml-parse-ignore">
                           <blockquote cite="https://www.facebook.com/vietnamtravel.net.vn/"><a href="https://www.facebook.com/vietnamtravel.net.vn/">Du lịch Việt nam - DuyTravel</a></blockquote>
                        </div>
                     </div>
                     <div class="clear"></div>
                     <ul class="ullstsocial">
                        <li><a href=""><i class="fa fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href=""><i class="fa fa-behance"></i></a></li>
                        <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                     </ul>
                  </div>
                  <div class="w100 fl">
                     <div class="w100 fl tit-child-larg">
                        <h2 class="h2titfoot not-icon">Phương thức thanh toán</h2>
                     </div>
                     <ul class="ulfooter-contact2 w50">
                        <li><a href="">1/ thanh toán trực tiếp tại văn phòng công ty hoặc các chi nhánh</a></li>
                        <li><a href="">2/ thanh toán tận nơi: HDV sẽ thu tiền tận nơi gần khu vực trung tâm</a></li>
                        <li><a href="">3/ thanh toán chuyển khoản</a></li>
                        <li><a href="">4/ thanh toán qua cổng thanh toán trực tiếp</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="container top-25">
            <div class="row">
               <div class="col-md-6 col-xs-12">
                  <div class="w100 fl tit-child-larg">
                     <h2 class="h2titfoot">Các Giải thưởng đã đạt được</h2>
                  </div>
                  <a href="#"><img src="https://vietnamtravel.net.vn/assets/desktop/images/huychuong.png" class="hcfot" alt="hc"></a>
               </div>
              
            </div>
         </div>
      </div>
      <div class="hotline-footer">
         <span class="hf-icon"></span>
         <div class="hf-text">
            Hotline trong nước : <spa>(098) 667733</span>
         </div>
      </div>
      <div class="prdcontact-fix">
         <ul>
            <li class="actCall">
               <a href="(098) 667733">
               <img alt="du lịch" src="https://file4.batdongsan.com.vn/images/opt/mobile/newphone.png">
               </a>
            </li>
            <li class="actSms">
               <a href="tel:0913073026">
               <img alt="du lịch" src="https://file4.batdongsan.com.vn/images/opt/mobile/newsms.png">
               </a>
            </li>
            <li>
               <a href="mailto:vietnamtravel1234@gmail.com">
               <img alt="du lịch" src="https://file4.batdongsan.com.vn/images/opt/mobile/newemail1.png" style="margin: 2px 0;">
               </a>
            </li>
         </ul>
      </div>
      
      <script>
         document.addEventListener("DOMContentLoaded", function(event) {
            jQuery('a[href*="tel:"]').on('click', function() {
               gtag('event', 'conversion', {'send_to': 'AW-882166916/ExQfCPj98KIBEISZ06QD'});
            });
         });
      </script>
<script>
$(document).ready(function(){
    // Thiết lập CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Xử lý sự kiện click của nút đặt tour với lịch trình cố định
    $('.btn-book-tour').click(function(e){
        e.preventDefault();
        var tour_id = $(this).data('id');
        var tour_name = $(this).data('name');
        var tour_image = $(this).data('image');
        var tour_price = $(this).data('price');
        var tour_qty = 1;
        var departure_date = $(this).data('departure_date');
        var available_seats = $(this).data('available_seats');

        $.ajax({
            url: '{{ URL::to("/add-checkout-booking-ajax") }}',
            method: 'POST',
            data: {
                booking_tour_id: tour_id,
                booking_tour_name: tour_name,
                booking_tour_image: tour_image,
                booking_tour_price: tour_price,
                booking_tour_qty: tour_qty,
                booking_tour_departure_date: departure_date,
                booking_type: 'fixed'
            },
            success: function(response){
                if(response.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ url('/show-checkout-booking/fixed') }}/" + tour_id;
                        }
                    });
                } else if (response.duplicate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lịch khởi hành đã được đặt trước!',
                        text: response.message,
                        showCancelButton: true,
                        confirmButtonText: 'Tiếp tục',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ URL::to("/add-checkout-booking-ajax") }}',
                                method: 'POST',
                                data: {
                                    booking_tour_id: tour_id,
                                    booking_tour_name: tour_name,
                                    booking_tour_image: tour_image,
                                    booking_tour_price: tour_price,
                                    booking_tour_qty: tour_qty,
                                    booking_tour_departure_date: departure_date,
                                    force_add: true,
                                    booking_type: 'fixed'
                                },
                                success: function(response){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công!',
                                        text: 'Tour đã được đặt lại.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = "{{ url('/show-checkout-booking/fixed') }}/" + tour_id;
                                    });
                                }
                            });
                        }
                    });
                } else {
                    alert('Đã xảy ra lỗi khi đặt tour.');
                }
            },
            error: function(){
                alert('Lỗi kết nối đến server.');
            }
        });
    });

    // Xử lý sự kiện click của nút đặt tour với lịch trình khác
    $('.buy-booking-tour').on('click', function () {
        var tourId = $(this).data('id');
        var departureDateId = $(this).data('departure_date');
        var price = $(this).data('price');
        var quantity = 1;

        $.ajax({
            url: '{{ URL::to("/add-checkout-booking-other-ajax") }}',
            type: 'POST',
            data: {
                booking_tour_id: tourId,
                booking_tour_time: departureDateId,
                booking_tour_qty: quantity,
                booking_tour_price: price,
                booking_type: 'other'
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ url('/show-checkout-booking/other') }}/" + tourId + "/" + departureDateId;
                        }
                    });
                } else if (response.duplicate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lịch khởi hành đã được đặt trước!',
                        text: response.message,
                        showCancelButton: true,
                        confirmButtonText: 'Tiếp tục',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ URL::to("/add-checkout-booking-other-ajax") }}',
                                type: 'POST',
                                data: {
                                    booking_tour_id: tourId,
                                    booking_tour_time: departureDateId,
                                    booking_tour_qty: quantity,
                                    booking_tour_price: price,
                                    force_add: true,
                                    booking_type: 'other'
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công!',
                                        text: 'Tour đã được đặt lại.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = "{{ url('/show-checkout-booking/other') }}/" + tourId + "/" + departureDateId;
                                    });
                                }
                            });
                        }
                    });
                } else {
                    alert('Có lỗi xảy ra');
                }
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra: ' + xhr.responseText);
            }
        });
    });
});
</script>



<script>
   // Giả định currentUserId là ID của người dùng hiện tại (cần được gán từ server-side)
const currentUserId = {{ session('customer_id') }}; // Cần thay thế bằng giá trị ID từ server-side

// Hàm gửi đánh giá
function submitReview() {
    const tourId = document.getElementById('tour_id').value;
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (rating === "0") {
        document.getElementById('review-message').innerHTML = `<p style="color: red;">Vui lòng chọn đánh giá sao!</p>`;
        return;
    }

    fetch('{{ route('review.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            tour_id: tourId,
            rating: rating,
            comment: comment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            document.getElementById('review-message').innerHTML = `<p style="color: red;">${data.error}</p>`;
        } else {
            document.getElementById('review-message').innerHTML = `<p style="color: green;">${data.success}</p>`;
            document.getElementById('comment').value = '';
            document.getElementById('rating').value = "0";
            renderReviewItem(data.review); // Render bình luận mới
        }
    })
    .catch(error => console.error('Error:', error));
}

// Hàm hiển thị một bình luận
function renderReviewItem(review) {
    const reviewsContainer = document.getElementById('reviews');
    const reviewItem = document.createElement('li');
    reviewItem.id = `review-item-${review.id}`;
    reviewItem.innerHTML = `
        <strong>${review.customer_name}:</strong>
        <span>${'⭐'.repeat(review.rating)}</span>
        <p id="review-comment-${review.id}">${review.comment}</p>
    `;

    // Chỉ hiển thị nút chỉnh sửa và xóa nếu là bình luận của chính người dùng
    if (review.user_id === currentUserId) { 
        const editButton = document.createElement('button');
        editButton.innerText = 'Chỉnh sửa';
        editButton.onclick = () => editReview(review.id);

        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Xóa';
        deleteButton.onclick = () => deleteReview(review.id);

        reviewItem.appendChild(editButton);
        reviewItem.appendChild(deleteButton);
    }

    reviewsContainer.appendChild(reviewItem);
}

// Hàm chỉnh sửa bình luận
function editReview(reviewId) {
    const reviewComment = document.getElementById(`review-comment-${reviewId}`);
    const originalComment = reviewComment.innerText;

    // Thay thế nội dung bình luận bằng một ô input
    reviewComment.innerHTML = `
        <input type="text" id="edit-input-${reviewId}" value="${originalComment}">
        <button  type="button" onclick="saveEditedReview(${reviewId})">Lưu</button>
        <button  type="button" onclick="cancelEdit(${reviewId}, '${originalComment}')">Hủy</button>
    `;
}

function saveEditedReview(reviewId) {
    const newComment = document.getElementById(`edit-input-${reviewId}`).value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/edit-comment/${reviewId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            content: newComment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            document.getElementById(`review-comment-${reviewId}`).innerText = newComment;
        }
    })
    .catch(error => console.error('Error:', error));
}

function cancelEdit(reviewId, originalComment) {
    // Khôi phục lại bình luận ban đầu nếu hủy
    document.getElementById(`review-comment-${reviewId}`).innerText = originalComment;
}

// Hàm xóa bình luận
function deleteReview(reviewId) {
    if (!confirm("Bạn có chắc chắn muốn xóa bình luận này không?")) {
        return;
    }
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/delete-comment/${reviewId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            document.getElementById(`review-item-${reviewId}`).remove();
            alert(data.success);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Khởi tạo sự kiện cho các sao
const stars = document.querySelectorAll('#star-rating .star');
stars.forEach(star => {
    star.addEventListener('click', () => {
        stars.forEach(s => s.classList.remove('selected'));
        star.classList.add('selected');
        let prevStar = star.previousElementSibling;
        while (prevStar) {
            prevStar.classList.add('selected');
            prevStar = prevStar.previousElementSibling;
        }
        document.getElementById('rating').value = star.getAttribute('data-value');
    });
});


    
</script>

<script>
      $(function(){
          var offset = 115;
          $(window).scroll(function() {
              if ($(this).scrollTop() > offset) {
                  $('.header-bottom').addClass('fixed');
              } else {
                  $('.header-bottom').removeClass('fixed');
              }
          });
          if($(window).scrollTop() > offset) {
              $('.header-bottom').addClass('fixed');
          } else {
              $('.header-bottom').removeClass('fixed');
          }
      });
   </script>
   <script>
      jQuery(document).ready(function() {
          var offset = 20;
          var duration = 300;
          jQuery(window).scroll(function() {
              if (jQuery(this).scrollTop() > offset) {
                  jQuery('.back-to-top').fadeIn(duration);
              } else {
                  jQuery('.back-to-top').fadeOut(duration);
              }
          });x
      
          jQuery('.back-to-top').click(function(event) {
              event.preventDefault();
              jQuery('html, body').animate({scrollTop: 0}, duration);
              return false;
          })
      });
   </script>
    <script type="text/javascript" src="js/jquery.nivo.slider.js"></script>
      <script type="text/javascript">
         $(window).load(function() {
             $('#slider-master').nivoSlider({
                 controlNav : false,
             });
         });
      </script>
      <style>
         #chose-option-diemden-nd.hidden-select, #chose-option-diemden-qt.hidden-select, #chose-option-diemden-empty.hidden-select {
         display: none;
         }
         #chose-option-diemden-nd.show-select, #chose-option-diemden-qt.show-select, #chose-option-diemden-empty.show-select {
         display: inline;
         }
      </style>
      <script>
         $(document).ready(function(){
             $('.loaitourchose').change(function() {
                 var loaitourval = $(this).val();
                 if(loaitourval == 'trongnuoc') {
                     if($('#chose-option-diemden-nd').hasClass('hidden-select')) {
                         $('#chose-option-diemden-nd').removeClass('hidden-select');
                     }
                     $('#chose-option-diemden-nd').addClass('show-select');
         
                     if($('#chose-option-diemden-empty').hasClass('show-select')) {
                         $('#chose-option-diemden-empty').removeClass('show-select');
                     }
                     $('#chose-option-diemden-empty').addClass('hidden-select');
         
                     if($('#chose-option-diemden-qt').hasClass('show-select')) {
                         $('#chose-option-diemden-qt').removeClass('show-select');
                     }
                     $('#chose-option-diemden-qt').addClass('hidden-select');
                 } else if(loaitourval == 'ngoainuoc') {
                     if($('#chose-option-diemden-qt').hasClass('hidden-select')) {
                         $('#chose-option-diemden-qt').removeClass('hidden-select');
                     }
                     $('#chose-option-diemden-qt').addClass('show-select');
         
                     if($('#chose-option-diemden-nd').hasClass('show-select')) {
                         $('#chose-option-diemden-nd').removeClass('show-select');
                     }
                     $('#chose-option-diemden-nd').addClass('hidden-select');
         
                     if($('#chose-option-diemden-empty').hasClass('show-select')) {
                         $('#chose-option-diemden-empty').removeClass('show-select');
                     }
                     $('#chose-option-diemden-empty').addClass('hidden-select');
                 } else {
                      if($('#chose-option-diemden-empty').hasClass('hidden-select')) {
                          $('#chose-option-diemden-empty').removeClass('hidden-select');
                      }
                      $('#chose-option-diemden-empty').addClass('show-select');
         
                      if($('#chose-option-diemden-qt').hasClass('show-select')) {
                          $('#chose-option-diemden-qt').removeClass('show-select');
                      }
                      $('#chose-option-diemden-qt').addClass('hidden-select');
         
                      if($('#chose-option-diemden-nd').hasClass('show-select')) {
                          $('#chose-option-diemden-nd').removeClass('show-select');
                      }
                      $('#chose-option-diemden-nd').addClass('hidden-select');
                  }
             });
         });
      </script>
<script>
    $('#category_id').on('change', function() {
        var categoryId = $(this).val();
        var tourTypeSelect = $('#tour-type');

        // Xóa các tùy chọn cũ nếu có danh mục được chọn
        tourTypeSelect.empty().append('<option value="">Loại Tour</option>');

        if (categoryId) {
            $.ajax({
                url: '/get-tour-types/' + categoryId,
                method: 'GET',
                success: function(response) {
                    // Duyệt qua dữ liệu trả về và thêm tùy chọn vào dropdown Loại Tour
                    $.each(response, function(index, tourType) {
                        tourTypeSelect.append(
                            $('<option>', {
                                value: tourType.id,
                                text: tourType.type_name
                            })
                        );
                    });
                }
            });
        } else {
            // Nếu không có danh mục nào được chọn, hiển thị tất cả loại tour
            $.each(@json($tourTypes), function(index, tourType) {
                tourTypeSelect.append(
                    $('<option>', {
                        value: tourType.id,
                        text: tourType.type_name
                    })
                );
            });
        }
    });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
      document.querySelector('.account-toggle').addEventListener('click', function(e) {
         e.preventDefault();
         const dropdown = document.querySelector('.account-dropdown-menu');
         dropdown.classList.toggle('show');
      });
   });
</script>

<style>
   .account-dropdown-menu {
      display: none;
   }
   .account-dropdown-menu.show {
      display: block;
   }
</style>

   </body>
  
  
</html>
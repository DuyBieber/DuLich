@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Thêm Giá Tour</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tour_price_details.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="tour_id">Tour</label>
                <select class="form-control" name="tour_id" id="tour_id">
                    <option value="">Chọn Tour</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}">{{ $tour->title_tours }}</option>
                    @endforeach
                </select>
                @error('tour_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="departure_date_id">Ngày Khởi Hành</label>
                <select class="form-control" name="departure_date_id" id="departure_date_id">
                    <option value="">Chọn Ngày Khởi Hành</option>
                    @foreach($departureDates as $departureDate)
                        <option value="{{ $departureDate->id }}" data-tour-id="{{ $departureDate->tour_id }}">
                            {{ $departureDate->departure_date }}
                        </option>
                    @endforeach
                </select>
                @error('departure_date_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Các trường giá tiền -->
            <div class="form-group">
                <label for="adult_price">Giá Người Lớn</label>
                <input type="number" class="form-control" name="adult_price" id="adult_price" value="{{ old('adult_price') }}" placeholder="...." oninput="calculateChildPrice()">
                @error('adult_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="child_price">Giá Trẻ Em</label>
                <input type="number" class="form-control" name="child_price" id="child_price" value="{{ old('child_price') }}" placeholder="...." readonly>
                @error('child_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="infant_price">Giá Em Bé</label>
                <input type="number" class="form-control" name="infant_price" id="infant_price" value="{{ old('infant_price') }}" placeholder="....">
                @error('infant_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="baby_price">Giá Em Bé Nhỏ</label>
                <input type="number" class="form-control" name="baby_price" id="baby_price" value="{{ old('baby_price') }}" placeholder="....">
                @error('baby_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="foreign_surcharge">Phụ Phí Khách Nước Ngoài</label>
                <input type="number" class="form-control" name="foreign_surcharge" id="foreign_surcharge" value="{{ old('foreign_surcharge') }}" placeholder="....">
                @error('foreign_surcharge')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="single_room_surcharge">Phụ Phí Phòng Đơn</label>
                <input type="number" class="form-control" name="single_room_surcharge" id="single_room_surcharge" value="{{ old('single_room_surcharge') }}" placeholder="....">
                @error('single_room_surcharge')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </form>
</div>

<!-- Script lọc lịch khởi hành -->
<script>
    document.getElementById('tour_id').addEventListener('change', function() {
        var selectedTourId = this.value;
        var departureDateSelect = document.getElementById('departure_date_id');
        
        // Hiển thị các option tương ứng với tour đã chọn
        for (var i = 0; i < departureDateSelect.options.length; i++) {
            var option = departureDateSelect.options[i];
            var tourId = option.getAttribute('data-tour-id');
            
            // Ẩn những option không liên quan và hiển thị option liên quan đến tour được chọn
            if (tourId == selectedTourId || option.value == "") {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        }

        // Reset giá trị của select lịch khởi hành
        departureDateSelect.value = '';
    });

    // Tính giá trẻ em tự động
    function calculateChildPrice() {
        var adultPrice = parseFloat(document.getElementById('adult_price').value);
        if (!isNaN(adultPrice)) {
            var childPrice = adultPrice * 0.75; // Trẻ em sẽ có giá bằng 75% giá người lớn
            document.getElementById('child_price').value = childPrice.toFixed(0); // Cập nhật giá trẻ em
        }
    }
</script>
@endsection

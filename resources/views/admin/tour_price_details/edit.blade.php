@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Chỉnh Sửa Giá Tour</h3>
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

    <form method="POST" action="{{ route('tour_price_details.update', $priceDetail->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="tour_id">Tour</label>
                <select class="form-control" name="tour_id" id="tour_id" onchange="fetchDepartureDates()">
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}" {{ $tour->id == $priceDetail->tour_id ? 'selected' : '' }}>
                            {{ $tour->title_tours }}
                        </option>
                    @endforeach
                </select>
                @error('tour_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="departure_date_id">Ngày Khởi Hành</label>
                <select class="form-control" name="departure_date_id" id="departure_date_id">
                    @foreach($departureDates as $departureDate)
                        <option value="{{ $departureDate->id }}" {{ $departureDate->id == $priceDetail->departure_date_id ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($departureDate->departure_date)->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>
                @error('departure_date_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="adult_price">Giá Người Lớn</label>
                <input type="number" class="form-control" name="adult_price" id="adult_price" value="{{ $priceDetail->adult_price }}" placeholder="...." min="0" oninput="calculateChildPrice()">
                @error('adult_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="child_price">Giá Trẻ Em</label>
                <input type="number" class="form-control" name="child_price" id="child_price" value="{{ $priceDetail->child_price }}" placeholder="...." min="0" readonly>
                @error('child_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="infant_price">Giá Em Bé</label>
                <input type="number" class="form-control" name="infant_price" id="infant_price" value="{{ $priceDetail->infant_price }}" placeholder="...." min="0">
                @error('infant_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="baby_price">Giá Em Bé Nhỏ</label>
                <input type="number" class="form-control" name="baby_price" id="baby_price" value="{{ $priceDetail->baby_price }}" placeholder="...." min="0">
                @error('baby_price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="foreign_surcharge">Phụ Phí Khách Nước Ngoài</label>
                <input type="number" class="form-control" name="foreign_surcharge" id="foreign_surcharge" value="{{ $priceDetail->foreign_surcharge }}" placeholder="...." min="0">
                @error('foreign_surcharge')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="single_room_surcharge">Phụ Phí Phòng Đơn</label>
                <input type="number" class="form-control" name="single_room_surcharge" id="single_room_surcharge" value="{{ $priceDetail->single_room_surcharge }}" placeholder="...." min="0">
                @error('single_room_surcharge')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </div>
    </form>
</div>

<script>
function fetchDepartureDates() {
    var tourId = document.getElementById("tour_id").value;

    fetch('/api/departure-dates/' + tourId) // Đường dẫn API cần được định nghĩa
        .then(response => response.json())
        .then(data => {
            var departureDateSelect = document.getElementById("departure_date_id");
            departureDateSelect.innerHTML = ""; // Xóa các tùy chọn cũ

            data.forEach(function(departureDate) {
                var option = document.createElement("option");
                option.value = departureDate.id;
                option.textContent = new Date(departureDate.departure_date).toLocaleDateString("vi-VN");
                departureDateSelect.appendChild(option);
            });
        });
}

function calculateChildPrice() {
    var adultPrice = parseFloat(document.getElementById('adult_price').value);
    if (!isNaN(adultPrice)) {
        var childPrice = adultPrice * 0.75; // Trẻ em sẽ có giá bằng 75% giá người lớn
        document.getElementById('child_price').value = childPrice.toFixed(0); // Cập nhật giá trẻ em
    }
}
</script>
@endsection

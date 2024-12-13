@extends('admin_layout')

@section('admin_content')
<div class="container">
    <h2>Thêm Ngày Khởi Hình</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departure-dates.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tour_id">Chọn Tour:</label>
            <select name="tour_id" id="tour_id" class="form-control">
                <option value="">-- Chọn Tour --</option>
                @foreach ($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->title_tours }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="departure_date">Ngày Khởi Hành:</label>
            <input type="date" name="departure_date" id="departure_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="feature">Đặc Điểm:</label>
            <input type="text" name="feature" id="feature" class="form-control">
        </div>

        <div class="form-group">
            <label for="price">Giá Từ:</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="available_seats">Số Chỗ:</label>
            <input type="number" name="available_seats" id="available_seats" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu Ngày Khởi Hành</button>
        <a href="{{ route('departure-dates.index') }}" class="btn btn-secondary">Trở Về</a>
    </form>
</div>
@endsection

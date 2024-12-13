@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Chỉnh Sửa Lịch Trình</h3>
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

    <form method="POST" action="{{ route('itineraries.update', [$itinerary->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="card-body">
            <div class="form-group">
                <label for="tour_id">Chọn Tour</label>
                <select class="form-control" name="tour_id" id="tour_id">
                    <option value="">Chọn tour</option>
                    @foreach ($tours as $tour)
                        <option value="{{ $tour->id }}" {{ $itinerary->tour_id == $tour->id ? 'selected' : '' }}>
                            {{ $tour->title_tours }}
                        </option>
                    @endforeach
                </select>
                @error('tour_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="day">Ngày</label>
                <input type="text" class="form-control" name="day" id="day" placeholder="Ngày trong lịch trình" value="{{ old('day', $itinerary->date) }}">
                @error('day')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="img">Hình Ảnh</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="img" class="form-control-file" id="img">
                        <label class="custom-file-label" for="img">Chọn hình ảnh</label>
                    </div>
                </div>
                @error('img')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="activity_description">Mô Tả Hoạt Động</label>
                <textarea class="form-control" name="activity_description" id="activity_description" rows="3" placeholder="Mô tả hoạt động">{{ old('activity_description', $itinerary->activity_description) }}</textarea>
                @error('activity_description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="location">Địa Điểm</label>
                <input type="text" class="form-control" name="location" id="location" placeholder="Địa điểm" value="{{ old('location', $itinerary->location) }}">
                @error('location')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_time">Thời Gian Bắt Đầu</label>
                <input type="text" class="form-control" name="start_time" id="start_time" value="{{ old('start_time', $itinerary->start_time) }}">
                @error('start_time')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">Thời Gian Kết Thúc</label>
                <input type="text" class="form-control" name="end_time" id="end_time" value="{{ old('end_time', $itinerary->end_time) }}">
                @error('end_time')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Lịch Trình</button>
        </div>
    </form>
</div>
@endsection

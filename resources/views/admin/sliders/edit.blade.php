@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Sửa Slider</h3>
    </div>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-body">
        <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="slider_name">Tên Slider</label>
                <input type="text" class="form-control @error('slider_name') is-invalid @enderror" id="slider_name" name="slider_name" value="{{ old('slider_name', $slider->slider_name) }}" required>
                @error('slider_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="slider_image">Hình ảnh</label>
                <input type="file" class="form-control @error('slider_image') is-invalid @enderror" id="slider_image" name="slider_image">
                @error('slider_image')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <img height="80px" width="120px" src="{{ asset('uploads/slider/' . $slider->slider_image) }}" alt="{{ $slider->slider_name }}">
            </div>

            <div class="form-check">
                <input type="hidden" name="slider_status" value="0">
                <input type="checkbox" value="1" {{ $slider->slider_status == 1 ? 'checked' : '' }} name="slider_status" class="form-check-input" id="slider_status">
                <label class="form-check-label" for="slider_status">Trạng thái</label>
            </div>
            @error('slider_status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="slider_desc">Mô tả</label>
                <textarea class="form-control @error('slider_desc') is-invalid @enderror" id="slider_desc" name="slider_desc">{{ old('slider_desc', $slider->slider_desc) }}</textarea>
                @error('slider_desc')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tour_id">Chọn Tour</label>
                <select class="form-control @error('tour_id') is-invalid @enderror" id="tour_id" name="tour_id" required>
                    <option value="">Chọn Tour</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}" {{ old('tour_id', $slider->tour_id) == $tour->id ? 'selected' : '' }}>{{ $tour->title_tours }}</option>
                    @endforeach
                </select>
                @error('tour_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</div>
@endsection

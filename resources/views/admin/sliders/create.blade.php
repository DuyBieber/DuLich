@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Thêm Slider Mới</h3>
    </div>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-body">
        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="slider_name">Tên Slider</label>
                <input type="text" class="form-control @error('slider_name') is-invalid @enderror" id="slider_name" name="slider_name" value="{{ old('slider_name') }}" required>
                @error('slider_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="slider_image">Hình ảnh</label>
                <input type="file" class="form-control @error('slider_image') is-invalid @enderror" id="slider_image" name="slider_image" required>
                @error('slider_image')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="slider_status">Trạng thái</label>
                <select class="form-control @error('slider_status') is-invalid @enderror" id="slider_status" name="slider_status" required>
                    <option value="1" {{ old('slider_status') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                    <option value="0" {{ old('slider_status') == '0' ? 'selected' : '' }}>Ngừng hoạt động</option>
                </select>
                @error('slider_status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="slider_desc">Mô tả</label>
                <textarea class="form-control @error('slider_desc') is-invalid @enderror" id="slider_desc" name="slider_desc">{{ old('slider_desc') }}</textarea>
                @error('slider_desc')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="tour_id">Chọn Tour</label>
                <select class="form-control @error('tour_id') is-invalid @enderror" id="tour_id" name="tour_id" required>
                    <option value="">Chọn Tour</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>{{ $tour->title_tours }}</option>
                    @endforeach
                </select>
                @error('tour_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection

@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Sửa Địa Điểm</h3>
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
    <form method="POST" action="{{ route('locations.update', $location->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên Địa Điểm</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Tên địa điểm" value="{{ old('name', $location->name) }}">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Mô tả địa điểm">{{ old('description', $location->description) }}</textarea>
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Hình Ảnh</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="image" class="form-control-file" id="image">
                        <label class="custom-file-label" for="image">Chọn hình ảnh mới (nếu cần)</label>
                    </div>
                </div>
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <img src="{{ asset('uploads/locations/' . $location->image) }}" alt="{{ $location->name }}" width="100" class="mt-2">
            </div>

            <div class="form-group">
                <label for="tour_ids">Chọn Tour</label>
                <div>
                    @foreach ($tours as $tour)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tour_ids[]" value="{{ $tour->id }}" 
                                {{ in_array($tour->id, $location->tours->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tour_ids">
                                {{ $tour->title_tours }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('tour_ids')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Địa Điểm</button>
        </div>
    </form>
</div>
@endsection

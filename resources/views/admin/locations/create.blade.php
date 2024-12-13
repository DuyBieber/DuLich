@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Thêm Địa Điểm</h3>
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
    <form method="POST" action="{{ route('locations.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên Địa Điểm</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Tên địa điểm" value="{{ old('name') }}">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Mô tả địa điểm">{{ old('description') }}</textarea>
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Hình Ảnh</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="image" class="form-control-file" id="image" required>
                        <label class="custom-file-label" for="image">Chọn hình ảnh</label>
                    </div>
                </div>
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tour_ids">Chọn Tour</label>
                <div class="form-check">
                    @foreach ($tours as $tour)
                        <input type="checkbox" class="form-check-input" name="tour_ids[]" id="tour_{{ $tour->id }}" value="{{ $tour->id }}" {{ (is_array(old('tour_ids')) && in_array($tour->id, old('tour_ids'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tour_{{ $tour->id }}">{{ $tour->title_tours }}</label><br>
                    @endforeach
                </div>
                @error('tour_ids')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Địa Điểm</button>
        </div>
    </form>
</div>
@endsection

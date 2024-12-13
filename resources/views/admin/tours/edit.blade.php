@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa Tours</h3>
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
    <form method="POST" action="{{ route('tours.update', [$tour->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @foreach(['title_tours' => 'Tiêu đề Tours', 'description' => 'Mô tả Tours', 'price' => 'Giá Tours', 'vehicle' => 'Phương Tiện', 'tour_from' => 'Nơi đi', 'tour_to' => 'Nơi đến', 'tour_time' => 'Tổng thời gian đi'] as $field => $label)
                <div class="form-group">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <input type="text" class="form-control" name="{{ $field }}" id="{{ $field }}" value="{{ old($field, $tour->$field) }}" placeholder="....">
                    @error($field)
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <!-- Chọn danh mục (checkbox) -->
            <div class="form-group">
                <label>Danh mục</label><br>
                @foreach($categories as $category)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input category-checkbox" name="category_ids[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->title }}</label>
                    </div>
                @endforeach
                @error('category_ids')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Chọn loại tour (checkbox) dựa trên danh mục đã chọn -->
            <div class="form-group">
                <label>Loại tour</label><br>
                @foreach($tourTypesByCategory as $categoryId => $tourTypes)
                    @foreach($tourTypes as $tourType)
                        <div class="form-check tour-type tour-type-{{ $categoryId }}" style="display: {{ in_array($tourType->id, $selectedTourTypeIds) ? 'block' : 'none' }};">
                            <input type="checkbox" class="form-check-input" name="tour_type_ids[]" id="tour_type_{{ $tourType->id }}" value="{{ $tourType->id }}" {{ in_array($tourType->id, $selectedTourTypeIds) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tour_type_{{ $tourType->id }}">{{ $tourType->type_name }}</label>
                        </div>
                    @endforeach
                @endforeach
                @error('tour_type_ids')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Chọn địa điểm (checkbox) -->
            <div class="form-group">
                <label>Địa điểm</label><br>
                @foreach($locations as $location)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="location_ids[]" id="location_{{ $location->id }}" value="{{ $location->id }}" {{ in_array($location->id, $selectedLocationIds) ? 'checked' : '' }}>
                        <label class="form-check-label" for="location_{{ $location->id }}">{{ $location->name }}</label>
                    </div>
                @endforeach
                @error('location_ids')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Upload ảnh -->
            <div class="form-group">
                <label for="image">File image</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="image" class="form-control-file" id="image">
                        <label class="custom-file-label" for="image">Chọn file</label>
                    </div>
                </div>
                <small>Ảnh hiện tại:</small><br>
                <img height="80px" width="120px" src="{{ asset('public/uploads/tours/' . $tour->image) }}" alt="{{ $tour->title_tours }}">
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Trạng thái -->
            <div class="form-check">
                <input type="checkbox" value="1" name="status" class="form-check-input" id="status" {{ $tour->status == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Trạng thái</label>
            </div>
            @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>
</div>

<!-- JavaScript để hiển thị loại tour dựa trên danh mục đã chọn -->
<script>
    document.querySelectorAll('.category-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const categoryId = this.value;
            const tourTypes = document.querySelectorAll('.tour-type-' + categoryId);
            tourTypes.forEach(tourType => {
                tourType.style.display = this.checked ? 'block' : 'none';
            });
        });
    });
</script>

@endsection

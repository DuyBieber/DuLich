@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Thêm mới loại tour</h3>
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

    <form method="POST" action="{{ route('tour_types.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="type_name">Tên loại tour</label>
                <input type="text" class="form-control" name="type_name" id="type_name" placeholder="Nhập tên loại tour" required>
                @error('type_name')
                    <div class="alert alert-danger" style="width:200px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type_desc">Mô tả</label>
                <textarea class="form-control" name="type_desc" id="type_desc" rows="3" placeholder="Nhập mô tả loại tour"></textarea>
                @error('type_desc')
                    <div class="alert alert-danger" style="width:200px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" value="1" name="type_status" class="form-check-input" id="type_status">
                <label class="form-check-label" for="type_status">Trạng thái</label>
            </div>
            @error('type_status')
                <div class="alert alert-danger" style="width:200px;">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="category_ids">Danh mục</label>
                <div class="form-check">
                    @foreach ($categories as $category)
                        <input type="checkbox" class="form-check-input" name="category_ids[]" value="{{ $category->id }}" id="category_{{ $category->id }}">
                        <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->title }}</label><br>
                    @endforeach
                </div>
                @error('category_ids')
                    <div class="alert alert-danger" style="width:200px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
    </form>
</div>
@endsection

@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Chỉnh sửa hình ảnh</h3>
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
  <form method="POST" action="{{ route('gallery.update', $gallery->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề</label>
            <input type="text" class="form-control" name="title" id="exampleInputEmail1" value="{{ old('title', $gallery->title) }}" placeholder="....">
            @error('title')
                <div class="alert alert-danger" style="width:200px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputFile">File image</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="image" class="form-control-file" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Chọn tệp</label>
                </div>
            </div>
            <img height="80px" width="120px" src="{{ asset('public/uploads/galleries/' . $gallery->image) }}" alt="Current Image">
        </div>

        @if ($tour)
            <div class="form-group">
                <label for="tourSelect">Tour</label>
                <select class="form-control" name="tour_id" id="tourSelect">
                    <option value="{{ $tour->id }}" selected>{{ $tour->title_tours }}</option>
                </select>
            </div>
        @endif

        @if ($blog)
            <div class="form-group">
                <label for="blogSelect">Blog</label>
                <select class="form-control" name="blog_id" id="blogSelect">
                    <option value="{{ $blog->id }}" selected>{{ $blog->title }}</option>
                </select>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</form>
</div>
@endsection

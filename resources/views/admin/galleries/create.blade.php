@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Thêm thư viện ảnh</h3>
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
  <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="type">Loại nội dung</label>
            <select class="form-control" name="type" id="type" onchange="toggleSelection()">
                <option value="">Chọn loại nội dung</option>
                <option value="tour">Tour</option>
                <option value="blog">Blog</option>
            </select>
        </div>

        <!-- Hiển thị lựa chọn Tour -->
        <div id="tourSelection" class="form-group" style="display:none;">
            <label for="tourSelect">Tour</label>
            <select class="form-control" name="tour_id" id="tourSelect">
                <option value="">Chọn Tour</option>
                @foreach ($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->title_tours }}</option>
                @endforeach
            </select>
        </div>

        <!-- Hiển thị lựa chọn Blog -->
        <div id="blogSelection" class="form-group" style="display:none;">
            <label for="blogSelect">Blog</label>
            <select class="form-control" name="blog_id" id="blogSelect">
                <option value="">Chọn Blog</option>
                @foreach ($blogs as $blog)
                    <option value="{{ $blog->id }}">{{ $blog->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Nhập tiêu đề">
            @error('title')
                <div class="alert alert-danger" style="width:200px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputFile">File image</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="image[]" multiple class="form-control-file" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Chọn tệp</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm</button>
    </div>
  </form>
</div>

<script>
function toggleSelection() {
    var type = document.getElementById('type').value;
    if (type === 'tour') {
        document.getElementById('tourSelection').style.display = 'block';
        document.getElementById('blogSelection').style.display = 'none';
    } else if (type === 'blog') {
        document.getElementById('tourSelection').style.display = 'none';
        document.getElementById('blogSelection').style.display = 'block';
    } else {
        document.getElementById('tourSelection').style.display = 'none';
        document.getElementById('blogSelection').style.display = 'none';
    }
}
</script>
@endsection

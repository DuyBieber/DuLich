@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Danh sách thư viện ảnh</h3>
  </div>
  @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
  @if (session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
  @endif
  <div class="card-body">
    <table class="table table-striped" id="myTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Tiêu đề</th>
          <th scope="col">Hình ảnh</th>
          <th scope="col">Tour</th>
          <th scope="col">Blog</th>
          <th scope="col">Ngày tạo</th>
          <th scope="col">Ngày cập nhật</th>
          <th scope="col">Quản lý</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($galleries as $key => $gallery)
        <tr>
          <th scope="row">{{ $key + 1 }}</th>
          <td>{{ $gallery->title }}</td>
          <td><img height="80px" width="120px" src="{{ asset('public/uploads/galleries/' . $gallery->image) }}"></td>
          <td>{{ $gallery->tour ? $gallery->tour->title_tours : 'N/A' }}</td>
          <td>{{ $gallery->blog ? $gallery->blog->title : 'N/A' }}</td>
          <td>{{ $gallery->created_at }}</td>
          <td>{{ $gallery->updated_at }}</td>
          <td>
              <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning">Sửa</a>
              <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                      <i class="fas fa-trash-alt"></i>
                  </button>
              </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

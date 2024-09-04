
@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Danh sách bài blogs </h3>
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
<table class="table table-striped" id="myTable">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Tiêu đề</th>
      <th scope="col">Slug</th>
      <th scope="col">Hình ảnh</th>
      <th scope="col">Nội dung</th>
      <th scope="col">Ngày tạo</th>
      <th scope="col">Ngày cập nhật</th>
      <th scope="col"> Quản lý</th>
    </tr>
  </thead>
  <tbody>
    @foreach ( $post as $key => $po )
    <tr>
      <th scope="row">{{$key}}</th>
      <td>{{$po->title}}</td>
      <td>{{$po->slug}}</td>
      <td><img height="80px" width="120px" src="{{asset('public/uploads/blogs/'.$po->image)}}"></td>
      <td style="height:80px; width:50px">
    {{ Str::limit($po->content, 50) }}
</td>
      <td>{{$po->created_at}}</td>
      <td>{{$po->updated_at}}</td>
      
    <td>
    <a href="{{route('blogs.edit', [$po->id])}}" class="btn btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{route('blogs.destroy', [$po->id])}}" method="POST" style="display:inline;">
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
@endsection


@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Danh sách danh mục </h3>
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
      <th scope="col">Hình ảnh</th>
      <th scope="col">Miêu tả</th>
      <th scope="col">Slug</th>
      <th scope="col">Ngày tạo</th>
      <th scope="col">Ngày cập nhật</th>
      <th scope="col">Trạng thái</th>
      <th scope="col"> Quản lý</th>
    </tr>
  </thead>
  <tbody>
    @foreach ( $categories as $key => $cate )
    <tr>
      <th scope="row">{{$key}}</th>
      <td>{{$cate->title}}</td>
      <td><img height="80px" width="120px" src="{{asset('public/uploads/categories/'.$cate->image)}}"></td>
      <td>{{$cate->description}}</td>
      <td>{{$cate->slug}}</td>
      <td>{{$cate->created_at}}</td>
      <td>{{$cate->updated_at}}</td>
      <td>
        @if($cate->status==1)
        <span class="text text-success">Hiển thị</span>
        @else
        <span class="text text-success">Ẩn</span>
        @endif

    </td>
    <td>
    <a href="{{route('categories.edit', [$cate->id])}}" class="btn btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{route('categories.destroy', [$cate->id])}}" method="POST" style="display:inline;">
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

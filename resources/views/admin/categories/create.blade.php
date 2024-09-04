@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Thêm danh mục </h3>
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
              <form method="POST" action="{{route('categories.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tiêu đề</label>
                    <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="....">

                    @error('title')
                    <div class="alert alert-danger" style="width:200px;" >{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nội dung</label>
                    <input type="text" class="form-control"name="description" id="exampleInputPassword1" placeholder="....">
                    @error('description')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File image</label>
                    <div class="input-group">
                      <div class="custom-file">
                      <input type="file" name="image" class="form-control-file" id="exampleInputFile">

                        <label class="custom-file-label"  for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                  </div>
                  <div class="form-check">
                  <input type="checkbox" value="1" name="status" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Trạng thái</label>
                  </div>
                  @error('status')
                    <div class="alert alert-danger" style="width:200px;">{{$message}}</div>
                    @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
              </form>
            </div>
@endsection

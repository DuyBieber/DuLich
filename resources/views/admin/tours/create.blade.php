@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Thêm Tours </h3>
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
              <form method="POST" action="{{route('tours.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tiêu đề Tours</label>
                    <input type="text" class="form-control" name="title_tours" id="exampleInputEmail1" placeholder="....">

                    @error('title_tours')
                    <div class="alert alert-danger" style="width:200px;" >{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Số lượng người Tours</label>
                    <input type="text" class="form-control"name="quantity" id="exampleInputPassword1" placeholder="....">
                    @error('quantity')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Danh mục</label>
                    <select class="form-control" name="category_id">
                      @foreach($categories as $key => $category )
                      <option value = "{{$category->id}}">{{$category->title}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mô tả Tours</label>
                    <input type="text" class="form-control"name="description" id="exampleInputPassword1" placeholder="....">
                    @error('description')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Giá Tours</label>
                    <input type="text" class="form-control"name="price" id="exampleInputPassword1" placeholder="....">
                    @error('price')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phương Tiện</label>
                    <input type="text" class="form-control"name="vehicle" id="exampleInputPassword1" placeholder="....">
                    @error('vehicle')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Ngày xuất phát</label>
                    <input type="text" class="form-control"name="departure_date" id="departure_date" placeholder="....">
                    @error('departure_date')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Ngày về</label>
                    <input type="text" class="form-control"name="return_date" id="return_date" placeholder="....">
                    @error('return_date')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nơi đi</label>
                    <input type="text" class="form-control"name="tour_from" id="exampleInputPassword1" placeholder="....">
                    @error('tour_from')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nơi đến</label>
                    <input type="text" class="form-control"name="tour_to" id="exampleInputPassword1" placeholder="....">
                    @error('tour_to')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Tổng thời gian đi</label>
                    <input type="text" class="form-control"name="tour_time" id="exampleInputPassword1" placeholder="....">
                    @error('tour_time')
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

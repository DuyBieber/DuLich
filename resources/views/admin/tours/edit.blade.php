@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cập nhật Tours </h3>
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
              <form method="POST" action="{{route('tours.update',[$tour->id])}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tiêu đề Tours</label>
                    <input type="text" value="{{$tour->title_tours}}"class="form-control" name="title_tours" id="exampleInputEmail1" placeholder="....">

                    @error('title_tours')
                    <div class="alert alert-danger" style="width:200px;" >{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Danh mục</label>
                    <select class="form-control" name="category_id">
                        @foreach($categories as $key => $category)
                            <option {{ $category->id == $tour->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Số lượng người Tours</label>
                    <input type="text"value="{{$tour->quantity}}" class="form-control"name="quantity" id="exampleInputPassword1" placeholder="....">
                    @error('quantity')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mô tả Tours</label>
                    <input type="text"value="{{$tour->description}}" class="form-control"name="description" id="exampleInputPassword1" placeholder="....">
                    @error('description')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Giá Tours</label>
                    <input type="text" value="{{$tour->price}}"class="form-control"name="price" id="exampleInputPassword1" placeholder="....">
                    @error('price')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phương Tiện</label>
                    <input type="text"value="{{$tour->vehicle}}" class="form-control"name="vehicle" id="exampleInputPassword1" placeholder="....">
                    @error('vehicle')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Ngày xuất phát</label>
                    <input type="text" value="{{$tour->departure_date}}"class="form-control"name="departure_date" id="departure_date" placeholder="....">
                    @error('departure_date')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Ngày về</label>
                    <input type="text" value="{{$tour->return_date}}"class="form-control"name="return_date" id="return_date" placeholder="....">
                    @error('return_date')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nơi đi</label>
                    <input type="text"  value="{{$tour->tour_from}}"class="form-control"name="tour_from" id="exampleInputPassword1" placeholder="....">
                    @error('tour_from')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nơi đến</label>
                    <input type="text" value="{{$tour->tour_to}}"class="form-control"name="tour_to" id="exampleInputPassword1" placeholder="....">
                    @error('tour_to')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Tổng thời gian đi</label>
                    <input type="text" value="{{$tour->tour_time}}"class="form-control"name="tour_time" id="exampleInputPassword1" placeholder="....">
                    @error('tour_time')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slug_tours</label>
                    <input type="text" value="{{$tour->slug_tours}}"class="form-control"name="slug_tours" id="exampleInputPassword1" placeholder="....">
                    @error('slug_tours')
                    <div class="alert alert-danger"style="width:200px;">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mã tour</label>
                    <input type="text" value="{{$tour->tour_code}}"class="form-control"name="tour_code" id="exampleInputPassword1" placeholder="....">
                    @error('tour_code')
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
                        <img height="80px" width="120px" src="{{asset('public/uploads/tours/'.$tour->image)}}">
                    </div>
                  </div>
                  <div class="form-check">
                          <input type="hidden" name="status" value="0">
                          <input type="checkbox" value="1" {{$tour->status == 1 ? 'checked' : ''}} name="status" class="form-check-input" id="exampleCheck1">
                          <label class="form-check-label" for="exampleCheck1">Trạng thái</label>
                      </div>
                      @error('status')
                      <div class="alert alert-danger" style="width:200px;">{{$message}}</div>
                      @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
              </form>
            </div>
@endsection

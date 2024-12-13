@extends('admin_layout')

@section('admin_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh Sách Slider</h3>
        <a href="{{ route('sliders.create') }}" class="btn btn-primary float-right">Thêm Slider Mới</a>
    </div>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Slider</th>
                    <th>Hình Ảnh</th>
                    <th>Tour Liên Kết</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sliders as $slider)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $slider->slider_name }}</td>
                        <td><img src="{{ asset('uploads/slider/' . $slider->slider_image) }}" alt="{{ $slider->slider_name }}" style="width:100px;"></td>
                        <td>{{ $slider->tour ? $slider->tour->title_tours : 'Không có' }}</td>
                        <td>{{ $slider->slider_status ? 'Kích hoạt' : 'Ngừng hoạt động' }}</td>
                        <td>
                            <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('admin_layout')

@section('admin_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh Sách Địa Điểm</h3>
        <div class="card-tools">
            <a href="{{ route('locations.create') }}" class="btn btn-primary">Thêm Địa Điểm</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Địa Điểm</th>
                    <th>Mô Tả</th>
                    <th>Hình Ảnh</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->description }}</td>
                    <td>
                        <img src="{{ asset('uploads/locations/' . $location->image) }}" alt="{{ $location->name }}" width="100">
                    </td>
                    <td>
                        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection

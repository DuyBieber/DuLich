@extends('admin_layout')

@section('admin_content')
<div class="card">
    <div class="card-header">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <h3 class="card-title">Danh sách loại tour</h3>
        <div class="card-tools">
            <a href="{{ route('tour_types.create') }}" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên loại tour</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tourTypes as $tourType)
                    <tr>
                        <td>{{ $tourType->id }}</td>
                        <td>{{ $tourType->type_name }}</td>
                        <td>{{ $tourType->type_desc }}</td>
                        <td>{{ $tourType->type_status ? 'Kích hoạt' : 'Khóa' }}</td>
                        <td>
                            <a href="{{ route('tour_types.edit', $tourType->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('tour_types.destroy', $tourType->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

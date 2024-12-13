@extends('admin_layout')

@section('admin_content')
<div class="container">
    <h2>Danh sách Ngày Khởi Hình</h2>
    <a href="{{ route('departure-dates.create') }}" class="btn btn-success">Thêm Ngày Khởi Hình</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="myTable">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tour</th>
                <th>Ngày Khởi Hình</th>
                <th>Đặc Điểm</th>
                <th>Giá Từ</th>
                <th>Số Chỗ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departureDates as $departure)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $departure->tour->title_tours }}</td>
                    <td>{{ $departure->departure_date }}</td>
                    <td>{{ $departure->feature }}</td>
                    <td>{{ $departure->price }}</td>
                    <td>{{ $departure->available_seats }}</td>
                    <td>
                        <a href="{{ route('departure-dates.edit', $departure->id) }}" class="btn btn-primary">Sửa</a>
                        <form action="{{ route('departure-dates.destroy', $departure->id) }}" method="POST" style="display:inline;">
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
@endsection

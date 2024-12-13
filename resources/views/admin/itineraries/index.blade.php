@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh sách Lịch Trình</h3>
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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tour</th>
                <th scope="col">Ngày</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Địa Điểm</th>
                <th scope="col">Thời Gian Bắt Đầu</th>
                <th scope="col">Thời Gian Kết Thúc</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itineraries as $key => $itinerary)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $itinerary->tour->title_tours }}</td>
                <td>{{ $itinerary->day }}</td>
                <<td><img src="{{ asset('public/uploads/itineraries/' . $itinerary->img) }}"height="80px" width="120px" alt="Hình ảnh lịch trình" class="itinerary-img"></td>
                <td>{{ $itinerary->location }}</td>
                <td>{{ $itinerary->start_time }}</td>
                <td>{{ $itinerary->end_time }}</td>
                <td>
                    <a href="{{ route('itineraries.edit', [$itinerary->id]) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('itineraries.destroy', [$itinerary->id]) }}" method="POST" style="display:inline;">
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

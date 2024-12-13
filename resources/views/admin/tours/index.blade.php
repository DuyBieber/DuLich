@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh sách tours</h3>
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
    <div class="table table-responsive">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tiêu đề</th>
                    
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Giá</th>
                   
                    <th scope="col">Slug tour</th>
                    <th scope="col">Phương tiện</th>
                    <th scope="col">Ngày đi</th> <!-- Hiển thị ngày đi -->
                    <th scope="col">Nơi đi</th>
                    <th scope="col">Nơi đến</th>
                    <th scope="col">Mã tours</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Quản lý</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tours as $key => $tour)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $tour->title_tours }}</td>
                   
                    <td><img height="80px" width="120px" src="{{ asset('public/uploads/tours/' . $tour->image) }}" alt="{{ $tour->title_tours }}"></td>
                    <td>{{ number_format($tour->price, 0, ',', '.') }} VND</td>
                    
                    <td>{{ $tour->slug_tours }}</td>
                    <td>{{ $tour->vehicle }}</td>
                    
                    <!-- Hiển thị ngày đi từ bảng departure_dates -->
                    <td>
                        @if ($tour->departureDates->isNotEmpty())
                            {{ \Carbon\Carbon::parse($tour->departureDates->first()->departure_date)->format('d/m/Y') }}
                        @else
                            Không có ngày đi
                        @endif
                    </td>

                    <td>{{ $tour->tour_from }}</td>
                    <td>{{ $tour->tour_to }}</td>
                    <td>{{ $tour->tour_code }}</td>
                    <td>
                        @if($tour->status == 1)
                            <span class="text text-success">Hiển thị</span>
                        @else
                            <span class="text text-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tours.edit', [$tour->id]) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('tours.destroy', [$tour->id]) }}" method="POST" style="display:inline;">
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
</div>
@endsection

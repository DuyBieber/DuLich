@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh Sách Giá Tour</h3>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="card-tools">
            <a href="{{ route('tour_price_details.create') }}" class="btn btn-success">Thêm Giá Tour</a>
        </div>
       
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>Tour</th>
                    <th>Ngày Khởi Hành</th>
                    <th>Giá Người Lớn</th>
                    <th>Giá Trẻ Em</th>
                    <th>Giá Em Bé</th>
                    <th>Giá Em Bé Nhỏ</th>
                    <th>Phụ Phí Khách Nước Ngoài</th>
                    <th>Phụ Phí Phòng Đơn</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($priceDetails as $priceDetail)
                    <tr>
                        <td>{{ $priceDetail->tour->title_tours }}</td>
                        <td>
                            @if($priceDetail->departureDate)
                                {{ \Carbon\Carbon::parse($priceDetail->departureDate->departure_date)->format('d/m/Y') }}
                            @else
                                Chưa có ngày khởi hành
                            @endif
                        </td>
                        <td>{{ number_format($priceDetail->adult_price) }} VNĐ</td>
                        <td>{{ number_format($priceDetail->child_price) }} VNĐ</td>
                        <td>{{ number_format($priceDetail->infant_price) }} VNĐ</td>
                        <td>{{ number_format($priceDetail->baby_price) }} VNĐ</td>
                        <td>{{ number_format($priceDetail->foreign_surcharge) }} VNĐ</td>
                        <td>{{ number_format($priceDetail->single_room_surcharge) }} VNĐ</td>
                        <td>
                            <a href="{{ route('tour_price_details.edit', $priceDetail->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('tour_price_details.destroy', $priceDetail->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

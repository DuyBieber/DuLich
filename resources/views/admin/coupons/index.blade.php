@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh sách mã giảm giá</h3>
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
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên mã</th>
                <th scope="col">Mã giảm giá</th>
                <th scope="col">Giảm giá (%)</th>
                <th scope="col">Số lượng mã</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Ngày cập nhật</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $key => $coupon)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $coupon->coupon_name }}</td>
                <td>{{ $coupon->coupon_code }}</td>
                <td>{{ $coupon->coupon_number }}%</td>
                <td>{{ $coupon->coupon_quantity }}</td>
                <td>{{ $coupon->created_at }}</td>
                <td>{{ $coupon->updated_at }}</td>
                <td>
                    <a href="{{ route('coupons.edit', [$coupon->id]) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('coupons.destroy', [$coupon->id]) }}" method="POST" style="display:inline;">
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

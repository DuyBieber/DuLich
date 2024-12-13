@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa mã giảm giá</h3>
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
    <form method="POST" action="{{ route('coupons.update', [$coupon->id]) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="coupon_name">Tên mã giảm giá</label>
                <input type="text" class="form-control" name="coupon_name" id="coupon_name" value="{{ $coupon->coupon_name }}">
                @error('coupon_name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="coupon_code">Mã giảm giá</label>
                <input type="text" class="form-control" name="coupon_code" id="coupon_code" value="{{ $coupon->coupon_code }}">
                @error('coupon_code')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="coupon_number">Giảm giá (%)</label>
                <input type="number" class="form-control" name="coupon_number" id="coupon_number" value="{{ $coupon->coupon_number }}">
                @error('coupon_number')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="coupon_quantity">Số lượng mã</label>
                <input type="number" class="form-control" name="coupon_quantity" id="coupon_quantity" value="{{ $coupon->coupon_quantity }}">
                @error('coupon_quantity')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật mã giảm giá</button>
        </div>
    </form>
</div>
@endsection

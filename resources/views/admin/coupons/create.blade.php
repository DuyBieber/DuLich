@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Thêm mã giảm giá</h3>
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
    <form method="POST" action="{{ route('coupons.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="coupon_name">Tên mã giảm giá</label>
                <input type="text" class="form-control" name="coupon_name" id="coupon_name" placeholder="Nhập tên mã giảm giá">
                @error('coupon_name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="coupon_code">Mã giảm giá</label>
                <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Nhập mã giảm giá">
                @error('coupon_code')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="coupon_number">Giảm giá (%)</label>
                <input type="number" class="form-control" name="coupon_number" id="coupon_number" placeholder="Nhập phần trăm giảm giá">
                @error('coupon_number')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="coupon_quantity">Số lượng</label>
                <input type="number" class="form-control" name="coupon_quantity" id="coupon_quantity">
                @error('coupon_quantity')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm mã giảm giá</button>
        </div>
    </form>
</div>
@endsection

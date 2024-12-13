@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa thông tin khách hàng</h3>
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
    <form action="{{ route('customers.update', [$customer->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="customer_name">Tên khách hàng</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $customer->customer_name }}" required>
            </div>
            <div class="form-group">
                <label for="customer_email">Email</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ $customer->customer_email }}" required>
            </div>
            <div class="form-group">
                <label for="customer_phone">Số điện thoại</label>
                <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ $customer->customer_phone }}" required>
            </div>
            <div class="form-group">
                <label for="customer_address">Địa chỉ</label>
                <input type="text" class="form-control" id="customer_address" name="customer_address" value="{{ $customer->customer_address }}" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>
@endsection

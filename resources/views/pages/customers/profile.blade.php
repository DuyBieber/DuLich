@extends('layout')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Trang cá nhân của {{ $customer->customer_name }}</h1>
    </div>
    <div class="profile-details">
        <p><strong>Email:</strong> <span class="customer-email">{{ $customer->customer_email }}</span></p>
        <p><strong>Số điện thoại:</strong> <span class="customer-phone">{{ $customer->customer_phone }}</span></p>
        <p><strong>Địa chỉ:</strong> <span class="customer-address">{{ $customer->customer_address }}</span></p>
    </div>
    <div class="profile-actions">
        <a href="{{route('customer.profile.edit')}}" class="btn btn-primary edit-button">Chỉnh sửa thông tin</a>
       
    </div>
</div>
@endsection

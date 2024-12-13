@extends('admin_layout')

@section('admin_content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Trang cá nhân của {{ $admin->admin_name }}</h1>
    </div>
    <div class="profile-details">
        <p><strong>Email:</strong> <span class="admin-email">{{ $admin->admin_email }}</span></p>
        <p><strong>Số điện thoại:</strong> <span class="admin-phone">{{ $admin->admin_phone }}</span></p>
        <p><strong>Chức vụ:</strong> <span class="admin-address">{{ $admin->admin_chucvu }}</span></p>
    </div>
    <div class="profile-actions">
        <a href="{{route('admin.profile.edit')}}" class="btn btn-primary edit-button">Chỉnh sửa thông tin</a>
       
    </div>
</div>
<style>
.profile-container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    font-family: 'Arial', sans-serif;
    color: #333;
}

.profile-header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.profile-header h1 {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
}

.profile-details {
    margin: 20px 0;
}

.profile-details p {
    font-size: 16px;
    margin-bottom: 10px;
    line-height: 1.5;
}

.profile-details strong {
    font-weight: bold;
    color: #555;
}

.profile-actions {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.edit-button {
    text-decoration: none;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
}

.edit-button:hover {
    background-color: #0056b3;
    color: #ffffff;
}

.admin-email,
.admin-phone,
.admin-address {
    color: #555;
}

</style>
@endsection
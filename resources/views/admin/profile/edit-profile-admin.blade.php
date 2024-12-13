@extends('admin_layout')

@section('admin_content')
<div class="edit-profile-container">
    <h1 class="edit-profile-title">Chỉnh sửa thông tin cá nhân quản trị viên</h1>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" id="editProfileForm">
        @csrf
        <div class="form-group">
            <label for="admin_name" class="edit-label">Tên</label>
            <input type="text" id="admin_name" name="admin_name" value="{{ $admin->admin_name }}" class="form-control edit-input" required>
            @error('admin_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="admin_email" class="edit-label">Email</label>
            <input type="email" id="admin_email" name="admin_email" value="{{ $admin->admin_email }}" class="form-control edit-input" required>
            @error('admin_email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="admin_phone" class="edit-label">Số điện thoại</label>
            <input type="text" id="admin_phone" name="admin_phone" value="{{ $admin->admin_phone }}" class="form-control edit-input" required>
            @error('admin_phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="admin_chucvu" class="edit-label">Chức vụ</label>
            <input type="text" id="admin_chucvu" name="admin_chucvu" value="{{ $admin->admin_chucvu }}" class="form-control edit-input" required>
            @error('admin_chucvu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="current_password" class="edit-label">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="form-control edit-input">
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="admin_password" class="edit-label">Mật khẩu mới (nếu muốn thay đổi)</label>
            <input type="password" id="admin_password" name="admin_password" class="form-control edit-input">
            @error('admin_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary edit-submit">Lưu thay đổi</button>
    </form>
</div>
<style>
    .edit-profile-container {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
    color: #333;
}

.edit-profile-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
}

.form-group {
    margin-bottom: 15px;
}

.edit-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.edit-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease-in-out;
}

.edit-input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.edit-submit {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    font-weight: bold;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.edit-submit:hover {
    background: #0056b3;
}

.alert {
    padding: 10px 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.forgot-password-button {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #007bff;
    font-size: 14px;
    transition: color 0.3s ease-in-out;
}

.forgot-password-button:hover {
    color: #0056b3;
}

</style>
@endsection

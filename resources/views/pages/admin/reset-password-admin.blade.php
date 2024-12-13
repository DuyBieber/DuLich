<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Quên mật khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/style-responsive.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet">
    
</head>
<body>
<div class="log-w3">
    <div class="w3layouts-main">
        <h2>Đặt lại mật khẩu</h2>
        <form action="{{ route('admin.saveNewPassword') }}" method="POST">
            @csrf
            <input type="hidden" name="email" class="form-control ggg"value="{{ $email }}">
            <div class="form-group">
                <label for="password">Mật khẩu mới:</label>
                <input type="password" class="form-control ggg"name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu:</label>
                <input type="password" class="form-control ggg"name="password_confirmation" id="password_confirmation" required>
            </div>
            @error('password')
                <p>{{ $message }}</p>
            @enderror
            <button type="submit"class="btn btn-primary btn-block">Lưu mật khẩu mới</button>
        </form>
    </div>
</div>
<script src="{{ asset('backend/js/bootstrap.js') }}"></script>
<script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
</body>
</html>

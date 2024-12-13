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
            <h2>Quên mật khẩu</h2>

            <!-- Kiểm tra và hiển thị thông báo lỗi đăng nhập không thành công -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('customer.sendResetLink') }}" method="POST">
            @csrf
            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control ggg"name="email" id="email" required>
             @error('email')
            <p style="color: red;">{{ $message }}</p>
            @enderror

            </div>
            
            <br>
            <button type="submit"class="btn btn-primary btn-block">Gửi liên kết đặt lại mật khẩu</button>
</form>
        </div>
    </div>
    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng nhập</title>
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
            <h2>Đăng nhập tài khoản</h2>

            <!-- Kiểm tra và hiển thị thông báo lỗi đăng nhập không thành công -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('customer.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control ggg" name="customer_email" id="email" placeholder="Email" required>
                    <span id="email_error" style="color: red; display: none;">Email không đúng định dạng hoặc không phải Gmail.</span>
                    @error('customer_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control ggg" id="password" name="customer_password" placeholder="Mật khẩu" required>
                    <span id="password_error" style="color: red; display: none;">Mật khẩu phải có ít nhất 6 ký tự.</span>
                    @error('customer_password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <h6><a href="{{ route('customer.forgotPasswordForm') }}">Quên Mật Khẩu?</a></h6>
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                

<!-- Nút quên mật khẩu -->

                <h6 style="width: 100%; float: left; font-size: 12px; margin-top: 7px; font-weight: 600;">
                    Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a> để khám phá nhé!
    </a>
                </h6> 
            </form>
        </div>
    </div>

    <script>
        // Kiểm tra định dạng email khi nhập
        document.getElementById("email").addEventListener("input", function() {
            const email = this.value;
            const emailError = document.getElementById("email_error");
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailRegex.test(email) && email.endsWith("@gmail.com")) {
                emailError.style.display = "none"; // Ẩn lỗi nếu đúng định dạng và là Gmail
            } else {
                emailError.style.display = "block"; // Hiện lỗi nếu sai định dạng hoặc không phải Gmail
                emailError.textContent = "Email không đúng định dạng hoặc không phải email Gmail.";
            }
        });

        // Kiểm tra độ dài mật khẩu khi nhập
        document.getElementById("password").addEventListener("input", function() {
            const password = this.value;
            const passwordError = document.getElementById("password_error");

            if (password.length >= 6) {
                passwordError.style.display = "none"; // Ẩn lỗi nếu mật khẩu đủ dài
            } else {
                passwordError.style.display = "block"; // Hiện lỗi nếu mật khẩu quá ngắn
                passwordError.textContent = "Mật khẩu phải có ít nhất 6 ký tự.";
            }
        });
    </script>

    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
</body>
</html>

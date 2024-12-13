<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng ký</title>
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
            <h2>Đăng ký tài khoản</h2>
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control ggg" name="customer_name" placeholder="Tên" value="{{ old('customer_name') }}" required>
                    @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <input type="email" class="form-control ggg" name="customer_email" placeholder="Email" value="{{ old('customer_email') }}" required>
                    @error('customer_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
    <input type="password" class="form-control ggg" name="customer_password" id="password" placeholder="Mật khẩu" required>
    <input type="password" class="form-control ggg" name="customer_password_confirmation" id="password_confirmation" placeholder="Nhập lại mật khẩu" required>
    @error('customer_password') <small class="text-danger">{{ $message }}</small> @enderror
    <div>
        <input type="checkbox" id="showPassword"> <label for="showPassword">Hiển thị mật khẩu</label>
    </div>
</div>

                <div class="form-group">
                    <input type="text" class="form-control ggg" name="customer_phone" placeholder="Số điện thoại" value="{{ old('customer_phone') }}" required>
                    @error('customer_phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <input type="text" class="form-control ggg" name="customer_address" placeholder="Địa chỉ" value="{{ old('customer_address') }}" required>
                    @error('customer_address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
    <script>
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const invalidEmails = ['example@example.com', 'test@test.com'];

        if (!emailRegex.test(email)) {
            return false;
        }

        if (invalidEmails.includes(email)) {
            return false;
        }

        return true;
    }

    function validatePhone(phone) {
        const phoneRegex = /^0[0-9]{9}$/;
        return phoneRegex.test(phone);
    }

    function validatePassword(password) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;
        return passwordRegex.test(password);
    }

    document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.querySelector('input[name="customer_email"]');
    const phoneInput = document.querySelector('input[name="customer_phone"]');
    const passwordInput = document.querySelector('#password');
    const passwordConfirmInput = document.querySelector('#password_confirmation');
    const emailError = document.createElement('small');
    const phoneError = document.createElement('small');
    const passwordError = document.createElement('small');
    const passwordConfirmError = document.createElement('small');

    emailError.classList.add('text-danger');
    phoneError.classList.add('text-danger');
    passwordError.classList.add('text-danger');
    passwordConfirmError.classList.add('text-danger');

    emailInput.parentNode.appendChild(emailError);
    phoneInput.parentNode.appendChild(phoneError);
    passwordInput.parentNode.appendChild(passwordError);
    passwordConfirmInput.parentNode.appendChild(passwordConfirmError);

    // Hàm kiểm tra email
    emailInput.addEventListener('blur', function() {
        if (!validateEmail(emailInput.value)) {
            emailError.textContent = 'Email không đúng định dạng hoặc là email không hợp lệ.';
        } else {
            emailError.textContent = '';
        }
    });

    // Hàm kiểm tra số điện thoại
    phoneInput.addEventListener('blur', function() {
        if (!validatePhone(phoneInput.value)) {
            phoneError.textContent = 'Số điện thoại không đúng định dạng. (Ví dụ: 0123456789)';
        } else {
            phoneError.textContent = '';
        }
    });

    // Hàm kiểm tra mật khẩu
    passwordInput.addEventListener('blur', function() {
        if (!validatePassword(passwordInput.value)) {
            passwordError.textContent = 'Mật khẩu phải có hơn 5 ký tự, bao gồm chữ in hoa, chữ thường, số và ký tự đặc biệt.';
        } else {
            passwordError.textContent = '';
        }
    });

    passwordConfirmInput.addEventListener('blur', function() {
        if (passwordConfirmInput.value !== passwordInput.value) {
            passwordConfirmError.textContent = 'Mật khẩu nhập lại không khớp.';
        } else {
            passwordConfirmError.textContent = '';
        }
    });

    // Chức năng ẩn hiện mật khẩu
    const showPasswordCheckbox = document.getElementById('showPassword');
    showPasswordCheckbox.addEventListener('change', function() {
        const type = this.checked ? 'text' : 'password';
        passwordInput.type = type;
        passwordConfirmInput.type = type;
    });
});
</script>


</body>
</html>

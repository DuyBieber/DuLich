@extends('layout')

@section('content')
<div class="edit-profile-container">
    <h1 class="edit-profile-title">Chỉnh sửa thông tin cá nhân</h1>

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

    <form action="{{ route('customer.profile.update') }}" method="POST" id="editProfileForm">
        @csrf
        <div class="form-group">
            <label for="customer_name" class="edit-label">Tên</label>
            <input type="text" id="customer_name" name="customer_name" value="{{ $customer->customer_name }}" class="form-control edit-input" required>
            @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="customer_email" class="edit-label">Email</label>
            <input type="email" id="customer_email" name="customer_email" value="{{ $customer->customer_email }}" class="form-control edit-input" required>
            @error('customer_email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="customer_phone" class="edit-label">Số điện thoại</label>
            <input type="text" id="customer_phone" name="customer_phone" value="{{ $customer->customer_phone }}" class="form-control edit-input" required>
            @error('customer_phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="customer_address" class="edit-label">Địa chỉ</label>
            <input type="text" id="customer_address" name="customer_address" value="{{ $customer->customer_address }}" class="form-control edit-input" required>
            @error('customer_address') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="current_password" class="edit-label">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="form-control edit-input">
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
            
        </div>

        <div class="form-group">
            <label for="customer_password" class="edit-label">Mật khẩu mới (nếu muốn thay đổi)</label>
            <input type="password" id="customer_password" name="customer_password" class="form-control edit-input">
            @error('customer_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary edit-submit">Lưu thay đổi</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.getElementById('customer_email');
    const phoneInput = document.getElementById('customer_phone');
    const passwordInput = document.getElementById('customer_password');

    const emailError = document.createElement('small');
    const phoneError = document.createElement('small');
    const passwordError = document.createElement('small');

    emailError.classList.add('text-danger');
    phoneError.classList.add('text-danger');
    passwordError.classList.add('text-danger');

    emailInput.parentNode.appendChild(emailError);
    phoneInput.parentNode.appendChild(phoneError);
    passwordInput.parentNode.appendChild(passwordError);

    // Hàm kiểm tra email
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const invalidEmails = ['example@example.com', 'test@test.com'];
        return emailRegex.test(email) && !invalidEmails.includes(email);
    }

    // Hàm kiểm tra số điện thoại
    function validatePhone(phone) {
        const phoneRegex = /^0[0-9]{9}$/;
        return phoneRegex.test(phone);
    }

    // Hàm kiểm tra mật khẩu
    function validatePassword(password) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;
        return passwordRegex.test(password);
    }

    // Kiểm tra email khi rời khỏi trường
    emailInput.addEventListener('blur', function() {
        if (!validateEmail(emailInput.value)) {
            emailError.textContent = 'Email không đúng định dạng hoặc là email không hợp lệ.';
        } else {
            emailError.textContent = '';
        }
    });

    // Kiểm tra số điện thoại khi rời khỏi trường
    phoneInput.addEventListener('blur', function() {
        if (!validatePhone(phoneInput.value)) {
            phoneError.textContent = 'Số điện thoại không đúng định dạng. (Ví dụ: 0123456789)';
        } else {
            phoneError.textContent = '';
        }
    });

    // Kiểm tra mật khẩu khi rời khỏi trường
    passwordInput.addEventListener('blur', function() {
        if (passwordInput.value && !validatePassword(passwordInput.value)) {
            passwordError.textContent = 'Mật khẩu phải có hơn 5 ký tự, bao gồm chữ in hoa, chữ thường, số và ký tự đặc biệt.';
        } else {
            passwordError.textContent = '';
        }
    });
});
</script>
@endsection

@extends('admin_layout')
@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh sách khách hàng</h3>
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
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Ngày cập nhật</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $key => $customer)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ $customer->customer_email }}</td>
                <td>{{ $customer->customer_phone }}</td>
                <td>{{ $customer->customer_address }}</td>
                <td>{{ $customer->created_at }}</td>
                <td>{{ $customer->updated_at }}</td>
                <td>
                    <a href="{{ route('customers.edit', [$customer->id]) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('customers.destroy', [$customer->id]) }}" method="POST" style="display:inline;">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
<table class="table">
<div class="card-header">
        <h3 class="card-title">Bình luận</h3>
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
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên khách hàng</th>
            <th>Tour</th>
            <th>Đánh giá</th>
            <th>Bình luận</th>
            <th>Trả lời</th> <!-- Thêm cột trả lời -->
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->customer ? $review->customer->customer_name : 'Khách hàng không xác định' }}</td>
                <td>{{ $review->tour ? $review->tour->title_tours : 'Tour không xác định' }}</td>
                <td>{{ str_repeat('⭐', $review->rating) }}</td>
                <td>{{ $review->comment }}</td>
                <td>
                    <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                        @csrf
                        <textarea name="admin_reply" rows="2" placeholder="Trả lời..."></textarea>
                        <button type="submit" class="btn btn-primary btn-sm">Gửi</button>
                    </form>
                    @if($review->admin_reply)
                        <p><strong>Trả lời:</strong> {{ $review->admin_reply }}</p>
                    @endif
                </td>
                <td>
    <!-- Nút Xóa -->
    <form action="{{ route('reviews.destroy.admin', $review->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
    </form>
</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>


@endsection

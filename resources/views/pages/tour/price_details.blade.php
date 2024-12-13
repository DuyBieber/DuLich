<div class="mda-price-tour-r clearfix">
    <div class="table-wrapper">
        <div class="mda-table-container">
            <table class="mda-table chitiet_gia">
                <tbody>
                    <tr>
                        <td><span><b>Loại giá\Độ tuổi</b></span></td>
                        <td>Người lớn (Trên 11 tuổi)</td>
                        <td>Trẻ em (5 - 11 tuổi)</td>
                        <td>Trẻ nhỏ (2 - 5 tuổi)</td>
                        <td>Sơ sinh (&lt; 2 tuổi)</td>
                    </tr>
                    <tr>
                        <td><span><b>Giá</b></span></td>
                        <td><span class="mda-money">{{ number_format($tourPriceDetail->adult_price, 0, ',', '.') }}</span> đ</td>
                        <td><span class="mda-money">{{ number_format($tourPriceDetail->child_price, 0, ',', '.') }}</span> đ</td>
                        <td><span class="mda-money">{{ number_format($tourPriceDetail->infant_price, 0, ',', '.') }}</span> đ</td>
                        <td><span class="mda-money">{{ number_format($tourPriceDetail->baby_price, 0, ',', '.') }}</span> đ</td>
                    </tr>
                    <tr>
                        <td><span><b>Phụ thu Khách Nước Ngoài</b></span></td>
                        <td colspan="4" style="text-align: center;">
                            <span class="mda-money">{{ number_format($tourPriceDetail->foreign_surcharge, 0, ',', '.') }}</span> đ
                        </td>
                    </tr>
                    <tr>
                        <td><span><b>Phụ thu Phòng đơn</b></span></td>
                        <td colspan="4" style="text-align: center;">
                            <span class="mda-money">{{ number_format($tourPriceDetail->single_room_surcharge, 0, ',', '.') }}</span> đ
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

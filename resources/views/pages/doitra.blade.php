@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/chinhsachdoitrahangh.css')}}">
<div id="contain">
    <h1 style="text-align: center; margin: 20px;">Chính sách đổi - trả hàng</h1>
    <ul>
        <li>Đổi hàng - trả hàng miễn phí:</li>
            <p>Bên mua sẽ được đổi hàng – trả hàng miễn phí trong thời gian 07 (bảy) ngày kể từ khi nhận hàng hóa với điều kiện: hàng hóa chưa qua sử dụng còn nguyên tem mác, nguyên kiện và có đầy đủ hóa đơn mua hàng.</p>
        <li>Đổi hàng - trả hàng tính phí:</li>

            <p>- Đối với hàng hóa chưa qua sử dụng, còn nguyên tem mác, nguyên kiện và có đầy đủ hóa đơn mua hàng: từ ngày thứ 8 đến ngày thứ 15 sau khi nhận hàng hóa nếu bên mua có nhu cầu muốn đổi sản phẩm khác hoặc trả lại sản phẩm thì sẽ áp dụng mức phí là 15% giá trị sản phẩm.</p>
            <p>-  Đối với hàng hóa đã tháo vỏ bao bì, tem mác, trong vòng 15 ngày:</p>
                <p>+ Bên mua đổi sản phẩm khác mất phí 15% giá trị sản phẩm.</p>
                <p>+ Bên mua Trả sản phẩm mất phí 30% giá trị sản phẩm.</p>

        <li>Không áp dụng đổi - trả hàng:</li>

            <p>- Sản phẩm mua trong các chương trình khuyến mại, giảm giá, sử dụng phiếu mua hàng (voucher), điểm tích lũy.</p>
            <p>- Sản phẩm bên mua đã nhận hàng vượt quá 15 ngày kể từ ngày ghi trên hóa đơn mua hàng.</p>
            <p>- Sản phẩm đặt riêng theo yêu cầu (ví dụ: Thẻ tên)</p>

        <li>Điều khoản vận chuyển sản phẩm đổi - trả:</li>

            <p>Bên mua phải tự vận chuyển sản phẩm đổi - trả đến nơi mua hàng hoặc chịu toàn bộ chi phí vận chuyển sản phẩm đổi hoặc trả theo quy định của bên bán.</p>

        <li>Xuất trả hóa đơn VAT:</li>

            <p>Do bên bán sử dụng hoá đơn điện tử và xuất hoá đơn trong ngày bán hàng, chính vì vậy: Trong mọi trường hợp đổi hàng - trả hàng nếu bên mua đã lấy hóa đơn VAT (hóa đơn giá trị gia tăng) thì bên mua có trách nhiệm xuất hóa đơn VAT hoàn trả chính xác các sản phẩm cần đổi - trả cho bên bán. Nếu bên mua không xuất hóa đơn VAT lại cho bên bán của sản phẩm đổi - trả thì bên bán có quyền hủy hóa đơn có sản phẩm đổi - trả.</p>
    
    </ul>
    <br><br><br>
</div>
@endsection
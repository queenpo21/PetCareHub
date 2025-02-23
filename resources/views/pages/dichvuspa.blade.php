@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/dvspa.css')}}">
<div class="title">
    <h3><strong>DỊCH VỤ SPA/CẮT TỈA CHO THÚ CƯNG</strong></h3>
</div>
<div class="form-container">
    <div class="form-column1">
        <h4><b>🐶😸 PET SALON HÀNG ĐẦU CHO THÚ CƯNG</b></h4>
        <hr style="border: 1px solid black;opacity: 1;">
        <p><strong>Bạn đang tìm kiếm dịch vụ cắt tỉa lông chó mèo chuyên nghiệp gần đây?</strong></p>
        <p><a title="Pet Care Hub" href=" https://www.petcarehub.vn">Pet Care Hub</a> tự hào là địa chỉ cung cấp
            dịch vụ chăm sóc và làm đẹp trọn gói tốt nhất cho thú cưng của bạn.</p>
        <p><strong>Dịch vụ đa dạng:</strong> cung cấp đa dạng các dịch vụ cắt tỉa lông cho chó mèo, từ cắt tỉa
            theo kiểu cơ bản đến tạo kiểu theo yêu cầu.</p>
        <p><strong>Sản phẩm an toàn:</strong>sử dụng các sản phẩm chăm sóc thú cưng không chứa paraben,
            phthalates và thuốc nhuộm hóa học, đảm bảo an toàn cho sức khỏe của thú cưng.</p>
    </div>
    <div class="form-column2">
        <img src="{{asset('public/frontend/image_task2/img-pet.png')}}">
    </div>
</div>
<br><br><br>

<div class="banner">
    <h4><br><strong>👍 3 ĐIỀU LUÔN CAM KẾT VỚI KHÁCH HÀNG</strong></h4>
    <hr style="border: 1px solid #ffffff;opacity: 1;">
    <div id="banner-body">
        <div class="commitment">
            <h5><strong>❣️ HẾT MÌNH VÌ CÔNG VIỆC</strong></h5>
            <p>Tại Pet Care Hub, chúng tôi luôn đặt chữ tâm, trách nhiệm lên hàng đầu. Đối với chúng tôi, thú cưng khỏe mạnh là niềm hạnh phúc lớn nhất.</p>
        </div>
        <div class="commitment">
            <h5><strong>✅ GIÁ DỊCH VỤ RẺ NHẤT</strong></h5>
            <p>Chúng tôi cam kết đưa ra mức giá ưu đãi nhất trên thị trường để tất cả thú cưng đều có cơ hội
                được trải nghiệm dịch vụ của chúng tôi.</p>
        </div>
        <div class="commitment">
            <h5><strong>🥇 CHẤT LƯỢNG HÀNG ĐẦU</strong></h5>
            <p>Chúng tôi không ngừng nâng cao phát triển trình độ kỹ năng của nhân sự để phục vụ thú cưng
                đem đến kết quả tốt nhất cho công việc.</p>
        </div>
    </div>
</div>
<br><br><br>

<div class="form-container" id="style-responsive">
    <div class="form-column1">
        <img src="{{asset('public/frontend/image_task2/img-pet2.png')}}">
    </div>
    <div class="form-column2">
        <h4><strong>⚠️ TẠI SAO NÊN CẮT TỈA LÔNG CHO CHÓ MÈO TẠI PET MART?</strong></h4>
        <hr style="border: 1px solid black;opacity: 1;">
        <p><strong>Đội ngũ nhân viên chuyên nghiệp:</strong></p>
        <p>Đội ngũ nhân viên của Pet Care Hub được đào tạo bài bản về kỹ thuật cắt tỉa lông cho từng giống chó
            mèo khác nhau.</p>
        <p>Pet Care Hub hiểu rằng thú cưng là thành viên trong gia đình bạn, vì vậy chúng tôi luôn chăm sóc các
            bé với tình yêu thương và sự tận tâm.</p>
        <p>Pet Care Hub có kinh nghiệm cắt tỉa lông cho nhiều giống chó mèo khác nhau, từ Poodle, Phốc sóc,
            Samoyed đến Nhật, Corgi,mèo Anh lông dài...</p>
        <p><strong>Hãy liên hệ ngay với Pet Care Hub để đặt lịch hẹn cắt tỉa lông cho thú cưng của bạn!</strong>
        </p>
    </div>
</div>
<br><br><br>

<div class="contain1">
    <h4><strong>💲 BẢNG GIÁ DỊCH VỤ SPA, CẮT TỈA LÔNG CHÓ MÈO TRỌN GÓI</strong></h4>
    <hr style="border: 1px solid black;opacity: 1;">
    <p><strong>Bảng giá cắt lông chó mèo đã bao gồm: </strong>Dịch vụ tắm cho chó mèo trọn gói, sấy khô, chải
        lông rụng, cắt dũa móng, vệ sinh tai mà không phát sinh thêm bất cứ phụ phí nào khác. Giá dịch vụ thực
        tế dựa theo hiện trạng kích cỡ, trọng lượng và nhu cầu phát sinh thêm của khách hàng.</p>
    <div class="info-img">
        <div class="anh">
            <img src="{{asset('public/frontend/image/2kg.webp')}}">
            <p>Thú cưng có trọng lượng dưới 2kg</p>
            <b class="mau">250k</b>
        </div>
        <div class="anh">
            <img src="{{asset('public/frontend/image/5kg.jpg')}}">
            <p>Thú cưng có trọng lượng dưới 5kg</p>
            <b class="mau">350k</b>
        </div>
        <div class="anh">
            <img src="{{asset('public/frontend/image/10kg.jpg')}}">
            <p>Thú cưng có trọng lượng dưới 10kg</p>
            <b class="mau">400k</b>
        </div>
        <div class="anh">
            <img src="{{asset('public/frontend/image/d2okh.webp')}}">
            <p>Thú cưng có trọng lượng dưới 20kg</p>
            <b class="mau">650k</b>
        </div>
        <div class="anh">
            <img src="{{asset('public/frontend/image/20kg.jpg')}}">
            <p>Thú cưng có trọng lượng trên 20kg</p>
            <b class="mau">800k</b>
        </div>
    </div>

</div>
<br><br><br>
<div class="contain1">
    <h4><b>💲 BẢNG GIÁ DỊCH VỤ SPA, CẮT TỈA LÔNG CHÓ MÈO CHI TIẾT</b></h4>
    <hr style="border: 1px solid black;opacity: 1;">
    <p>Pet Care Hub cung cấp đa dạng dịch vụ spa, cắt tỉa lông cho chó mèo với mức giá ưu đãi. Bảng giá dưới đây
        chỉ mang tính chất tham khảo, giá thực tế có thể thay đổi tùy thuộc vào kích cỡ, trọng lượng, độ dài và
        tình trạng lông của thú cưng.</p>
    <div class="column">
        <div class="gia">
            <p><strong>Tắm & Sấy</strong></p>
            <p>+Size dưới 5kg: 100.000 VNĐ</p>
            <p>+Size từ 5-10kg: 150.000 VNĐ</p>
            <p>+Size từ 10-20kg: 200.000 VNĐ</p>
            <p>+Size trên 20kg : 250.000 VNĐ</p>
        </div>
        <div class="gia">
            <p><strong>Cắt Tỉa Lông - Cắt tỉa theo kiểu:</strong></p>
            <p>+ Size dưới 5kg: 150.000 VNĐ</p>
            <p>+ Size từ 5-10kg: 200.000 VNĐ</p>
            <p>+ Size từ 10-20kg: 300.000 VNĐ</p>
            <p>+ Size trên 20kg: 600.000 VNĐ</p>
        </div>
        <div class="gia">
            <p><strong>Cắt Tỉa Lông - Cắt tỉa toàn thân:</strong></p>
            <p>+ Size dưới 5kg: 300.000 VNĐ</p>
            <p>+ Size từ 5-10kg: 300.000 VNĐ</p>
            <p>+ Size từ 10-20kg: 400.000 VNĐ</p>
            <p>+ Size trên 20kg: 600.000 VNĐ</p>
        </div>
    </div>
    <div class="column">
        <div class="gia">
            <p><strong>Gói Spa Cơ Bản</strong></p>
            <p>+Size dưới 5kg: 300.000</p>
            <p>+Size từ 5-10kg: 400.000</p>
            <p>+Size từ 10-20kg: 500.000</p>
            <p>+Size trên 20kg: 600.000</p>
        </div>
        <div class="gia">
            <p><strong>Gói Spa Cao Cấp</strong></p>
            <p>+Size dưới 5kg: 450.000</p>
            <p>+Size từ 5-10kg: 550.000</p>
            <p>+Size từ 10-20kg: 650.000</p>
            <p>+Size trên 20kg: 750.000</p>
        </div>
        <div class="gia">
            <p><strong>Dịch Vụ Khác</strong></p>
            <p>+Cắt móng: 50.000 VNĐ</p>
            <p>+Vệ sinh tai: 50.000 VNĐ</p>
            <p>+Nặn tuyến hôi: 50.000 VNĐ</p>
            <p>+Gỡ rối lông: 100.000/giờ</p>
        </div>
    </div>
    <div class="note">
        <p><strong>LƯU Ý:</strong></p>
        <p>Giá trên đã bao gồm VAT.</p>
        <p>Miễn phí dịch vụ cắt móng cho khách hàng sử dụng gói Spa Cao Cấp.</p>
        <p>Chúng tôi có chương trình ưu đãi dành cho khách hàng thân thiết và đặt lịch hẹn trước.</p>
    </div>

</div>
<br>

<br><br><br>

<div class="form-container">
    <div class="form-column1">
        <h4><strong>📛 LƯU Ý KHI SỬ DỤNG DỊCH VỤ GROOMING</strong></h4>
        <hr style="border: 1px solid black;opacity: 1;">
        <p>Pet Care Hub luôn mong muốn mang đến dịch vụ tốt nhất và đảm bảo an toàn cho tất cả các bé thú cưng.
            Do vậy, chúng tôi xin thông báo một số trường hợp Pet Care Hub không tiếp nhận và lưu ý khi đưa thú
            cưng đến làm dịch vụ.</p>
        <p>1. Trường hợp Pet Care Hub không tiếp nhận: Thú cưng đang mang thai, thú cưng đang điều trị bệnh,
            không tiếp nhận thú cưng đang mắc bệnh truyền nhiễm hoặc cần điều trị y tế đặc biệt.</p>
        <p>2. Lưu ý khi đưa thú cưng đến làm dịch vụ: Để đảm bảo sức khỏe cho thú cưng, không nên để bé quá đói
            hoặc ăn quá no trước khi đến cửa hàng.</p>
        <p><strong>Pet Care Hub xin trân trọng cảm ơn quý khách đã quan tâm và sử dụng dịch vụ của chúng
                tôi!</strong></p>
    </div>
    <div class="form-column2">
        <img src="{{asset('public/frontend/image_task2/img-pet3.png')}}">
    </div>
</div>
<br><br><br>

<div class="contain">
    <h4><b>🩺 TRẢI NGHIỆM AN TOÀN CHO THÚ CƯNG LÀ ƯU TIÊN SỐ 1</b></h4>
    <hr style="border: 1px solid black;opacity: 1;">
    <div class="chitiet">
        <div class="conner">
            <p>Sức khỏe tổng thể của thú cưng là ưu tiên hàng đầu của chúng tôi, vì vậy sau khi kết thúc dịch vụ
                chúng tôi sẽ gửi tới khách hàng bản báo cáo đầy đủ nêu chi tiết các dịch vụ được cung cấp và
                những khuyến nghị chăm sóc để giúp thú cưng khỏe mạnh và tốt hơn trong lần cắt tỉa tiếp theo.
            </p>
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" ><i class="fa-solid fa-chevron-down"></i>&nbsp; 1. Tiếp nhận tư
                                vấn dịch vụ. </a> 
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p><strong>Quy trình tiếp nhận thú cưng tại Pet Care Hub </strong></p>
                            <p><strong>1. Giờ làm việc:</strong></p>
                            <p>Bộ phận dịch vụ bắt đầu làm việc từ 9h sáng hàng ngày.</p>
                            <p><strong>2. Kiểm tra sàng lọc:</strong></p>
                            <p>Khi bạn đưa thú cưng đến Pet Care Hub, nhân viên của chúng tôi sẽ kiểm tra sàng
                                lọc nhanh tình trạng sức khỏe để đảm bảo không có vấn đề gì bất thường.</p>
                            <p>Việc kiểm tra sàng lọc này không có giá trị thay thế cho việc khám sức khỏe tổng
                                quát từ bác sĩ thú y. Nếu chúng tôi đánh giá thấy bất kỳ mối lo ngại nào, chúng
                                tôi sẽ giới thiệu bạn đến bác sĩ thú y tốt nhất.</p>
                            <p><strong>3. Chờ đợi:</strong></p>
                            <p>Nếu bạn đưa thú cưng đến cửa hàng trước 9h sáng, thú cưng sẽ được chờ trong phòng
                                có điều hòa.</p>
                            <p>Chúng tôi sẽ cung cấp thức ăn nhẹ và nước uống cho thú cưng trong suốt quá trình
                                làm dịch vụ.</p>
                            <p>Mỗi thú cưng sẽ được gắn số thứ tự và ở từng chuồng riêng biệt.</p>
                            <p><strong>4. Tiếp nhận và tư vấn:</strong></p>
                            <p>Vào ca làm việc, nhân viên của chúng tôi sẽ gọi điện trực tiếp cho bạn để:Tiếp
                                nhận các yêu cầu của bạn về dịch vụ và tư vấn cụ thể về dịch vụ phù hợp với thú
                                cưng của bạn.</p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="fa-solid fa-chevron-down"></i>&nbsp; 2. Chải chuốt
                                lông, cắt móng, cạo lông.</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p><strong>Quy trình thực hiện dịch vụ cho thú cưng tại Pet Care Hub</strong></p>
                            <p><strong>1. Chải lông:</strong></p>
                            <p>Sử dụng dụng cụ phù hợp để loại bỏ lông rụng và bụi bẩn trên bộ lông của thú
                                cưng.</p>
                            <p>Đối với những trường hợp lông bị rối, chúng tôi sẽ sử dụng kỹ thuật chuyên nghiệp
                                để gỡ rối nhẹ nhàng, tránh làm tổn thương da và lông của thú cưng.</p>
                            <p>Tùy theo yêu cầu của bạn, chúng tôi có thể chải chuốt theo kiểu cơ bản hoặc tạo
                                kiểu theo yêu cầu.</p>
                            <p><strong>2. Cắt dũa và mài móng chân:</strong></p>
                            <p>Sử dụng dụng cụ cắt móng chuyên dụng để cắt móng cho thú cưng một cách an toàn,
                                chính xác.</p>
                            <p>Dũa nhẵn các cạnh sắc sau khi cắt móng để tránh làm thú cưng bị trầy xước.</p>
                            <p>Sử dụng máy mài móng chuyên dụng để làm nhẵn móng cho thú cưng, giúp móng đẹp và
                                an toàn hơn.</p>
                            <p><strong>3. Cạo lông (theo yêu cầu):</strong></p>
                            <p>Tùy theo yêu cầu của bạn, chúng tôi có thể cạo lông theo kiểu cơ bản hoặc tạo
                                kiểu theo yêu cầu.</p>
                            <p>Sử dụng tông đơ cạo lông chuyên dụng để cạo lông cho thú cưng một cách an toàn,
                                chính xác.</p>
                            <p>Sử dụng kem dưỡng da để bảo vệ da của thú cưng sau khi cạo lông.</p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="fa-solid fa-chevron-down"></i>&nbsp; 3. Tắm, lau
                                khô, sấy và vệ sinh tai, mắt.</a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p><strong>Quy trình tắm sấy, lau khô và vệ sinh tai, mắt cho thú cưng tại Pet Care
                                    Hub:</strong></p>
                            <p><strong>1. Tắm:</strong></p>
                            <p>Pet Care Hub áp dụng quy trình tắm 3 lần để đảm bảo loại bỏ hoàn toàn bụi bẩn,
                                mùi hôi và lông rụng trên cơ thể thú cưng.</p>
                            <p>Chúng tôi sử dụng các loại sữa tắm của thương hiệu nổi tiếng, thơm lâu và an toàn
                                cho da và lông của thú cưng.</p>
                            <p>Tùy theo loại da và lông của thú cưng, chúng tôi sẽ lựa chọn loại sữa tắm và
                                phương pháp tắm phù hợp.</p>
                            <p><strong>2. Sấy khô:</strong></p>
                            <p>Pet Care Hub sử dụng những phương pháp, kỹ năng sấy khô lông chuyên nghiệp đa
                                dạng để đảm bảo sự thoải mái nhất cho thú cưng.</p>
                            <p>Chúng tôi sử dụng máy sấy chuyên dụng có chế độ điều chỉnh nhiệt độ phù hợp để
                                tránh làm tổn thương da và lông của thú cưng.</p>
                            <p>Sấy khô hoàn toàn bộ lông của thú cưng để tránh tình trạng ẩm ướt gây nấm da và
                                các bệnh lý khác</p>
                            <p><strong>3. Vệ sinh tai, mắt:</strong></p>
                            <p>Vệ sinh tai: Sử dụng dung dịch vệ sinh tai chuyên dụng để làm sạch bụi bẩn và ráy
                                tai trong tai của thú cưng.</p>
                            <p>Vệ sinh mắt: Sử dụng dung dịch vệ sinh mắt chuyên dụng để làm sạch bụi bẩn và
                                ghèn mắt cho thú cưng.</p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="fa-solid fa-chevron-down"></i>&nbsp; 4. Thực hiện
                                cắt tỉa lông tạo kiểu.</a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p><strong>Pet Care Hub sở hữu đội ngũ chuyên gia cắt tỉa lông với:</strong></p>
                            <p>Kỹ năng đa dạng: Có khả năng cắt tỉa lông cho nhiều giống chó khác nhau.</p>
                            <p>Thẩm mỹ được chứng nhận: Đã được đào tạo bài bản về thẩm mỹ và có kinh nghiệm
                                tạo kiểu cho thú cưng.</p>
                            <p><strong>Dịch vụ cắt tỉa lông tạo kiểu tại Pet Care Hub bao gồm:</strong></p>
                            <p>Cắt tỉa theo yêu cầu: Tùy theo yêu cầu của bạn, chúng tôi có thể cắt tỉa theo
                                kiểu cơ bản hoặc tạo kiểu theo yêu cầu.</p>
                            <p>Cắt tỉa theo giống chó/mèo: Chúng tôi có hiểu biết về đặc điểm của từng giống
                                chó/mèo và sẽ cắt tỉa phù hợp với từng giống.</p>
                            <p>Cắt tỉa an toàn: Sử dụng dụng cụ chuyên dụng, an toàn cho thú cưng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="comn">
                <h4><b>🏆 NHÂN VIÊN SPA, CẮT TỈA LÔNG CHÓ MÈO (PET GROOMER) ĐƯỢC PET CARE HUB CẤP CHỨNG NHẬN</b>
                    <hr style="border: 1px solid black;opacity: 1;">
                    <p>Sức khỏe và phúc lợi của thú cưng là trọng tâm trong mọi công việc mà chúng tôi đang làm
                        và
                        tuyển dụng nhân sự.</p>
                    <p>Nhân viên chăm sóc thú cưng tại Pet Care Hub không chỉ yêu thích công việc của họ, mà còn
                        được
                        đào tạo theo tiêu chuẩn cao nhất và phải hoàn thành xuất sắc khóa học của chúng tôi để
                        được
                        cấp chứng chỉ làm việc chính thức.</p>
            </div>
        </div>
    </div>
</div>
<br><br><br>


<div class="contain1">
    <h4><b>ĐỪNG QUÊN CHĂM SÓC THÚ CƯNG SAU KHI LÀM DỊCH VỤ!</b></h4>
    <hr style="border: 1px solid black;opacity: 1;">
    <p>Mặc dù việc gần như thường xuyên ghé thăm cửa hàng của chúng tôi để sử dụng dịch vụ sẽ giúp thú cưng của
        bạn sạch sẽ và đẹp hơn. Nhưng đừng quên việc chải lông, vệ sinh tai hàng ngày cho các bé khi ở nhà. Việc
        đó sẽ giúp cho thú cưng luôn duy trì được sự sạch sẽ, khỏe mạnh. Hãy tham khảo các mẹo và sản phẩm mà
        chúng tôi sử dụng để chăm sóc cho thú cưng của bạn tại nhà.</p>
    <div class="products-list">
        @foreach($topSales as $top)
        <div class="item">
            <a href="{{URL::to('/chi-tiet-san-pham-'.$top->id)}}">
                <div class="img-products">
                    <img src="public/storage/products/{{$top->image}}" alt="" >
                </div>
                <div class="text-truncate-container">
                    <p>{{$top->name}}</p>
                </div>
                <div class="pro-price">
                    @if ($top->min_price == $top->max_price)
                        {{ number_format($top->min_price, 0, '.', '.') }} VNĐ
                    @else
                        {{ number_format($top->min_price, 0, '.', '.') }} - {{ number_format($top->max_price, 0, '.', '.') }} VNĐ
                    @endif
                </div>
                <div class="sales">
                    <p>Lượt bán:</p> 
                    <p class="number-of-sales">{{ number_format($top->number_of_sale, 0, '.', '.') }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
<br>

<br><br><br>
@endsection
{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
{/literal}
<main>
    <div class="introduce container flex">
        <div class="introduce__content">
            <h4>TSI HẤP DẪN CÁC NHÀ ĐẦU TƯ NHƯ THẾ NÀO ?</h4>
            <p>Là hình thức góp vốn hợp tác đầu tư vào Thị trường Chứng khoán Việt Nam giữa các nhà đầu tư và Thạch Sanh Investment (TSI). Khoản đầu tư được quản lý trên cùng 1 tài khoản bởi đội ngũ chuyên gia giàu kinh nghiệm của TSI với mục tiêu mang lại lợi nhuận cao nhất cho Nhà đầu tư. Như vậy, hợp tác đầu tư với TSI là hình thức đầu tư chứng khoán gián tiếp thay vì Nhà đầu tư trực tiếp đầu tư trên thị trường chứng khoán.</p>
            <p>TSI chính là cầu nối nhằm giúp các nhà đầu tư cá nhân bước chân vào TTCK với thời gian và chi phí thấp nhất mà vẫn thu được lợi nhuận cao.</p>
        </div>
        <div class="introduce__video">
            <video controls>
                <source src="{$smarty.const._DOMAIN_ROOT_URL}/image/TSTT.mp4" type="video/mp4">
            </video>
        </div>
    </div>
    <div class="characteristics">
        <div class="container">
            <h2 class="title">THẠCH SANH TĂNG TRƯỞNG - TSTT</h2>
            <ul class="characteristics__list flex">
                <li>
                    <div class="icon flex-center"><img src="../../assets/img/icon-dt1.png" alt=""></div>
                    <h5>DANH MỤC CHỌN LỌC</h5>
                    <p>Đầu tư vào cổ phiếu</p>
                </li>
                <li>
                    <div class="icon flex-center"><img src="../../assets/img/icon-company.png" alt=""></div>
                    <h5>ĐẦU TƯ TĂNG TRƯỞNG</h5>
                    <p>Tập trung vào các công ty có khả năng <br> tăng trưởng mạnh trong ngắn hạn</p>
                </li>
                <li>
                    <div class="icon flex-center"><img src="../../assets/img/icon-mt.png" alt=""></div>
                    <h5>SINH LỜI HIỆU QUẢ</h5>
                    <p>Mục tiêu đầu tư: <br> 50 - 100%/ năm</p>
                </li>
                <li>
                    <div class="icon flex-center"><img src="../../assets/img/icon-invest.png" alt=""></div>
                    <h5>KHÔNG CẦN VỐN LỚN</h5>
                    <p>Vốn đầu tư tối thiểu 10 triệu đồng</p>
                </li>
                <li>
                    <div class="icon flex-center"><img src="../../assets/img/icon-db.png" alt=""></div>
                    <h5>ĐÒN BẨY LINH HOẠT</h5>
                    <p>Sử dụng đòn bẩy tài chính</p>
                </li>
                <li>
                    <div class="icon flex-center"><img src="../../assets/img/icon-rr1.png" alt=""></div>
                    <h5>THANH KHOẢN HÀNG TUẦN</h5>
                    <p>Rút tiền vào thứ 5 hàng tuần</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="service bg-gray">
        <div class="container">
            <h2 class="title">HIỆU QUẢ ĐẦU TƯ</h2>
            <div class="flex">
                <div class="col-left">
					<h4>ĐẦU TƯ TĂNG TRƯỞNG (TSTT) - Ngày {$arrTSI.date}</h4>
					<div class="statistical">
						<div class="statistical__item">
							<h5>Tài sản ròng</h5>
							<span>{format_number number=$arrTSI.taisan}</span>
						</div>
						<div class="statistical__item">
							<h5>Tổng số lượng ĐVĐT</h5>
							<span>{format_number number=$arrTSI.khoiluong}</span>
						</div>
						<div class="statistical__item">
							<h5>Giá 1 ĐVT</h5>
							<span>{format_number number=$arrTSI.giadvdt}</span>
						</div>
					</div>
					<div class="percent flex-center"> {if (($arrTSI.giadvdt-$arrTSITangGiam.giadvdt))>0}<font><i class="fal fa-long-arrow-up"></i>{format_number2 number=($arrTSI.giadvdt-$arrTSITangGiam.giadvdt)/$arrTSITangGiam.giadvdt*100}<sup>%</sup></font>{else}<font style="color:#FF0000"><i class="fal fa-long-arrow-down"></i>{format_number2 number=($arrTSI.giadvdt-$arrTSITangGiam.giadvdt)/$arrTSITangGiam.giadvdt*100}<sup>%</sup></font>{/if}</div>
					<div class="box-btn">
					 {if $username}<a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI.id}" rel="modal:open" class="btn btn_primary flex-center">ĐầU TƯ NGAY</a>{else}<a class="btn btn_primary flex-center" href="javascript:alert('Bạn cần đăng nhập thể thực hiện chức năng này')">ĐầU TƯ NGAY</a>{/if}
					   
					
					</div>
				</div>
				<div class="col-right">
					<ul class="tab nav">
						<li><a href="#tab1" data-toggle="tab" class="active">HIỆU QUẢ ĐẦU TƯ</a></li>
						<li><a href="#tab2" data-toggle="tab">SO SÁNH VỚI VNINDEX</a></li>
					</ul>
					<div class="tab-content">
						{hieuqua}
					</div>
				</div>                
            </div>
        </div>
    </div>
    <div class="report report--cs">
        <div class="container">
            <ul class="tab nav">
                <li><a href="#report1" data-toggle="tab" class="active">báo cáo nav</a></li>
                <li><a href="#report2" data-toggle="tab">danh mục đầu tư</a></li>
                <li><a href="#report3" data-toggle="tab">báo cáo hđđt</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="report1">
                    <div class="box-table">
                        {$navtstt}
                    </div>                   
                </div>
                <div class="tab-pane fade" id="report2">{$danhmucdttstt}</div>
                <div class="tab-pane fade" id="report3">{producthome}</div>
            </div>
        </div>
    </div>
    <div class="policy">
        <div class="container">
            <h2 class="title">ĐIỀU KHOẢN DỊCH VỤ</h2>
            <ul class="tab nav">
                <li><a href="#policy1" class="active" data-toggle="tab">Cách tính ĐVĐT</a></li>
                <li><a href="#policy6" data-toggle="tab">Hoàn trả vốn góp</a></li>
                <li><a href="#policy2" data-toggle="tab">Phân chia lợi nhuận</a></li>
                <li><a href="#policy4" data-toggle="tab">Biểu Thuế & Phí</a></li>
                <li><a href="#policy3" data-toggle="tab">Quyền lợi khách hàng</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="policy1">
                    <div class="document">
                        {$cachtinhdvdt}
                    </div>
                </div>
                 <div class="tab-pane fade" id="policy6">
                    <div class="document">{$hoantravongop}</div>
                </div>
                <div class="tab-pane fade" id="policy2">
                    <div class="document">{$phanchialoinhuan}</div>
                </div>
                <div class="tab-pane fade" id="policy4">
                    <div class="document">{$bieuphi}</div>
                </div>
                <div class="tab-pane fade" id="policy3">
                    <div class="document">{$hoahonggioithieu}</div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="accordion">
        <div class="item">
            <div class="item__header flex-lc">
                <h5>DANH MỤC CHỌN LỌC</h5>
                <button type="button"></button>
            </div>
            <div class="item__content">
                {$danhmuc}
            </div>
        </div>
        <div class="item">
            <div class="item__header flex-lc">
                <h5>PHƯƠNG PHÁP ĐẦU TƯ</h5>
                <button type="button"></button>
            </div>
            <div class="item__content">
				{$phuongphap}
            </div>
        </div>
        <div class="item">
            <div class="item__header flex-lc">
                <h5>CHIẾN LƯỢC ĐẦU TƯ</h5>
                <button type="button"></button>
            </div>
            <div class="item__content">
				{$chienluoc}
            </div>
        </div>
        <div class="item">
            <div class="item__header flex-lc">
                <h5>QUẢN TRỊ RỦI RO</h5>
                <button type="button"></button>
            </div>
            <div class="item__content">
				{$ruiro}
            </div>
        </div>
        
        <div class="item">
            <div class="item__header flex-lc">
                <h5>Q&A</h5>
                <button type="button"></button>
            </div>
            <div class="item__content">
				{$faq}
            </div>
        </div>
    </div>
    <div class="feedback pt-fb">
        <div class="container">
            <h2 class="title">CẢM NHẬN KHÁCH HÀNG</h2>
            <div class="feedback__list">
                {diendanmo}  
            </div>
        </div>
    </div>
</main>
{literal}
<script>
	/*Accordion*/
        var menu_ul        = $('.accordion .item__content');
        var menu_li        = $('.accordion .item__header');
        var menu_li_active = $('.accordion .active');

        menu_ul.hide();
        menu_li_active.find(menu_ul).slideToggle();

        menu_li.click(function (e) {
            e.preventDefault();
            menu_li.parent().removeClass('active');
            $(this).parent().addClass('active');
            menu_ul.slideUp();
            if (menu_ul.parent('.active')) {
                $(this).parent().find(menu_ul).slideToggle();
            }
            return false;
        });
</script>
{/literal}
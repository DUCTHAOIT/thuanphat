{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
{/literal}
<div class="service bg-gray js-animation fadein">
	<div class="container">
		<h2 class="title">CÁC GÓI DỊCH VỤ</h2>
		<div class="service__list">
			<div class="item flex">
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
					<div class="percent flex-center"> {if (($arrTSI.giadvdt-$arrTSITangGiam.giadvdt))>0}<i class="fal fa-long-arrow-up"></i>{format_number2 number=($arrTSI.giadvdt-$arrTSITangGiam.giadvdt)/$arrTSITangGiam.giadvdt*100}<sup>%</sup>{else}<font style="color:#FF0000"><i class="fal fa-long-arrow-down"></i></i> {format_number2 number=($arrTSI.giadvdt-$arrTSITangGiam.giadvdt)/$arrTSITangGiam.giadvdt*100}<sup style="color:#FF0000">%</sup></font>{/if}</div>
					<div class="box-btn">
					 {if $username}<a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI.id}" rel="modal:open" class="btn btn_primary flex-center">ĐầU TƯ NGAY</a>{else}<a class="btn btn_primary flex-center" href="javascript:alert('Bạn cần đăng nhập thể thực hiện chức năng này')">ĐầU TƯ NGAY</a>{/if}
					   
						<a href="{$smarty.const._DOMAIN_ROOT_URL}/dich-vu/dau-tu-tang-truong--tstt/" class="btn btn_secondary flex-center">xem thêm</a>
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
			<div class="item flex">
				<div class="col-left">
					<h4>ĐẦU TƯ BỀN VỮNG (TSBV) - Ngày {$arrTSI.date}</h4>
					<div class="statistical">
						<div class="statistical__item">
							<h5>Tài sản ròng</h5>
							<span>{format_number number=$arrTSI2.taisan}</span>
						</div>
						<div class="statistical__item">
							<h5>Tổng số lượng ĐVĐT</h5>
							<span>{format_number number=$arrTSI2.khoiluong}</span>
						</div>
						<div class="statistical__item">
							<h5>Giá 1 ĐVT</h5>
							<span>{format_number number=$arrTSI2.giadvdt}</span>
						</div>
					</div>
					<div class="percent flex-center"> {if (($arrTSI2.giadvdt-$arrTSITangGiam2.giadvdt))>0}<font><i class="fal fa-long-arrow-up"></i></i>{format_number2 number=($arrTSI2.giadvdt-$arrTSITangGiam2.giadvdt)/$arrTSITangGiam2.giadvdt*100} </font><sup>%</sup>{else}<font style="color:#FF0000"><i class="fal fa-long-arrow-down"></i></i>{format_number2 number=($arrTSI2.giadvdt-$arrTSITangGiam2.giadvdt)/$arrTSITangGiam2.giadvdt*100}</font><sup style="color:#FF0000">%</sup>{/if}</div>
					<div class="box-btn">
					 {if $username}<a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI2.id}" rel="modal:open" class="btn btn_primary flex-center">ĐầU TƯ NGAY</a>{else}<a class="btn btn_primary flex-center" href="javascript:alert('Bạn cần đăng nhập thể thực hiện chức năng này')">ĐầU TƯ NGAY</a>{/if}
					   
						<a href="{$smarty.const._DOMAIN_ROOT_URL}/dich-vu/dau-tu-ben-vung--tsbv/" class="btn btn_secondary flex-center">xem thêm</a>
					</div>
				</div>
				<div class="col-right">
					<ul class="tab nav">
						<li><a href="#tab3" data-toggle="tab" class="active">HIỆU QUẢ ĐẦU TƯ</a></li>
						<li><a href="#tab4" data-toggle="tab">SO SÁNH VỚI VNINDEX</a></li>
					</ul>
					<div class="tab-content">
						{hieuquabv}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
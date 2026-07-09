<?php 
include_once("header.php");
include_once("phpmailer/class.smtp.php");
include_once("phpmailer/class.phpmailer.php");
include_once("phpmailer/config.php");
global $db;	
$username=getSession("username");
if(!$username) return;
$sql="SELECT * FROM user WHERE (username='$username') AND (ctrl&1=1)";	
$rs=$db->Execute($sql);
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';


// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;


$options = new Options();
//$options->set('defaultFont', 'Arial');



$string ='<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
  body { font-family: DejaVu Sans, sans-serif; }
</style>
<title>Hợp Đồng</title>
</head>
<body>
        <p align="center"><strong>CỘNG HÒA XÃ HỘI  CHỦ NGHĨA VIỆT NAM</strong><br>
  Độc lập - Tự do-  Hạnh phúc<br>
  -------------------<br>
  <strong>HỢP ĐỒNG HỢP TÁC  ĐẦU TƯ</strong><br>
  Số: …./HTĐT<br>
</p>
<p>  
  <em>-    Căn cứ   Bộ Luật dân sự  nước Cộng hoà xã  hội chủ nghĩa Việt Nam năm 2015;</em><br>
  <em>-    Căn cứ  Luật doanh nghiệp số 68/2014/QH13 ban hành ngày 01/07/ 2015</em><br>
  <em>-    Căn cứ Luật đầu tư số 67/2014/QH13 ban hành  năm ngày 26/11/2014</em><br>
  <em>-    Căn cứ Luật Chứng khoán số 70/2006/QH11  được ban hành ngày 29/06/2006</em><br>
  <em>-   Căn  cứ vào khả năng và nhu cầu của hai bên.</em><br>
  <em>-   Hôm  nay,  ngày 22 tháng 01 năm 2018</em><br>
  <em> Chúng  tôi gồm có:</em><br>
  <strong>Bên A: </strong><br>
  Họ tên: '.$rs->fields("name").' <br>
  Sinh năm: '.$rs->fields("sinhngay").'<br>
  Số CMND/căn cước công dân: '.$rs->fields("cmt").'<br>
  Cấp ngày: '.$rs->fields("ngaycmt").' - Nơi cấp: '.$rs->fields("noicapcmt").'<br>
  Địa chỉ: '.$rs->fields("address").'<br>
  Email: '.$rs->fields("email").'<br>
  Số tài khoản ngân hàng bên A: '.$rs->fields("tknh").'<br>
  Chủ tài khoản: '.$rs->fields("tenchutknh").'<br>
  Ngân hàng: '.$rs->fields("nganhangtknh").' - '.$rs->fields("chinhanhtknh").'<br>
  <strong><em>(Sau đây gọi là Bên A)</em></strong><br>
  <strong>Bên B: </strong><strong> </strong><br>
  Địa chỉ          : Số 25D ngõ 38/24, Đường Xuân La, Phường Xuân La, Quận Tây Hồ, Thành Phố  Hà Nội, Việt Nam.<br>
  Văn phòng     : Số 1, Đường Phạm Huy  Thông, Phường Ngọc Khánh, Quận Ba Đình, Thành Phố Hà Nội, Việt Nam.<br>
  Mã số thuế    : 0107790791<br>
  Đại diện        :  Đỗ Danh Thanh<br>
  <strong><em>(Sau đây gọi là bên B)</em></strong><br>
  <strong><em>Các bên cùng thoả thuận ký Hợp đồng  hợp tác này với các điều khoản và điều kiện sau đây:</em></strong><br>
  <strong>Điều 1. Định nghĩa </strong><br>
  <strong>“Vốn hợp tác đầu tư” </strong>là khoản tiền bên A  chuyển cho bên B để thực hiện hoạt động hợp tác đầu tư trên tài khoản đầu tư.<br>
  <strong>“Tài khoản đầu tư”</strong> là  tài khoản chứng khoán do Bên B là chủ tài  khoản, được sử dụng để thực hiện việc đầu tư theo hợp đồng này.  <br>
  <strong>“Đơn vị đầu tư&quot; </strong>là<strong> </strong>Vốn hợp tác  trên tài khoản đầu tư chia thành nhiều phần bằng nhau. Mệnh giá của Đơn vị đầu  tư tại ngày giao dịch đầu tiên là 10.000 đồng. Mỗi Đơn vị đầu tư đại diện cho  phần lợi nhuận và vốn như nhau của Tài khoản đầu tư.<br>
  <strong>“Ngày định giá” </strong>là ngày xác định Gía trị  tài sản ròng của Tài khoản đầu tư cho mục đích ký hợp đồng hoặc thanh lý hợp  đồng với bên A hoặc làm báo cáo gửi bên A. <br>
  <strong>“Ngày giao dịch”</strong> là ngày bên B nhận được  khoản Vốn góp của bên A.<br>
  <strong>“Ngày đáo hạn”</strong> là ngày cuối cùng của thời hạn  hợp tác, nếu ngày đáo hạn không phải ngày làm việc, thì nó sẽ được tính vào  ngày làm việc kế tiếp.</p>
<p><strong>Điều 2. MỤC TIÊU, THỜI HẠN HỢP TÁC</strong><br>
    <strong>2.1 Mục tiêu</strong><br>
  - Bên A góp Vốn hợp tác  đầu tư với mục đích kiếm lợi nhuận từ việc đầu tư vào thị trường chứng khoán. <br>
  - Bên B toàn quyền sử  dụng Vốn hợp tác đầu tư để tiến hành các hoạt động đầu tư vào thị trường chứng  khoán trên Tài khoản đầu tư theo quy định của pháp luật.<br>
  <strong>-</strong> Bên B được phép sử dụng  các dịch vụ được cung cấp bởi công ty chứng khoán nơi bên B mở tài khoản giao  dịch, bao gồm các hoạt động ứng trước tiền bán, giao dịch ký quỹ ( margin), và  các dịch vụ khác… <br>
  <strong>2.3 Thời hạn hợp tác</strong><br>
  Thời hạn hợp tác là 1 năm.  Bắt đầu từ ngày <strong>…</strong> tháng <strong>…</strong> năm <strong>…</strong> tới ngày <strong>….</strong> tháng <strong>… </strong>năm <strong>….</strong> .Sau khi kết thúc thời hạn hợp tác 1 năm, 2 bên có thể tiếp tục  thỏa thuận kéo dài thêm thời hạn hợp tác.<br>
  Sau khi kết thúc thời hạn hợp tác, Bên A và  Bên B phải thực hiện đầy đủ các quyền và nghĩa vụ của 2 bên trong vòng 5 ngày  làm việc. <br>
  <strong>Điều 3. NỘI DUNG HỢP TÁC ĐẦU TƯ</strong><br>
  <strong>3.1 Tài khoản đầu tư</strong><br>
  Toàn bộ vốn góp của bên A sẽ được chuyển vào  tài khoản đầu tư của bên B được mở tại: Công ty cổ phần chứng khoán Tân Việt<br>
  - Số tài khoản: <br>
  - Chủ tài khoản: <br>
  <strong>3.2 Cách tính số lượng Đơn vị đầu tư</strong></p>
<ul>
  <li>Sau khi chuyển tiền vào Tài khoản đầu tư, Bên  A sẽ nhận được số lượng Đơn vị đầu tư được tính như sau:</li>
</ul>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="100%" valign="top"><div align="center">
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
          <td valign="top"><p align="center">Số      lượng Đơn vị đầu tư</p></td>
          <td width="40" valign="top"><p align="center">=</p></td>
          <td valign="top"><p align="center">Vốn      hợp tác đầu tư</p></td>
          <td width="40" valign="top"><p align="center">:</p></td>
          <td valign="top"><p align="center">Giá trị tài sản ròng của một Đơn vị đầu tư (tại ngày định giá gần nhất trước ngày giao dịch)</p></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>- Số lượng Đơn vị đầu tư được làm tròn đến  hàng đơn vị.<br>
  - <strong>Giá  trị Tài sản ròng của một Đơn vị đầu tư</strong> được xác định bằng Tổng giá trị tài  sản ròng của Tài khoản đầu tư chia cho Tổng số lượng Đơn vị đầu tư hiện có tại  ngày định giá.<br>
  <strong>“Tổng giá trị tài sản ròng của tài khoản đầu  tư”</strong> được tính bằng  Tổng tài sản của tài khoản đầu tư trừ đi tổng nợ phải trả của tài khoản đầu tư  tại ngày định giá.<br>
  <strong>“Tổng tài sản của tài khoản đầu tư</strong>” là tổng giá trị  thị trường của danh mục đầu tư có trong Tài khoản đầu tư và tổng giá trị tiền  tại ngày định giá bao gồm: <br>
  + Tiền mặt <br>
  + Cổ tức bằng tiền  chờ về<br>
  + Tiền bán chứng  khoán chờ nhận về<br>
  + Các khoản tiền  khác phát sinh trên tài khoản đầu tư<br>
  + Danh mục đầu tư  bao gồm các cổ phiếu hiện có, các cổ phiếu đang chờ về trên tài khoản đầu tư. </p>
<p><strong>“T</strong><strong>ổ</strong><strong>ng n</strong><strong>ợ</strong><strong> ph</strong><strong>ả</strong><strong>i tr</strong><strong>ả</strong><strong> c</strong><strong>ủ</strong><strong>a t</strong><strong>à</strong><strong>i kho</strong><strong>ả</strong><strong>n </strong><strong>đầ</strong><strong>u t</strong><strong>ư</strong><strong>”</strong> Là tổng các khoản nợ phát sinh trên tài khoản đầu tư tại ngày định giá bao gồm:<br>
+ Các khoản tiền vay của bên A để mua chứng khoán (margin)<br>
+ Tiền lãi vay  margin<br>
+ Phí lưu ký<br>
+ Phí chuyển khoản chứng khoán<br>
Và các khoản phí,  lãi khác phát sinh trên tài khoản đầu tư <br>
<strong>3.3. Vốn hợp tác đầu tư</strong> </p>
<ul>
  <li>Bên A góp vốn hợp tác đầu tư bằng tiền mặt  giá trị:……………………..</li>
  <li>Bằng chữ: ………………………</li>
  <li>Tại ngày 22 tháng 01 năm 2018 thời điểm hai  bên thống nhất về việc hợp tác đầu tư:</li>
  <li>Gía trị tài sản ròng của một Đơn vị đầu tư là: <strong>………….</strong></li>
  <li>Số lượng Đơn vị đầu tư bên A nhận được tương  ứng với số Vốn hợp tác kinh doanh là: <strong>……………</strong> đơn vị đầu tư (bằng chữ: …………………………….)      </li>
  <li>Trong trường hợp Bên A góp thêm Vốn hợp tác  đầu tư sau hợp đồng này thì hai bên sẽ ký phụ lục hợp đồng bổ sung Vốn hợp tác  đầu tư. </li>
</ul>
<p><strong>Điều 4. PHÂN CHIA LỢI NHUẬN</strong> <br>
    <em>4.1 Xác </em><em>đị</em><em>nh l</em><em>ợ</em><em>i nhu</em><em>ậ</em><em>n h</em><em>ợ</em><em>p tác </em><em>đầ</em><em>u t</em><em>ư</em><br>
  Tại thời điểm chấm dứt  hợp đồng hoặc thời điểm bên A rút vốn đầu tư, tổng giá trị tài sản ròng của khoản Vốn hợp tác đầu tư của bên A được xác định theo công  thức sau:</p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td><br>
      Tổng giá trị tài sản ròng của khoản Vốn hợp tác đầu tư </td>
    <td width="40"><p align="center">=</p></td>
    <td><p align="center">Tổng số lượng Đơn vị đầu tư của bên A </p></td>
    <td width="40"><p align="center">x</p></td>
    <td><p align="center">Giá trị tài sản ròng của một Đơn vị đầu tư tại ngày đáo hạn </p></td>
  </tr>
</table>
<p>Lợi nhuận hợp tác đầu tư được xác định như sau:</p>
<table border="0" cellspacing="0" cellpadding="0"  width="100%">
  <tr>
    <td><br>
      Lợi nhuận hợp tác đầu tư </td>
    <td width="40"><p align="center">=</p></td>
    <td><p align="center">Tổng giá trị tài sản ròng của khoản vốn hợp tác đầu tư của bên A tại ngày đáo hạn </p></td>
    <td width="40"><p align="center">-</p></td>
    <td><p align="center">Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu </p></td>
  </tr>
</table>
<p><em>4.2 Tỷ lệ phân chia lợi nhuận hợp tác đầu tư</em></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td>Tỷ suất lợi nhuận hợp tác đầu tư </td>
    <td width="26"><p align="center">=</p></td>
    <td><p align="center">Lợi nhuận hợp tác đầu tư </p></td>
    <td width="40"><p align="center">:</p></td>
    <td><p align="center">Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu </p></td>
    <td width="40"><p align="center">x</p></td>
    <td width="40"><p align="center">100 </p></td>
  </tr>
</table>
<p>- Trường hợp 1: Tỷ  suất lợi nhuận hợp tác đầu tư &lt; 10% hoặc Tỷ suất lợi nhuận hợp tác đầu tư &lt; 0%:  Bên A nhận về vốn hợp tác đầu tư còn lại được xác định bằng Tổng giá trị tài  sản ròng của khoản vốn hợp tác đầu tư của bên A tại ngày đáo hạn.<br>
  - Trường hợp 2: 10% =&lt; Tỷ suất lợi nhuận hợp  tác đầu tư &lt; 50%: <br>
  + Lợi nhuận bên A nhận được bằng 85% của Lợi nhuận hợp tác đầu tư. <br>
  + Bên B  được nhận 15% của Lợi nhuận hợp tác đầu tư.<br>
  - Trường hợp 3: 50% =&lt; Tỷ suất lợi nhuận  hợp tác đầu tư &lt; 100%:<br>
  + Lợi nhuận bên A nhận được bằng 80% của Lợi nhuận hợp tác đầu tư. <br>
  + Bên B  được nhận 20% của Lợi nhuận hợp tác đầu tư.<br>
  - Trường hợp 4: 100% =&lt; Tỷ suất lợi nhuận  hợp tác đầu tư: <br>
  + Lợi nhuận bên A nhận được bằng 75% của Lợi nhuận hợp tác đầu tư. <br>
  + Bên B  được nhận 25% của Lợi nhuận hợp tác đầu tư.<br>
  <em>4.3 Nghĩa vụ thuế</em><br>
  - Bên A có nghĩa  vụ đóng thuế thu nhập cá nhân 5% cho phần lợi nhuận được chia từ Lợi nhuận hợp  tác đầu tư (theo thông tư 111/2013/TT-BTC ngày 15/08/2013).<br>
  - Bên B sẽ khấu  trừ phần thuế 5% này trước khi trả lợi nhuận đầu tư cho bên A và có nghĩa vụ  đóng thuế cho cơ quan thuế giúp bên A.<br>
  - Phần lợi nhuận  hợp tác đầu tư của bên B sẽ do bên B chủ động đóng thuế thu nhập doanh nghiệp  với cơ quan thuế. <br>
  <strong>Điều 5. Hoàn trả Vốn góp </strong><br>
  5.1 Bên A chỉ được rút vốn vào ngày làm việc  thứ 6 hàng tuần (nếu thứ 6 là ngày nghỉ lễ thì Bên A được rút vào ngày làm việc  thứ 6 tiếp theo) và bên A phải thông báo về Giá trị vốn rút với bên B muộn nhất  là 1 ngày làm việc trước đó. Giá trị 1 đơn vị đầu tư là giá trị tài sản ròng của một Đơn vị đầu tư tại ngày rút vốn. <br>
  5.2 Trường hợp bên A rút vốn khi hết hạn hợp  đồng<br>
  Tổng giá trị tài sản ròng của khoản vốn hợp tác đầu tư của bên A sẽ được tính theo công  thức nêu tại khoản 4.1 Điều 4 Hợp đồng này. </p>
<ul>
  <li>Nếu tổng giá trị tài sản ròng của khoản vốn hợp  tác đầu tư của Bên A cao hơn Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu (Tức là hoạt động đầu tư có lãi),  Bên A được nhận lợi nhuận theo quy định tại điều 4.2 Hợp đồng này cộng thêm  khoản tiền Vốn hợp tác đầu tư ban đầu. </li>
  <li>Nếu tổng giá trị tài sản ròng của khoản vốn hợp  tác đầu tư của Bên A nhỏ hơn hoặc bằng Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu (tức là hoạt động đầu tư không  có lãi hoặc lỗ) bên A được hoàn trả vốn tương ứng với Tổng giá trị tài sản ròng của khoản vốn hợp tác  đầu tư còn lại của Bên A tại ngày đáo hạn. </li>
  <li>Số tiền bên B trả cho bên A sẽ được chuyển  vào tài khoản ngân hàng được bên A cung cấp trong vòng 5 ngày làm việc kể từ  khi tất toán hợp đồng. </li>
</ul>
<p>5.3 Trường hợp bên  A rút vốn trước khi hết hạn hợp đồng<br>
  - Bên A được hoàn  trả vốn góp theo quy định tại Điều 4 sau khi trừ phí rút trước hạn hợp đồng.<br>
  - Phí được rút trước hạn hợp đồng bên B quy định như sau:</p>
<div align="center">
  <table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td width="60%"><br>
        Thời hạn hợp tác đầu tư (Tính từ ngày giao    dịch đến ngày đáo hạn) </td>
      <td width="40%"><p align="center">Phí rút trước hạn (% tính trên tổng giá trị    rút vốn)</p></td>
    </tr>
    <tr>
      <td ><p align="center">Thời hạn &lt; 90 ngày</p></td>
      <td ><p align="center">2% </p></td>
    </tr>
    <tr>
      <td ><p align="center">90 ngày =&lt; Thời hạn &lt; 180 ngày</p></td>
      <td ><p align="center">1% </p></td>
    </tr>
    <tr>
      <td ><p align="center">180 ngày =&lt; Thời hạn</p></td>
      <td ><p align="center">0% </p></td>
    </tr>
  </table>
</div>
<p><strong>Điều 6.   Các nguyên tắc tài chính</strong></p>
<ul>
  <li>Hai bên phải tuân thủ các nguyên tắc tài  chính kế toán theo qui định của pháp luật về kế toán của nước Cộng hoà xã hội  chủ nghĩa Việt Nam.</li>
  <li>Các khoản thu, chi trên tài khoản đầu tư cần  được ghi chép đầy đủ, minh bạch.</li>
</ul>
<p><strong>Điều 7.   Quyền và nghĩa vụ của Bên A</strong><br>
    <strong>7.1 Bên A có quyền: </strong></p>
<ul>
  <li>Yêu cầu Bên B báo cáo tình hình hoạt động đầu tư  theo định kỳ.</li>
  <li>Hưởng lợi nhuận đầu tư theo kết quả hoạt động đầu  tư.</li>
  <li>Được hoàn trả Vốn hợp tác đầu tư theo quy định tại  Điều 5 của Hợp đồng này.</li>
</ul>
<p><strong>7.2 Bên A có nghĩa vụ:</strong></p>
<ul>
  <li>Góp vốn đủ theo cam kết.</li>
  <li>Đảm bảo nguồn vốn góp hợp pháp và thuộc quyền  sở hữu của Bên A.</li>
  <li>Chấp nhận toàn bộ kết quả đầu tư do bên B  thực hiện trên tài khoản đầu tư  trong  thời hạn hợp tác.</li>
  <li>Chịu các khoản phí: phí lưu ký chứng khoán,  Phí chuyển khoản chứng khoán và các khoản phí, lãi  khác phát sinh trên tài khoản đầu tư.</li>
</ul>
<p><strong>Điều 8.   Quyền và nghĩa vụ của bên B</strong><br>
    <strong>8.1 Bên B có quyền </strong></p>
<ul>
  <li>Nhận và sử dụng Vốn hợp tác đầu tư theo đúng  phạm vi và mục tiêu hợp tác;</li>
  <li>Hưởng lợi nhuận theo quy định tại Điều 4 Hợp  đồng này.</li>
</ul>
<p><strong>8.2 Bên B có nghĩa vụ</strong></p>
<ul>
  <li>Báo cáo tình hình sử dụng nguồn vốn góp; báo  cáo danh mục đầu tư;</li>
  <li>Thanh toán Lợi nhuận cho bên B đúng thời hạn  theo thỏa thuận trong hợp đồng này;</li>
  <li>Thực hiện đúng các cam kết trong hợp đồng  này.</li>
</ul>
<p><strong>Điều 9. Cam kết của các hai bên</strong><br>
  Bên A và Bên B chịu trách nhiệm trước pháp  luật về những lời cam đoan sau đây:</p>
<ul>
  <li>Những  thông tin về nhân thân, chủ thể ghi trong hợp đồng này là đúng sự thật;<strong></strong></li>
  <li>Việc  giao kết Hợp đồng này là hoàn toàn tự nguyện, không bị lừa dối, ép buộc.</li>
  <li>Bên A  hiểu và chấp nhận việc tham gia góp vốn hợp tác đầu tư trên Tài khoản quy định  tại khoản 3.1 Điều 3 Hợp đồng này sẽ gồm việc hợp tác đầu tư của bên B và nhiều  bên khác.</li>
  <li>Bên A  đã hiểu và nhận thức rõ về những rủi ro có thể xảy ra trong quá trình hợp tác  đầu tư. </li>
  <li>Bên A  cam kết thực hiện đúng những thỏa thuận về điều kiện sử dụng vốn được nêu trong  Hợp đồng này.</li>
  <li>Bên A  cam kết Vốn góp đã ghi trong hợp đồng này là đúng sự thật, thuộc quyền sở hữu  riêng, hợp pháp của bên A, không chứa đựng yếu tố nào dẫn tới việc bị cơ quan  nhà nước có thẩm quyền xem xét, xử lý theo quy định của pháp luật.</li>
  <li>Bên B  thực hiện việc quản lý và đầu tư vốn hợp tác đầu tư theo đúng quy định tại hợp  đồng này. </li>
</ul>
<p><strong>Điều 10.   Điều khoản chung           </strong></p>
<ul>
  <li>Hợp đồng này được hiểu và chịu sự điều chỉnh  của Pháp luật nước Cộng hoà xã hội chủ nghĩa Việt Nam.</li>
  <li>Mọi sửa đổi, bổ sung hợp đồng này đều phải  được lập phụ lục kèm theo và có chữ ký của hai bên. Các phụ lục là phần không  tách rời của hợp đồng.</li>
  <li>Mọi  tranh chấp phát sinh trong quá trình thực hiện hợp đồng được giải quyết trước  hết qua thương lượng, hoà giải, nếu hoà giải không thành việc tranh chấp sẽ  được giải quyết tại Toà án có thẩm quyền.<strong><u></u></strong></li>
</ul>
<p><strong>Điều 11.   Hiệu lực Hợp đồng</strong><br>
  - Hợp đồng này có hiệu lực từ ngày ký. Khi  kết thúc Hợp đồng, hoặc theo yêu cầu của bên A về việc rút vốn hợp tác đầu tư,  hai bên sẽ làm biên bản thanh lý hợp đồng và phân chia lợi nhuận được quy định  tại Điều 4 của Hợp đồng này. <br>
  - Khi hết thời hạn hợp tác, nếu hai bên không  có yêu cầu thanh lý Hợp đồng thì Hợp đồng này sẽ tiếp tục được gia hạn cho tới  khi có yêu cầu thanh lý hợp đồng của một trong hai bên và khoản 5.2 Điều 5 của  Hợp đồng này không còn hiệu lực. <br>
  - Hợp đồng này gồm 08 trang không thể tách  rời nhau, được lập thành 02 (hai) bản bằng tiếng Việt, mỗi Bên giữ 01 (một) bản  có giá trị pháp lý như nhau và có hiệu lực kể từ ngày ký.</p>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" align="center">
        <strong>Đại diện bên A</strong> </td>
    <td width="50%" valign="top" align="center"><strong>Đại diện bên B</strong></td>
  </tr>
</table>
    </body>
</html>';
$filename = 'file/TSI_'.$rs->fields("id").'.pdf';
// instantiate and use the dompdf class
$dompdf = new Dompdf($options);
$dompdf->loadHtml($string);

// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4');

// Render the HTML as PDF
$dompdf->render();
//$dompdf->stream();
//$dompdf->stream('TSI_'.$rs->fields("id").'.pdf', ['Attachment'=>1]);
file_put_contents($filename, $dompdf->output());
// Output the generated PDF to Browser
//$dompdf->stream();
$fileemail=_DOMAIN_ROOT_PATH."/file/TSI_".$rs->fields("id").".pdf";

$filenameemail= 'TSI_'.$rs->fields("id").'.pdf';
$nTo=$rs->fields("name");
$mTo=$rs->fields("email");
$title="HỢP ĐỒNG HỢP TÁC ĐẦU TƯ";
$content="<li>Hợp đồng đã được gửi vào Email của Quý khách. Quý khách vui lòng đọc các điều khoản dịch vụ trong hợp đồng.</li>

<li>Khi quý khách ĐẶT MUA và ĐỒNG Ý với các điều khoản dịch vụ trong hợp đồng, đồng nghĩa với việc Hợp Đồng điện tử đã được xác lập giữa hai bên.</li>

<li>Hợp đồng điện tử này có giá trị pháp lý tương đương hợp đồng bằng văn bản.</li>
";
$mail = sendMailAttachment($title, $content, $nTo, $mTo,$diachicc='',$fileemail,$filenameemail);

echo "<div style=\"padding-top:100px; padding-bottom:100px; font-weight:bold\">
			<li>Hợp đồng đã được tạo: <a href=\"../file/TSI_".$rs->fields("id").".pdf\" target=\"_blank\"><button>Quý khách bấm vào đây để tải hợp đồng về</button></a></li>
			<li>Hợp đồng đã được gửi vào Email của Quý khách. Quý khách vui lòng đọc các điều khoản dịch vụ trong hợp đồng.</li>
			<li>Khi quý khách ĐẶT MUA và ĐỒNG Ý với các điều khoản dịch vụ trong hợp đồng, đồng nghĩa với việc Hợp Đồng điện tử đã được xác lập giữa hai bên.</li>
			<li>Hợp đồng điện tử này có giá trị pháp lý tương đương hợp đồng bằng văn bản.</li><br>
			</div>";
include_once("footer.php");			
?>
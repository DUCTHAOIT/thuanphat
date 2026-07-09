<?php
    // Include PDFreactor class
    require_once("lib/PDFreactor.class.php");

    use com\realobjects\pdfreactor\webservice\client\PDFreactor as PDFreactor;
    use com\realobjects\pdfreactor\webservice\client\LogLevel as LogLevel;
    use com\realobjects\pdfreactor\webservice\client\ViewerPreferences as ViewerPreferences;

    // The content to render
	global $db;
	
	$username=getSession("username");
	
	$sql="SELECT * FROM user WHERE (username='$username') AND (ctrl&1=1)";	
	$rs=$db->Execute($sql);

    $content = '<p align="center"><strong>0.iCỘNG HÒA XÃ HỘI  CHỦ NGHĨA VIỆT NAM</strong><br>
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
  <em>-   Hôm  nay, ngày   tháng   năm   </em><br>
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
<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="934" valign="top"><div align="center">
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="187" valign="top"><p align="center">Số      lượng Đơn vị đầu tư</p></td>
          <td width="65" valign="top"><p align="center">=</p></td>
          <td width="156" valign="top"><p align="center">Vốn      hợp tác đầu tư</p></td>
          <td width="57" valign="top"><p align="center">:</p></td>
          <td width="469" valign="top"><p align="center">Giá trị tài sản ròng của một Đơn vị đầu tư (tại ngày      định giá gần nhất trước ngày giao dịch)</p></td>
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
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="234"><br>
      Tổng giá trị tài sản ròng của khoản Vốn hợp tác đầu tư </td>
    <td width="57"><p align="center">=</p></td>
    <td width="269"><p align="center">Tổng số lượng Đơn vị đầu tư của bên A </p></td>
    <td width="71"><p align="center">x</p></td>
    <td width="284"><p align="center">Giá trị tài sản ròng của một Đơn vị đầu tư tại ngày đáo hạn </p></td>
  </tr>
</table>
<p>Lợi nhuận hợp tác đầu tư được xác định như sau:</p>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="204"><br>
      Lợi nhuận hợp tác đầu tư </td>
    <td width="57"><p align="center">=</p></td>
    <td width="326"><p align="center">Tổng giá trị tài sản ròng của khoản vốn hợp tác đầu tư của bên A tại ngày đáo hạn </p></td>
    <td width="44"><p align="center">-</p></td>
    <td width="284"><p align="center">Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu </p></td>
  </tr>
</table>
<p><em>4.2 Tỷ lệ phân chia lợi nhuận hợp tác đầu tư</em></p>
<table border="0" cellspacing="0" cellpadding="0" width="886">
  <tr>
    <td width="123"><br>
      Tỷ suất lợi nhuận     hợp    tác đầu tư </td>
    <td width="26"><p align="center">=</p></td>
    <td width="156"><p align="center">Lợi nhuận hợp tác đầu tư </p></td>
    <td width="57"><p align="center">:</p></td>
    <td width="255"><p align="center">Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu </p></td>
    <td width="99"><p align="center">x</p></td>
    <td width="170"><p align="center">100 </p></td>
  </tr>
</table>';
	$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
@font-face {
    font-family: 'NotoSansShavian-Regular';
    font-style: normal;
    font-weight: 400;
    src: url('$cjk_font_path') format('truetype');
}
body {
    font-family: DejaVu Sans, sans-serif;;
}
.cjk {
    font-family: NotoSansShavian-Regular, sans-serif;
}
</style>
</head>
<body>$content</body>
</html>
HTML;

    date_default_timezone_set('CET');

    // Create new PDFreactor instance
    // $pdfReactor = new PDFreactor("http://tsi/1/service/rest");
	// $pdfReactor = new PDFreactor();
    $pdfReactor = new PDFreactor("https://cloud.pdfreactor.com/service/rest");

    $config = array(
        // Specify the input document
        "document"=> $html,
        // Set a base URL for images, style sheets, links
        "baseURL"=> "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],
        // Set an appropriate log level
        "logLevel"=> LogLevel::DEBUG,
        // Set the title of the created PDF
        "title"=> "Demonstration of PDFreactor PHP API",
        // Sets the author of the created PDF
        "author"=> "Myself",
        // Enables links in the PDF document.
        "addLinks"=> true,
        // Enables bookmarks in the PDF document.
        "addBookmarks"=> true,
        // Set some viewer preferences
        "viewerPreferences"=> array(
            ViewerPreferences::FIT_WINDOW,
            ViewerPreferences::PAGE_MODE_USE_THUMBS
        ),
        // Add user style sheets
        "userStyleSheets"=> array(
            array(
                'content'=> "@page {" .
                                "@top-center {".
                                    "content: 'PDFreactor PHP API demonstration';".
                                "}".
                                "@bottom-center {" .
                                    "content: 'Created on ".date("m/d/Y G:i:s A")."';" .
                                "}" .
                            "}"
            ),
            array( 'uri'=> "../../resources/common.css" )
        )
    );

    try {
        // Convert document
        $documentId = $pdfReactor->convertAsync($config);
        $progress = null;

        do {
            sleep(0.5);
            $progress = $pdfReactor->getProgress($documentId);
        } while (!$progress->finished);

        // Streaming is more efficient for larger documents
        header("Content-Type: application/pdf");
        $stream = fopen('php://output', 'w');
        $pdfReactor->getDocumentAsBinary($documentId, $stream);
        fclose($stream);
    } catch (Exception $e) {
        header("Content-Type: text/html");
        echo "<h1>An Error Has Occurred</h1>";
        echo "<h2>".$e->getMessage()."</h2>";
    }
?>

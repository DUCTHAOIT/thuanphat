<?php
    // Include PDFreactor class
    require_once("../lib/PDFreactor.class.php");

    use com\realobjects\pdfreactor\webservice\client\PDFreactor as PDFreactor;
    use com\realobjects\pdfreactor\webservice\client\LogLevel as LogLevel;
    use com\realobjects\pdfreactor\webservice\client\ViewerPreferences as ViewerPreferences;

    // The content to render
    $content = '<div style="padding:20px">
 <p> Để hoàn tất giao dịch Nhà đầu tư chuyển khoản cho ThachsanhInvestment theo thông tin dưới để hoàn tất việc đặt mua.  </p>
 <p> Tổng giá trị thanh toán: xxx.xxx.xxx (tối thiếu 10.000.000 VNĐ)    </p>
 <p> Tên chủ tài khoản:	Công ty cổ phần chứng khoán Tân Việt    </p>
 <p> Tại Ngân hàng:	               File phía dưới   </p>
 <p> Nội dung:                          <i>(Nhà đầu tư copy trong mục “nội dung” hướng dẫn chuyển tiền)</i> </p>
</div>
<div class="row">
 <table border="1" cellspacing="0" cellpadding="0" width="100%" class="table">
  <tr>
    <td width="50%">Ngân hàng TMCP Sài Gòn    - Chi nhánh Hai Bà Trưng, Hà Nội </td>
    <td width="10%">SCB </td>
    <td width="15%">0430100092100002 </td>
    <td width="25%">CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng TMCP Ngoại    Thương Viêt Nam – Hội Sở Chính </td>
    <td >VCB </td>
    <td >0011001954698 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng Thương mại    Cổ phần Công Thương Việt Nam - CN Ba Đình </td>
    <td >VIETINBANK </td>
    <td >125000074637 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng TMCP Đầu tư    và Phát triển Việt Nam - Chi nhánh Ba Đình </td>
    <td >BIDV </td>
    <td >12610000161365 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng TMCP Quân    đội – Chi nhánh Xuân Thủy, Cầu Giấy Hà Nội </td>
    <td >MBB </td>
    <td >0081111368368 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng TMCP Quân    đội – Chi nhánh Hoàn Kiếm, Hà Nội </td>
    <td >MBB </td>
    <td >0571102713009 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Techcom bank – Chi    nhánh Thụy Khuê, Tây Hồ, Hà Nội </td>
    <td >TCB </td>
    <td >19025894473022 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng TMCP Việt    Nam Thịnh Vượng - Hội Sở Chính </td>
    <td >VPB </td>
    <td >182881961 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng Nông nghiệp    và phát triển nông thôn Việt Nam - CN Tràng An </td>
    <td >AGRIBANK </td>
    <td >1305201018374 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
  <tr>
    <td >Ngân hàng Thương mại    Cổ phần Sài Gòn Hà Nội – CN: Trung tâm kinh doanh </td>
    <td >SHB </td>
    <td >1002345665 </td>
    <td >CTCP Chứng khoán Tân    Việt </td>
  </tr>
</table>';

    date_default_timezone_set('CET');

    // Create new PDFreactor instance
    // $pdfReactor = new PDFreactor("http://yourServer:9423/service/rest");
    $pdfReactor = new PDFreactor("https://cloud.pdfreactor.com/service/rest");

    $config = array(
        // Specify the input document
        "document"=> $content,
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
        $result = $pdfReactor->convertAsBinary($config);

        header("Content-Type: application/pdf");
        echo $result;
    } catch (Exception $e) {
        header("Content-Type: text/html");
        echo "<h1>An Error Has Occurred</h1>";
        echo "<h2>".$e->getMessage()."</h2>";
    }
?>

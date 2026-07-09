<?php
// tu dong cap nhat thoi tiet lay tu hoangmobile.com.vn
function rates(){ 
	global $db, $lang, $lable;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>
		   <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/news/b.gif); background-repeat:repeat-x;" >
				<td align="left" valign="top"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/news/l.gif" /></td>
				<td width="100%" nowrap="nowrap" style="color:#FFFFFF" class="title"><?php echo $lable->_("Necessary information");?></td>			   
			  </tr>			  
		</table>
  </td></tr>
  <tr>   
    <td style="padding-bottom:10px; padding-top:0px">
		<?php
			#if ((!defined('NV_SYSTEM')) AND (!defined('NV_ADMIN'))) {
			#Header("Location: ../index.php");
			#exit;
			#}
			$Link = new SimpleXMLElement('http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx',NULL,true);
			$list = array("USD", "EUR", "GBP", "JPY", "AUD");
			echo"<div align=\"center\">"
			  . " <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">"
			  . "  <tr>"
			  . "   <td>"
			  . "   <table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"5\" class=\"table\">"
			  . "    <tr>"
			  . "     <td  class=\"td\" align=\"center\" height=\"22\" width=\"65\">"
			  . "     <b><font face=\"Arial\" style=\"font-size: 8pt\" >Type</font></b></td>"
			  . "     <td  class=\"td\"  align=\"center\" height=\"22\" width=\"90\">"
			  . "     <b><font face=\"Arial\" style=\"font-size: 8pt\" >Buy</font></b></td>"
			  . "     <td  class=\"td\"  align=\"center\" height=\"22\" width=\"90\">"
			  . "     <b><font face=\"Arial\" style=\"font-size: 8pt\" >Sell</font></b></td>"
			  . "    </tr>";
			foreach($Link->Exrate as $Exrate)
			{
			 if (in_array($Exrate['CurrencyCode'], $list)) {
			  $number_buy = (float)$Exrate['Buy'];  #Convert sang float
			  $number_sell = (float)$Exrate['Sell']; #
			  $Buy=number_format($number_buy,2, ',', '.');   #Äá»‹nh dáº¡ng dáº¥u cháº¥m tÃ¡ch hÃ ng nghÃ¬n, dáº¥u pháº©y tÃ¡ch 2 sá»‘ pháº§n thá»±c
			  $Sell = number_format($number_sell,2, ',', '.'); #
			echo"    <tr>"
			  . "     <td  align=\"center\"height=\"22\" width=\"65\" align=\"center\" class=\"content\"><font face=\"Arial\" style=\"font-size: 9pt\" color=\"#000000\">".$Exrate['CurrencyCode']."</font></td>"
			  . "     <td align=\"right\"height=\"22\" Width=\"90\" align=\"center\" class=\"content\"><font face=\"Arial\" style=\"font-size: 9pt\" color=\"#000000\">".$Buy."</font></td>"
			  . "     <td align=\"right\" height=\"22\" width=\"90\" align=\"center\" class=\"content\"><font face=\"Arial\" style=\"font-size: 9pt\" color=\"#000000\">".$Sell."</font></td>"
			  . "    </tr>";
			  }
			}
			echo"   </table>"
			  . "   </td>"
			  . "  </tr>"
			  . " </table>"
			  . "</div>";
			?> 
		<div align="center" style="font-size:11px; padding-top:10px" class="content">Nguồn: Vietcombank</div>		
	</td>   
  </tr>
</table>
<?php	  	
}
?>

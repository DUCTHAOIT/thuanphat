<?php
// tu dong cap nhat thoi tiet lay tu hoangmobile.com.vn
function rates(){ 
	global $db, $lang;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/news/bg.gif); background-repeat:repeat-x; background-position:bottom">
    <td style="border-left:1px solid #629baf">&nbsp;</td>
    <td style="padding-bottom:10px; padding-top:10px">
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
			  . "     <td  class=\"td\" bgcolor=\"#E5E5E5\" align=\"center\" height=\"22\" width=\"65\">"
			  . "     <b><font face=\"Arial\" style=\"font-size: 8pt\" >Loại</font></b></td>"
			  . "     <td  class=\"td\" bgcolor=\"#E5E5E5\" align=\"center\" height=\"22\" width=\"90\">"
			  . "     <b><font face=\"Arial\" style=\"font-size: 8pt\" >Mua vào</font></b></td>"
			  . "     <td  class=\"td\" bgcolor=\"#E5E5E5\" align=\"center\" height=\"22\" width=\"90\">"
			  . "     <b><font face=\"Arial\" style=\"font-size: 8pt\" >Bán ra</font></b></td>"
			  . "    </tr>";
			foreach($Link->Exrate as $Exrate)
			{
			 if (in_array($Exrate['CurrencyCode'], $list)) {
			  $number_buy = (float)$Exrate['Buy'];  #Convert sang float
			  $number_sell = (float)$Exrate['Sell']; #
			  $Buy=number_format($number_buy,2, ',', '.');   #Äá»‹nh dáº¡ng dáº¥u cháº¥m tÃ¡ch hÃ ng nghÃ¬n, dáº¥u pháº©y tÃ¡ch 2 sá»‘ pháº§n thá»±c
			  $Sell = number_format($number_sell,2, ',', '.'); #
			echo"    <tr>"
			  . "     <td  align=\"center\"height=\"22\" width=\"65\" align=\"center\" class=\"td\"><font face=\"Arial\" style=\"font-size: 9pt\" color=\"#FF0000\"><b>".$Exrate['CurrencyCode']."</font></b></td>"
			  . "     <td align=\"right\"height=\"22\" Width=\"90\" align=\"center\" class=\"td\"><font face=\"Arial\" style=\"font-size: 9pt\" color=\"#666666\"><b>".$Buy."</font></b></td>"
			  . "     <td align=\"right\" height=\"22\" width=\"90\" align=\"center\" class=\"td\"><font face=\"Arial\" style=\"font-size: 9pt\" color=\"#666666\"><b>".$Sell."</font></b></td>"
			  . "    </tr>";
			  }
			}
			echo"   </table>"
			  . "   </td>"
			  . "  </tr>"
			  . " </table>"
			  . "</div>";
			?> 
		<div align="center" style="font-size:11px" class="content">Nguồn: Vietcombank</div>		
	</td>
    <td style="border-right:1px solid #629baf">&nbsp;</td>
  </tr>
</table>

<script type="text/javascript" language="JavaScript" src="http://vnexpress.net/Service/Gold_Content.js"></Script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td align="left" valign="top"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/1.gif" /></td>	
	<td width="100%" align="center" nowrap="nowrap" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/2.gif); background-repeat:repeat-x;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/icongold.gif" /></td>
			<td width="100%" class="titleBlock" style="color:#0f8100" align="left" >Giá vàng</td>
		  </tr>
		</table>	</td>
	<td align="left" valign="top"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/3.gif" /></td>
  </tr>
  <tr>  
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/8.gif);; background-repeat:repeat-y"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/8.gif" /></td>	
	<td style="padding:10px;">		
		<table width="100%" style="margin:0;" cellpadding="0" cellspacing="0" class="table">
		<script language="javascript">
		document.write("<tr><td  class=\"td\">Loại</td><td class=\"td\">Mua vào </td><td align=left class=\"td\">Bán ra </td></tr>");
		document.write("<tr><td class=\"td\">SBJ</td><td class=\"td\">"+ vGoldSbjBuy +"</td><td align=left class=\"td\">"+ vGoldSbjSell +"</td></tr>");
		document.write("<tr><td class=\"td\">SJC</td><td class=\"td\">"+ vGoldSjcBuy +"</td><td align=left class=\"td\">"+ vGoldSjcSell +"</td></tr>");
		</script>
		
		<tr>
		<td colspan="3" align="center"><i>( Nguồn : Cty SJC Hà Nội )</i></td>
		</tr>
		</table>	</td>	
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/4.gif);; background-repeat:repeat-y"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/4.gif" /></td>
  </tr>
  <tr>
	<td valign="top" align="left"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/5.gif" /></td>
	 <td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/5.gif);; background-repeat:repeat-x"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/spacer.gif" width="196" height="1"  /></td>
    <td valign="top" align="right"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/5.gif" /></td>
  </tr>
  <tr><td colspan="3"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/spacer.gif" width="1" height="10"  /></td></tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td align="left" valign="top"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/1.gif" /></td>	
	<td width="100%" align="center" nowrap="nowrap" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/2.gif); background-repeat:repeat-x;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/icontigia.gif" /></td>
			<td width="100%" class="titleBlock" style="color:#0f8100" align="left" >Tỷ giá</td>
		  </tr>
		</table>	</td>
	<td align="left" valign="top"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/3.gif" /></td>
  </tr>
  <tr>  
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/8.gif);; background-repeat:repeat-y"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/8.gif" /></td>	
	<td style="padding:10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
		  <script type="text/javascript" src="http://www.vnexpress.net/Service/Forex_Content.js"></script> 
		  <script type="text/javascript" language="JavaScript" src="http://vnexpress.net/Service/Forex_Content.js"></Script><Script language="JavaScript">;
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[0]  +"</td><td align=right class=\"td\">" + vCosts[0] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[1]  +"</td><td align=right class=\"td\">" + vCosts[1] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[2]  +"</td><td align=right class=\"td\">" + vCosts[2] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[3]  +"</td><td align=right class=\"td\">" + vCosts[3] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[4]  +"</td><td align=right class=\"td\">" + vCosts[4] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[5]  +"</td><td align=right class=\"td\">" + vCosts[5] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[6]  +"</td><td align=right class=\"td\">" + vCosts[6] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[7]  +"</td><td align=right class=\"td\">" + vCosts[7] +"</td></tr>");
			document.write("<tr><td align='Left' class=\"td\">" + vForexs[8]  +"</td><td align=right class=\"td\">" + vCosts[8] +"</td></tr>");
			
			</Script>
		</table>
	</td>	
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/4.gif);; background-repeat:repeat-y"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/4.gif" /></td>
  </tr>
  <tr>
	<td valign="top" align="left"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/5.gif" /></td>
	 <td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/5.gif);; background-repeat:repeat-x"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/spacer.gif" width="196" height="1"  /></td>
    <td valign="top" align="right"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/5.gif" /></td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
</table>
<?php	  	
}
?>

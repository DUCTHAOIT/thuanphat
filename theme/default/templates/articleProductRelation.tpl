{literal}
<link type="text/css" rel="stylesheet" href="../../js/jquery.capty/css/jquery.capty.css"/>
<script type="text/javascript" src="../../js/jquery.capty/js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.capty/js/jquery.capty.min.js"></script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">  
 <tr>
  	<td colspan="4"  style="padding-left:2px; padding-right:2px;"><div class="title" style="background-color:#e7e7e7; font-size:16px; color:#2f2f2f; padding:10px; text-transform:uppercase">Món ăn liên quan</div></td>
  </tr>
  {assign var="k" value="0"}
  {assign var="i" value="0"}
  {assign var="j" value="0"}
  <tr>
  {section name=i loop=$arr start=$pageID max=$limit}
  
	{if $k==4}
		{assign var="k" value="0"}
		</tr><tr>
	 {/if}	
		<td valign="top" align="left" {if $k==3} style="padding-right:0px; padding-top:20px" {else} style="padding-right:22px; padding-top:20px" {/if}>	  
			 <div style="border-bottom:1px solid #ebebeb">
             	<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=250&image={$smarty.const._DOMAIN_ROOT_URL}/images/article/{$arr[i].img}" id="animation{$k}" alt="{$arr[i].name}"  border="0"  width="226" height="176px" vspace="0" hspace="0"  /></a>	
             </div>             
	  	</td>
  	{assign var="i" value="$i+1"}
	{assign var="k" value="$k+1"}
  {/section}
 </tr>
</table>
{literal}
<script type="text/javascript">
		$(function() {

			$('#default').capty();

			$('#animation0').capty({
				animation0: 'fade',
				speed:		400
			});
			
			$('#animation1').capty({
				animation1: 'fade',
				speed:		400
			});
			
			$('#animation2').capty({
				animation2: 'fade',
				speed:		400
			});
			
			$('#animation3').capty({
				animation3: 'fade',
				speed:		400
			});

			$('#fixed').capty({
				animation:	'fixed'
			});

			$('#content').capty({
				height:		46,
				opacity:	.6
			});

			$('.fix').capty({
				cWrapper:	'capty-tile',
				prefix:		'<span style="color: #35BB87;">Luigui</span> - ',
				sufix:		'Super Mario Bros.&reg;'
			});

		});
	</script>
{/literal}    
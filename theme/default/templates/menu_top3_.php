<script type="text/javascript" src="<?php echo _DOMAIN_ROOT_URL."/"?>js/menutop/dropdown.js"></script>
<style type="text/css">
a.sample_attach, a.sample_attach:visited, div.sample_attach
{
  display: block; 
  border:  0px solid black;
  padding: 7px 5px;
  text-decoration: none;
  font-family: Arial, Helvetica, sans-serif;
  font-weight:bold; 
  padding-top:12px;
  font-size:13px; 
  color:   #3f3e3c;
  text-transform:uppercase;
 
 
}
a.sample_attach2, a.sample_attach2:visited, div.sample_attach2
{
  display: block;
  top:0;
  margin-top:0px;
  width:   180px;
  border:0px solid #dddddd;
  border-bottom:1px solid #dddddd;
  border-top:0px;
  padding:8px;
  padding-bottom:8px;
  padding-left:5px;
 
  background-color:#fafafa;
  font-family: Arial, Helvetica, sans-serif; 
  font-size:14px; 
  color:   #000000;
  
}
.list_content_over_menu { 
  display: block;
  width:   180px;
  border:0px solid #a9a9ab;  
  padding:5px;
  background-color:#dfdfdf;
  font-family: Arial, Helvetica, sans-serif; 
  font-size:12px; 
  color:   #000000;
  cursor: pointer;
}

A.sample_attach:hover{ color:#ff4882; text-decoration:none; text-decoration: none; font-weight:bold;}
A.sample_attach2:hover{ color:#ff4882; text-decoration:none; text-decoration: underline;}
a.sample_attach, a.sample_attach:visited { border-bottom: none; }
div#sample_attach_menu_child             { border-bottom: 1px solid black; }

form.sample_attach
{
  position: absolute;
  visibility: hidden;

  border:  1px solid black;
  padding: 5px 5px 5px 5px;

  background: #FFFFEE;
}

form.sample_attach b
{
  font-family: Verdana, Sans-Sherif;
  font-weight: 900;
  font-size: 1.1em;
}

input.sample_attach { margin: 1px 0px; width: 170px; }

</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<?php	
	$i=0;
	while(!$rs->EOF){
			$parent=$rs->fields("parent");
			$id=$rs->fields("id");
			$arr[$parent][$id]=$rs->fields;
		$rs->MoveNext();
	}
	?>
	<td width="100%">&nbsp;</td>
    <?php
	foreach($arr[0] as $key=>$value){
	$j==1;	
	if($arr[$key]){
	?>
		 <td width="15%" style="border-left:0px solid #edece7; border-right:0px solid #FF0000; padding-left:10px; padding-right:10px" nowrap="nowrap" >
			<div align="center" id="sample_attach_menu_parent<?php echo $j;?>" style="padding-left:0px; padding-right:0px"><a id="a<?php echo $key;?>" class="sample_attach"  style="text-decoration:none" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a></div>
			<div id="sample_attach_menu_child<?php echo $j;?>"  style="z-index:99999; padding-top:0px;">			
			<?php 
			foreach($arr[$key] as $k=>$v){
			?>
				<a  style="text-decoration:none;" class="sample_attach2"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a>				
			<?php
				
			  }
			?>
			</div>
			<script type="text/javascript">
				at_attach("sample_attach_menu_parent<?php echo $j;?>", "sample_attach_menu_child<?php echo $j;?>", "hover", "y", "pointer");
			</script>
			</td>			
		<?php
	$j=$j+1;
	}else{?>
		 <td width="15%" align="center" class="sample_attach"  style="border-left:0px solid #edece7; border-right:0px solid #ecebe6; padding-left:10px; padding-right:10px" id="center<?php echo $key;?>" nowrap="nowrap" >
			<a class="sample_attach" style="text-decoration:none" id="a<?php echo $key;?>" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a>			
		</td>	
	<?php	
	}		
	$j=$j+1;
	}
	?>	
</tr>
</table>
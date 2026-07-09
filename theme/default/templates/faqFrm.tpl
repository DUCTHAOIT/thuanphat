<table width="260" border="0" cellspacing="0" cellpadding="0"> 
   <tr>
  	<td bgcolor="#EFEDE1" style="border-left:1px solid #E2E2E2; border-right:1px dotted #D7D7D7; border-bottom:1px dotted #D7D7D7; padding-left:10px; padding-right:20px">
	<form action="?m=faq" method="post" enctype="multipart/form-data">
	<input type="hidden" name="op" value="add" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="title">{$Name}</td>
	  </tr>
	  <tr>
		<td><input type="text" class="text" name="name" style="width:100%"  /></td>
	  </tr>
	  <tr>
		<td class="title">Email</td>
	  </tr>
	  <tr>
		<td><input type="text" class="text" name="email" style="width:100%"  /></td>
	  </tr>
	  <tr>
		<td class="title">{$Question}</td>
	  </tr>
	  <tr>
		<td><textarea name="question" class="textarea" style="height:100"></textarea></td>
	  </tr>
	  <tr>
		<td align="right" style="padding-top:5px"><input type="submit" value="{$Submit}" class="button" /></td>
	  </tr>
	</table>
	</form>	</td>   
  </tr>
</table>
	

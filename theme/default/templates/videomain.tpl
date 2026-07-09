{assign var="k" value="0"}
{assign var="j" value="0"}
<div class="container">
 <div class="row">
{foreach item=item key=key from=$arr}
 <div class="col-xs-6 col-sm-6 col-md-4 z-depth-0"  style="padding-bottom:10px; padding-top:10px;">	
 	<iframe width="100%" style="min-height:260px"  src="http://www.youtube.com/embed/{$item.youtube}?modestbranding=1&autoplay=1" frameborder="0" allowfullscreen></iframe>
   
    <p class="title" style="padding:5px;">{$item.name}</p>
 </div>						 			  
{assign var="j" value="$j+1"}
{/foreach}
	</div>
</div>
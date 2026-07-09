{literal}
<script type="text/javascript" src="../../js/stepcarousel.js"></script>
<style type="text/css">
.stepcarousel{
position: relative; /*leave this value alone*/
border: 0px solid orange;
overflow: scroll; /*leave this value alone*/
width: 335px;
height: 280px; /*Height should enough to fit largest content's height*/
}

.stepcarousel .belt{
position: absolute; /*leave this value alone*/
left: 0;
top: 0;
}

.stepcarousel .panel{
float: left; /*leave this value alone*/
overflow: hidden; /*clip content that go outside dimensions of holding panel DIV*/
width: 334px; /*Width of each panel holding each content. If removed, widths should be individually defined on each content DIV then. */
}


#galleryc{
border: 1px solid darkred;
}

#galleryc .panel{
font: bold 2px Arial;
text-align: center;
background-color: green;
color: white;
}

p.samplebuttons{
width: 335px;
text-align: center;
}

p.samplebuttons a{
color: #ffffff;
text-decoration: none;
}
.homeProductCate {
    width: 325px;
    margin-top: 20px;
    float: left;
    position: relative;
}
.homeProductCateImg {
    width: 325px;
    height: 204px;
    border: solid 1px #CCCCCC;
    overflow: hidden;
} 
.homeProductCateTxt {
    font-size: 12px;
    font-weight: bold;
    color: #fff;
    text-transform: uppercase;
    background: #fd6500;
    padding: 5px 10px 5px 5px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    border-bottom-right-radius: 8px;
    -moz-border-bottom-right-radius: 8px;
    -webkit-border-bottom-right-radius: 8px;
}
</style>
{/literal}
<div style="position:relative">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr height="39px">
            <td  nowrap="nowrap" align="left" style="border-bottom:2px solid #CCCCCC;" class="titleBlock">{if $lang=='vn'}DANH MỤC SẢN PHẨM{else}Products List{/if}</td>
             <td  nowrap="nowrap" align="right" style="border-bottom:2px solid #CCCCCC;" valign="bottom">&nbsp;</td>
          </tr>
        </table>

		<table id="maintable" border="0" width="100%" cellspacing="0" cellpadding="0" >
		  <tr>
			<td valign="top" id="contentarea" align="center" >
            <div style="position:absolute">
			{literal}
			<script type="text/javascript">
			stepcarousel.setup({
				galleryid: 'gallerya', //id of carousel DIV
				beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
				panelclass: 'panel', //class of panel DIVs each holding content
				autostep: {enable:true, moveby:1, pause:3000},
				panelbehavior: {speed:300, wraparound:true, persist:true},
				defaultbuttons: {enable: true, moveby: 1, leftnav: ['../../image/l.gif', -20, 10], rightnav: ['../../image/r.gif', 5, 10]},				
				contenttype: ['inline'] //content setting ['inline'] or ['external', 'path_to_external_file']
			})
			</script>
			{/literal}
            </div>
			<div id="gallerya" class="stepcarousel" style="width: 100%">
			<div class="belt">
			{assign var="i" value="0"}
			{foreach key=key item=item from=$arr}
            <div class="panel">
            	<table width="325px" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top">
                        <div class="homeProductCate">
                            <div class="homeProductCateImg">
                               <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/function/{$item.img1}" style="border:2px solid #f4f3ef" border="0" vspace="0"  hspace="0" alt="{$item.name}" width="320px" height="200px"/></a>
                            </div>
                            <div class="homeProductCateTxt">
                                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" class="title" style="color:#FFFFFF" ><h2 style="font-size:14px; text-transform:uppercase; margin:0px">{$item.name}</h2></a>
                            </div>  
                        </div>
                    </td>
                  </tr>
                </table>
			</div>
			{assign var="i" value="$i+1"}
					
			{/foreach}			</div>
			</div>		</td>
		</tr>
		</table>
</div>        
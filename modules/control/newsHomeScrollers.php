<?php
		function newsHomeScrollers() {
			global $db,$smarty,$lable,$themeName,$arr_info_page,$lang;		
			
			$sql="SELECT sys_partner.*, sys_function.htaccess FROM sys_partner_cat,sys_partner,sys_function WHERE (sys_partner_cat.artID= sys_partner.id) AND (sys_partner_cat.catID=sys_function.id) AND (sys_function.ctrl&1=1) AND (sys_function.module='partner') AND (sys_partner.lang='$lang') AND (sys_partner.ctrl&1=1) AND (sys_function.ctrl&1=1) ORDER BY sys_partner.date_create DESC LIMIT 0,10";		
				
			$arr=$db->GetAssoc($sql);			
			$arr=$db->GetAssoc($sql);				
			$smarty->assign('arr',$arr);
			$smarty->assign('fid',$fid);
			$smarty->assign('theme',$themeName);			
			
			$smarty->assign('Detail',$lable->_("Detail"));	
			$smarty->assign('News',$lable->_("HighLights"));
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsHomeScrollers.tpl','newsHomeScrollers_');
			return;
		?>
			<script language="JavaScript1.2">

			//Translucent scroller- By Dynamic Drive
			//For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
			//This credit MUST stay intact for use
			
			var scroller_width='150px'
			var scroller_height='115px'
			var bgcolor='#E0EFD1'
			var pause=3000 //SET PAUSE BETWEEN SLIDE (3000=3 seconds)
			
			var scrollercontent=new Array()
			//Define scroller contents. Extend or contract array as needed
			scrollercontent[0]='Visit our partner site <a href="http://freewarejava.com">Freewarejava.com </a>for free Java applets!'
			scrollercontent[1]='Got JavaScript? <a href="http://www.javascriptkit.com">JavaScript Kit</a> is the most comprehensive JavaScript site online.'
			scrollercontent[2]='Link to Dynamic Drive on your site. Please visit our <a href="http://www.dynamicdrive.com/link.htm">links page</a>.'
			
			
			////NO need to edit beyond here/////////////
			
			var ie4=document.all
			var dom=document.getElementById&&navigator.userAgent.indexOf("Opera")==-1
			
			if (ie4||dom)
			document.write('<div style="position:relative;width:'+scroller_width+';height:'+scroller_height+';overflow:hidden"><div id="canvas0" style="position:absolute;background-color:'+bgcolor+';width:'+scroller_width+';height:'+scroller_height+';top:'+scroller_height+';filter:alpha(opacity=20);-moz-opacity:0.2;"></div><div id="canvas1" style="position:absolute;background-color:'+bgcolor+';width:'+scroller_width+';height:'+scroller_height+';top:'+scroller_height+';filter:alpha(opacity=20);-moz-opacity:0.2;"></div></div>')
			else if (document.layers){
			document.write('<ilayer id=tickernsmain visibility=hide width='+scroller_width+' height='+scroller_height+' bgColor='+bgcolor+'><layer id=tickernssub width='+scroller_width+' height='+scroller_height+' left=0 top=0>'+scrollercontent[0]+'</layer></ilayer>')
			}
			
			var curpos=scroller_height*(1)
			var degree=10
			var curcanvas="canvas0"
			var curindex=0
			var nextindex=1
			
			function moveslide(){
			if (curpos>0){
			curpos=Math.max(curpos-degree,0)
			tempobj.style.top=curpos+"px"
			}
			else{
			clearInterval(dropslide)
			if (crossobj.filters)
			crossobj.filters.alpha.opacity=100
			else if (crossobj.style.MozOpacity)
			crossobj.style.MozOpacity=1
			nextcanvas=(curcanvas=="canvas0")? "canvas0" : "canvas1"
			tempobj=ie4? eval("document.all."+nextcanvas) : document.getElementById(nextcanvas)
			tempobj.innerHTML=scrollercontent[curindex]
			nextindex=(nextindex<scrollercontent.length-1)? nextindex+1 : 0
			setTimeout("rotateslide()",pause)
			}
			}
			
			function rotateslide(){
			if (ie4||dom){
			resetit(curcanvas)
			crossobj=tempobj=ie4? eval("document.all."+curcanvas) : document.getElementById(curcanvas)
			crossobj.style.zIndex++
			if (crossobj.filters)
			document.all.canvas0.filters.alpha.opacity=document.all.canvas1.filters.alpha.opacity=20
			else if (crossobj.style.MozOpacity)
			document.getElementById("canvas0").style.MozOpacity=document.getElementById("canvas1").style.MozOpacity=0.2
			var temp='setInterval("moveslide()",50)'
			dropslide=eval(temp)
			curcanvas=(curcanvas=="canvas0")? "canvas1" : "canvas0"
			}
			else if (document.layers){
			crossobj.document.write(scrollercontent[curindex])
			crossobj.document.close()
			}
			curindex=(curindex<scrollercontent.length-1)? curindex+1 : 0
			}
			
			function resetit(what){
			curpos=parseInt(scroller_height)*(1)
			var crossobj=ie4? eval("document.all."+what) : document.getElementById(what)
			crossobj.style.top=curpos+"px"
			}
			
			function startit(){
			crossobj=ie4? eval("document.all."+curcanvas) : dom? document.getElementById(curcanvas) : document.tickernsmain.document.tickernssub
			if (ie4||dom){
			crossobj.innerHTML=scrollercontent[curindex]
			rotateslide()
			}
			else{
			document.tickernsmain.visibility='show'
			curindex++
			setInterval("rotateslide()",pause)
			}
			}
			
			if (ie4||dom||document.layers)
			window.onload=startit
			
			</script>	
		<?php			

			//	
		}		
?>

	</div>
   {rightBlock}
	</div> 
</div> 
</div> 
<div  class="container-fluid" style="height:20px"></div>
<!--Copyright-->
<div  class="container-fluid" style="background-color:#006633; padding-top:10px;">
	<div class="container">
    	<div class="col-xs-12 col-sm-12 col-md-8" style="color:#FFFFFF; padding-top:10px; line-height:24px">{$address}</div>
        <div class="col-xs-12 col-sm-12 col-md-4" align="right">   
<iframe src="//www.facebook.com/plugins/likebox.php?href={$facebook}&amp;width=350&amp;height=200&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:350px; height:200px;" allowTransparency="true"></iframe>
		</div>    
	</div>
</div>    
<div class="container-fluid" style="background-color:#272727; padding:10px">
	<div class="container" >
    <div style="color:#FFFFFF">© 2017 Thach sanh investment. All rights reserved.</div>
    <div align="right">
    </div>
</div>
{literal}
    <!-- JQuery -->
    <script type="text/javascript" src="../../skins/frontend/js/lib.min.js"></script>
    <script type="text/javascript" src="../../skins/frontend/js/modernizr.custom.js"></script>
    <script type="text/javascript" src="../../skins/frontend/js/jquery.dlmenu.js"></script>
{/literal}
</body>
</html>
{literal}
<!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="738491699609430"
  logged_in_greeting="Xin chào! Bạn cần hỗ trợ gì?"
  logged_out_greeting="Xin chào! Bạn cần hỗ trợ gì?">
      </div>
<!-- Histats.com  START  (aync)-->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,3837998,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?3837998&101" alt="" border="0"></a></noscript>
<!-- Histats.com  END  -->
{/literal}
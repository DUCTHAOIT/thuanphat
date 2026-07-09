<?php 
	function slide(){
		global $db,$smarty,$lang;
		$sql="SELECT * FROM slide ORDER BY sort DESC";		
		$arr=$db->getAssoc($sql);	
		
		if(!$arr){ return;}
		?>
         <!-- Caption Style -->
     <style> 
        .captionOrange, .captionBlack
        {
            color: #fff;
            font-size: 20px;
            line-height: 30px;
            text-align: center;
            border-radius: 4px;
        }
        .captionOrange
        {
            background: #EB5100;
            background-color: rgba(235, 81, 0, 0.6);
        }
        .captionBlack
        {
        	font-size:16px;
            background: #000;
            background-color: rgba(0, 0, 0, 0.4);
        }
        a.captionOrange, A.captionOrange:active, A.captionOrange:visited
        {
        	color: #ffffff;
        	text-decoration: none;
        }
        a.captionOrange:hover
        {
            color: #eb5100;
            text-decoration: underline;
            background-color: #eeeeee;
            background-color: rgba(238, 238, 238, 0.7);
        }
        .bricon
        {
            background: url(../img/browser-icons.png);
        }
		.booknow
        {
            background: url(../../theme_images/header/booknow.png); background-repeat:no-repeat; background-position:center top;
			
        }
		.booknow:hover
        {
            background: url(../../theme_images/header/bookon.png); background-repeat:no-repeat; background-position:center top;
			
        }
    </style>
    <!-- use jssor.slider.min.js instead for release -->
    <!-- jssor.slider.min.js = (jssor.js + jssor.slider.js) -->
    <script type="text/javascript" src="../../js/a/js/jssor.js"></script>
    <script type="text/javascript" src="../../js/a/js/jssor.slider.js"></script>
    <script>
        jssor_slider2_starter = function (containerId) {
            //Reference http://www.jssor.com/development/slider-with-slideshow-no-jquery.html
            //Reference http://www.jssor.com/development/tool-slideshow-transition-viewer.html

            var _SlideshowTransitions = [
            //Swing Outside in Stairs
            {$Duration: 1200, x: 0.2, y: -0.1, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Top: $JssorEasing$.$EaseInWave, $Clip: $JssorEasing$.$EaseOutQuad }, $Outside: true, $Round: { $Left: 1.3, $Top: 2.5} }

            //Dodge Dance Outside out Stairs
            , { $Duration: 1500, x: 0.3, y: -0.3, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: { $Left: [0.1, 0.9], $Top: [0.1, 0.9] }, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: { $Left: $JssorEasing$.$EaseInJump, $Top: $JssorEasing$.$EaseInJump, $Clip: $JssorEasing$.$EaseOutQuad }, $Outside: true, $Round: { $Left: 0.8, $Top: 2.5} }

            //Dodge Pet Outside in Stairs
            , { $Duration: 1500, x: 0.2, y: -0.1, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Top: $JssorEasing$.$EaseInWave, $Clip: $JssorEasing$.$EaseOutQuad }, $Outside: true, $Round: { $Left: 0.8, $Top: 2.5} }

            //Dodge Dance Outside in Random
            , { $Duration: 1500, x: 0.3, y: -0.3, $Delay: 80, $Cols: 8, $Rows: 4, $Clip: 15, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInJump, $Top: $JssorEasing$.$EaseInJump, $Clip: $JssorEasing$.$EaseOutQuad }, $Outside: true, $Round: { $Left: 0.8, $Top: 2.5} }

            //Flutter out Wind
            , { $Duration: 1800, x: 1, y: 0.2, $Delay: 30, $Cols: 10, $Rows: 5, $Clip: 15, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $SlideOut: true, $Reverse: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 2050, $Easing: { $Left: $JssorEasing$.$EaseInOutSine, $Top: $JssorEasing$.$EaseOutWave, $Clip: $JssorEasing$.$EaseInOutQuad }, $Outside: true, $Round: { $Top: 1.3} }

            //Collapse Stairs
            , { $Duration: 1200, $Delay: 30, $Cols: 8, $Rows: 4, $Clip: 15, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 2049, $Easing: $JssorEasing$.$EaseOutQuad }

            //Collapse Random
            , { $Duration: 1000, $Delay: 80, $Cols: 8, $Rows: 4, $Clip: 15, $SlideOut: true, $Easing: $JssorEasing$.$EaseOutQuad }

            //Vertical Chess Stripe
            , { $Duration: 1000, y: -1, $Cols: 12, $Formation: $JssorSlideshowFormations$.$FormationStraight, $ChessMode: { $Column: 12} }

            //Extrude out Stripe
            , { $Duration: 1000, x: -0.2, $Delay: 40, $Cols: 12, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: { $Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad }, $Opacity: 2, $Outside: true, $Round: { $Top: 0.5} }

            //Dominoes Stripe
            , { $Duration: 2000, y: -1, $Delay: 60, $Cols: 15, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: $JssorEasing$.$EaseOutJump, $Round: { $Top: 1.5} }
            ];

            var options = {
                 $AutoPlay: true, 
				$DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider2 = new $JssorSlider$(containerId, options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
           
		   // function ScaleSlider() {
            //    var parentWidth = jssor_slider2.$Elmt.parentNode.clientWidth;
            //    if (parentWidth)
           //         jssor_slider2.$ScaleWidth(Math.min(parentWidth, 1366));
           //     else
            //        $Jssor$.$Delay(ScaleSlider, 30);
           // }

           // ScaleSlider();
           // $Jssor$.$AddEvent(window, "load", ScaleSlider);

           // $Jssor$.$AddEvent(window, "resize", $Jssor$.$WindowResizeFilter(window, ScaleSlider));
           // $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            //responsive code end
			
			/*#region responsive code begin*/

                var MAX_WIDTH = 3000;

                function ScaleSlider() {
                    var containerElement = jssor_slider2.$Elmt.parentNode;
                    var parentWidth = containerElement.clientWidth;

                    if (parentWidth) {

                        var expectedWidth = Math.min(MAX_WIDTH || parentWidth, parentWidth);

                        jssor_slider2.$ScaleWidth(expectedWidth);
                    }
                    else {
                        window.setTimeout(ScaleSlider, 30);
                    }
                }

                ScaleSlider();

                $Jssor$.$AddEvent(window, "load", ScaleSlider);
                $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                /*#endregion responsive code end*/

        }
    </script>
   	  <div id="slider2_container" style="position: relative; width:1366px;
        height: 450px;" align="center">
       
        <!-- Slides Container -->
        <div u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1366px;height:450px;overflow:hidden;">
            <?php
				foreach($arr as $k=>$v){
				?>
					<div><a href="<?php echo $v["link"];?>" target="_blank"  u=image><img src="<?php echo _DOMAIN_ROOT_URL;?>/img/logo/<?php echo $v["logo"];?>" border="0"  /></a></div>
				<?php
				}
				?> 
        </div>        
        <!-- Bullet Navigator Skin Begin -->
        <!-- jssor slider bullet navigator skin 01 -->
        <style>
            /*
            .jssorb01 div           (normal)
            .jssorb01 div:hover     (normal mouseover)
            .jssorb01 .av           (active)
            .jssorb01 .av:hover     (active mouseover)
            .jssorb01 .dn           (mousedown)
            */
            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av
            {
                filter: alpha(opacity=70);
                opacity: .7;
                overflow:hidden;
                cursor: pointer;
                border: #000 1px solid;
            }
            .jssorb01 div { background-color: gray; }
            .jssorb01 div:hover, .jssorb01 .av:hover { background-color: #d3d3d3; }
            .jssorb01 .av { background-color: #fff; }
            .jssorb01 .dn, .jssorb01 .dn:hover { background-color: #555555; }
        </style>
        <!-- bullet navigator container -->        
        <!-- Bullet Navigator Skin End -->
        
        <!-- Arrow Navigator Skin Begin -->
        <style>
            /* jssor slider arrow navigator skin 03 css */
            /*
            .jssora03l              (normal)
            .jssora03r              (normal)
            .jssora03l:hover        (normal mouseover)
            .jssora03r:hover        (normal mouseover)
            .jssora03ldn            (mousedown)
            .jssora03rdn            (mousedown)
            */
            		
			    .jssora05l, .jssora05r, .jssora05ldn, .jssora05rdn
            {
            	position: absolute;
            	cursor: pointer;
            	display: block;
                background: url(../../js/a/img/a17.png) no-repeat;
                overflow:hidden;
            }
            .jssora05l { background-position: -10px -40px; }
            .jssora05r { background-position: -70px -40px; }
            .jssora05l:hover { background-position: -130px -40px; }
            .jssora05r:hover { background-position: -190px -40px; }
            .jssora05ldn { background-position: -250px -40px; }
            .jssora05rdn { background-position: -310px -40px; }
        </style>
         <!-- Arrow Left -->
         <span u="arrowleft" class="jssora05l" style="width: 40px; height: 40px; top: 180px; left: 100px;">
        </span>
        <!-- Arrow Right -->
       <span u="arrowright" class="jssora05r" style="width: 40px; height: 40px; top: 180px; right: 100px">
        </span>
        <!-- Arrow Navigator Skin End -->
        
        <!-- Trigger -->
        <script>
            jssor_slider2_starter('slider2_container');
        </script>
    </div>
    
<?php        		
	}
	//
?>
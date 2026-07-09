{literal}
<script type="text/javascript" src="../../js/jssor/jssor.slider.min.js"></script>
<script type="text/javascript" src="../../js/jssor/slide.js"></script>
{/literal}

<!-- Jssor Slider Begin -->
<div id="slider1_container" class="slider1 home-slide-partner-container" style="padding-bottom:80px">

    <!-- Loading Screen -->
    <div u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                        background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
        </div>
        <div style="position: absolute; display: block; background: url(http://jquery/jssor.slider.freeTrial/img/loading.gif) no-repeat center center;
                        top: 0px; left: 0px;width: 100%;height:100%;">
        </div>
    </div>

    <!-- Slides Container -->
    <div u="slides" class="home-slide-partner-pieces" style="position: absolute; left: 15px; right:15px; width: 100%; height: 100px; overflow: hidden;">
      {foreach item=item key=key from=$arr}
             <div style="height:auto; width:150px">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}{$item.alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/advertise/{$item.img}" style="width:110px; height:60px"  u="image"  border="0" vspace="0"  hspace="0" /></a>
            </div>
       {/foreach}	       
      
    </div>

    <!-- Navigator Skin Begin -->
    {literal}
    <style>
        .slider1-N div, .slider1-N div:hover, .slider1-N div.av
        {
            background: url(http://jquery/jssor.slider.freeTrialimg/sprite-03.png) no-repeat;
            overflow:hidden;
            cursor: pointer;
        }
        .slider1-N div { background-position: 0px -240px; }
        .slider1-N div:hover, .slider1-N div.av:hover, .slider1-N div.hv { background-position: -30px -240px; }
        .slider1-N div.av { background-position: -60px -240px; }
        .slider1-N div.dn { background-position: -90px -240px; }
   
        .slider1 .al, .slider1 .ar, .slider1 .aldn, .slider1 .ardn, .slider1 .alhv, .slider1 .arhv
        {
            position: absolute;
            cursor: pointer;
            display: block;
            background: url(../../js/jssor/Sprite-03.png) no-repeat;
            overflow:hidden;
        }
        .slider1 .al { background-position: 0px -60px; }
        .slider1 .ar { background-position: -60px -60px; }
        .slider1 .al:hover, .slider1 .alhv { background-position: 0px 0px; }
        .slider1 .ar:hover, .slider1 .arhv { background-position: -60px 0px; }
        .slider1 .aldn { background-position: -120px -60px; }
        .slider1 .ardn { background-position: -180px -60px; }
    </style>
	<script>
        jssor_slider1_starter('slider1_container');
    </script>
    {/literal}
</div>
<!-- Jssor Slider End -->
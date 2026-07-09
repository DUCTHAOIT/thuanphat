{literal}
<link rel="stylesheet" type="text/css" id="theme" href="../../js/slick-1.8.1/global.css"/>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="../../js/slick-1.8.1/jquery.min.js"></script>
{/literal}
<div class="slider variable-width">
        	{if $arrColor}
            {assign var="i" value="1"}
            {foreach item=item key=key from=$arrColor}
            <div>
            <div class="image"><img class="image-size" src='{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=800&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}'></div>
            </div>
            
            {assign var="i" value="$i+1"}
             {/foreach}
            {/if}
            
</div>
{literal}
<link rel="stylesheet" type="text/css" href="../../js/slick-1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="../../js/slick-1.8.1/slick/slick-theme.css"/>

<script type="text/javascript" src="../../js/slick-1.8.1/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../../js/slick-1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function() {
        //Slide
        $('.variable-width').slick({
            dots: false,
            lazyLoad: 'ondemand',
            // prevArrow: false,
            // nextArrow: false,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            centerMode: false,
            variableWidth: true,
            autoplay: true,
            autoplaySpeed: 2000,
        });
        $(".variable").slick({
            dots: false,
            prevArrow: false,
            nextArrow: false,
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            autoplaySpeed: 2000,
            autoplay: true,
            variableWidth: true
        });

        /* Linked date and time picker */
        // start date date and time picker
      
    });

  
</script>   
{/literal}
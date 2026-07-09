{literal}
<style type="text/css">
    #NewsTicker
    {
        border: solid 1px #cccccc;
        background: #eaf5e0;
        width: 265px;
        height: 264px;
  
    }

    #NewsVertical
    {
        width: 265px;
        height: 262px;
        display: block;
        overflow: hidden;
        position: relative;
       margin-top:5px;
       
    }
    #controller
    {
        padding: 4px;
        font-size: 11px;
        color: #666;
    }
    #play_scroll_cont
    {
        display: none;
          
    }
    /* --------------- */
    /* Ticker Vertical */
    #TickerVertical
    {
        
        height: 264px;
        display: block;
        list-style: none;
        margin: 0;
        padding: 0;
   
    }
    #TickerVertical li
    {
        display: block;
     	width: 265px;
        color: #333333;
        text-align: left;
        font-size: 11px;
        margin: 0;
        padding-left:8px;
        
        float: none;
        
    }
    #TickerVertical li .NewsTitle
    {
        display: block;
        color: #000000;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 6px;  
    }
    #TickerVertical li .NewsTitle a:link, #TickerVertical li .NewsTitle a:Visited
    {
        display: block;
        color: #000000;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 6px;
        text-decoration: none;
    }
    #TickerVertical li .NewsTitle a:hover
    {
        text-decoration: underline;
    }
    #TickerVertical li .NewsImg
    {
        float: left;
        margin-right: 10px;
    }
 
</style>
<script type="text/javascript" language="javascript" src="http://pvc.vn/Themes/Default/Client/js/mootools.svn.js"></script>
<script type="text/javascript" language="javascript" src="http://pvc.vn/Themes/Default/Client/js/newsticker.js"></script>
{/literal}
<div id="NewsVertical">
 <ul id="TickerVertical">   
	{foreach item=item key=key from=$arr}			
	  <li>
		 <a href="{$item.website}" target="_blank"><img   src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}"  border="0" /></a>
	  </li>
	 {/foreach}
  </ul>
</div>
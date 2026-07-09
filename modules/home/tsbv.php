<?php
function inveslist(){
	?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    
    <link rel="stylesheet"  href="../../js/tabview2/tab/css/webwidget_tab.css" type="text/css" />
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
    <script type='text/javascript' src='../../js/tabview2/tab/js/webwidget_tab.js'></script>
    <script type="text/javascript">// <![CDATA[
                $(function() {
                    $(".webwidget_tab").webwidget_tab({
                        window_padding: '10',
                        head_text_color: '#666',
                        head_current_text_color: '#f1592a'
                    });
                });
    // ]]></script>
    
    <script language="javascript">
    function dropCategory(obj){
        if(document.getElementById(obj).style.display == ""){		
            document.getElementById(obj).style.display = "none";
            document.frmTemp.objdrop.value = "none";	
        }
        else{
            document.getElementById(obj).style.display = "";
            document.frmTemp.objdrop.value = obj.id;
        }
    }
    
    </script>

    
      <style>
      	.collapse-icon {
			font-size: 20px;
			width: 25px;
			float: right;
			font-weight: normal;
		}
		basedcustom.css:188
		.collapse-icon {
			font-size: 20px;
			width: 50px;
			float: right;
			font-weight: normal;
		}
		.inveslist{
			font-weight:bold;padding-bottom:5px; padding-top:5px; color:#212121; font-size: 16px;		
		}
		.inveslist:hover{ color:#006633; text-decoration: none; cursor:pointer; font-size: 16px;	}
      </style> 
       <div class="titleBlock" style="background-image:url(<?php echo _DOMAIN_ROOT_URL;?>/theme_images/bgtitle.png); background-repeat:repeat-x; background-position:bottom; padding-bottom:20px; height:45px" >DANH MỤC ĐẦU TƯ</div>  
   			
                        
                        
            <div style="padding-top:10px;">             	
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                  <tr>
                    <td style="padding:5px; " width="100%">
                    	
						<span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(11)">
Danh mục đầu tư</span>
                    </td>  
                    <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(11)">Chi tiết</span> 	
					</button>
                    </td>      
                	<td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                  </tr>
                </table>
             </div>
           	 
             <div id="11" style="display:none; padding-top:10px; padding-bottom:10px">
                <div class="slidemb">
                <div class="webwidget_tab" id="webwidget_tab">
                    <div class="tabContainer">
                        <ul class="tabHead">
                           <li class="currentBtn"><a href="javascript:;">ĐT tăng trưởng - TSTT</a></li>
                            <li ><a href="javascript:;">Đầu tư bền vững - TSBV</a></li>
                            
                        </ul>
                    </div>
                    <div class="tabBody">
                        <ul>
                            <li class="tabCot" style="display: list-item;">
                           
                            <?php 
                                $content=funcontent(653); 
                                echo $content;	
                             ?>
                            </li>
                            <li class="tabCot">
                            <?php 
                                $content=funcontent(655); 
                                echo $content;	
                             ?>
                            </li>
                    </ul>
                    </div>
               </div>
             </div>   
             </div>
             <div style="padding-top:10px;">             	
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                  <tr>
                    <td style="padding:5px; " width="100%">
                    	
						<span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(12)">
Báo cáo NAV</span>
                    </td>  
                    <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(12)">Chi tiết</span> 	
					</button>
                    </td>      
                	<td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                  </tr>
                </table>
             </div>
           
             <div id="12" style="display:none; padding-top:10px; padding-bottom:10px">
                <div class="slidemb">
                <div class="webwidget_tab" id="webwidget_tab">
                    <div class="tabContainer">
                        <ul class="tabHead">
                            <li class="currentBtn"><a href="javascript:;">ĐT tăng trưởng - TSTT</a></li>
                            <li ><a href="javascript:;">Đầu tư bền vững - TSBV</a></li>
                            
                        </ul>
                    </div>
                    <div class="tabBody">
                        <ul>
                            <li class="tabCot" style="display: list-item;">
                           
                            <?php 
                                $content=funcontent(652); 
                                echo $content;	
                             ?>
                            </li>
                            <li class="tabCot">
                            <?php 
                                $content=funcontent(656); 
                                echo $content;	
                             ?>
                            </li>
                    </ul>
                    </div>
               </div>
             </div>  
         </div>     
<?php		
}
?>
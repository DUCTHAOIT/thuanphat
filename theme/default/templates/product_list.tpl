{assign var="k" value="0"}
{assign var="i" value="0"}
{assign var="j" value="0"}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
<link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"
      rel="stylesheet" type="text/css" />
<div class="row"> 
{section name=i loop=$arr start=$pageID max=$limit}
{if $k==1}
    {assign var="k" value="0"}

 {/if}

    <div class="col-xs-12 col-sm-4 col-md-4" style="padding-bottom:40px;">
     	<div class="item-recruit-khoahoc ">
            <div class="avarta">
               {if $arr[i].img}
                	 <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="aff">
                    <img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=1000&image=images/product/{$arr[i].img}" class="img-fluid w-100" alt="{$arr[i].name}" title="{$arr[i].name}">
                </a>
               {/if} 
            </div>
            <div class="info">
                <h3 style="margin-top:10px; margin-bottom:5px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title aff"  title="{$arr[i].name}" >{$arr[i].name}</a></h3>
                {*<p class="content" style="text-align:justify; font-size:0.9rem;">{strstrimtemp str=$arr[i].summary}</p>*}
                <p class="font-weight-bold">
                    {if $arr[i].price}
                        Giá: <strong class="h5 font-weight-bold mb-0" style="color:#FF6600">{format_number number=$arr[i].price}</strong> <del>{format_number number=$arr[i].price_old}</del>

                     {else}
                            Liên hệ
                     {/if}
         
         </p>

            </div>
            <div>
            	<div class="col-xs-6 col-sm-6 col-md-6" style="padding-bottom:10px; padding-top:10px; border-top:0.5px solid #CCCCCC; padding-left:0px; font-size:0.9rem; line-height:24px">
                    <button class="btn_viewmore3 btn-block" data-id="{$arr[i].id}" tabindex="-1">Thêm vào giỏ hàng</button>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6" style="padding-bottom:10px; padding-top:10px; border-top:0.5px solid #CCCCCC; padding-right:0px; float: right; text-align: right">
                	<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="aff"><button class="btn_viewmore2" tabindex="-1">Chi tiết<i class="fas fa-arrow-right ml-2"></i></button></a>
                   

                </div>
            </div>
        </div>
              
     </div> 

{assign var="i" value="$i+1"}
{assign var="k" value="$k+1"}
{/section}
</div>    

<div style="text-align:center; padding:20px;">{$sPage}</div>

<div id="dialog" style="display: none">
    Sản phẩm đã được thêm vào giỏ hàng
</div>
{literal}

    <script>
        $(document).ready(function(){
            $('.btn-block').click(function(e){
                e.preventDefault(); // Ngăn form hoặc thẻ a gây reload

                var id = $(this).data('id');
                console.log("Đã click, product_id =", id); // Kiểm tra id có lấy được không

                $.ajax({
                    url: '../../?m=basket&op=add_basket',
                    type: 'post',
                    data: { product_id: id },
                    success: function(response){
                        console.log("Phản hồi từ server:", response);

                        // Hiển thị thông tin trả về
                        $('#div_view_basket').html(response);

                        // Hiển thị hộp thoại
                        $("#dialog").dialog({
                            modal: true,
                            title: "Thông báo",
                            width: 350,
                            height: 150,
                            open: function (event, ui) {
                                setTimeout(function () {
                                    $("#dialog").dialog("close");
                                }, 2000);
                            }
                        });
                    },
                    error: function(err){
                        console.error("Lỗi:", err);
                        alert("Đã xảy ra lỗi khi thêm giỏ hàng.");
                    }
                });
            });
        });
    </script>


{/literal} 
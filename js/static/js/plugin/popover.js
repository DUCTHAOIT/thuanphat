/**
 * Created with JetBrains PhpStorm.
 * User: truonghm
 * Date: 4/1/13
 * Time: 10:30 AM
 * To change this template use File | Settings | File Templates.
 */
var popover = {
    notification:{
        create:function(){
            $("#icon-notification").popover({
                title: "What's this",
                content: "...",
                classes: "wider",
                content: function() {
                    $(this).css( "height", "300px" );
                }
            });
        },
        show:function(){
            $("#icon-message").popover('hide');
            $("#icon-notification").popover(
                'ajax',
                "/get-header-notification/"
            ).popover('title', "Thông báo").popover('show');
        }
    },
    message:{
        create:function(){
            $("#icon-message").popover({
                title: "What's this",
                content: "...",
                classes: "wider",
                content: function() {
                    //$(this).attr( 'id', 'header-content-message' );
                    //$(this).addClass('nano');
                    $(this).css( "height", "300px" );
                }
            });
        },
        show:function(){
            $("#icon-notification").popover('hide');
            $("#icon-message").popover(
                'ajax',
                "/get-message/"
            ).popover('title', "Tin nhắn").popover('show');
        }
    }
}
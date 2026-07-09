/**
 * Created with JetBrains PhpStorm.
 * User: Truonghm
 * Date: 4/29/13
 * Time: 9:59 AM
 * To change this template use File | Settings | File Templates.
 */
var adminUser = {
    windowAddButtons:[{
        text:'{lang:Save}',
        handler:function(){
            alert('ok');
        }
    },{
        text:'{lang:Cancel}',
        handler:function(){
            $('#window-add-user').window('close');
        }
    }],
    windowAddBlock:function(){
        $('#window-add-user').window('open');
    }
}
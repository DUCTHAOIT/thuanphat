/**
 * Created with JetBrains PhpStorm.
 * User: truonghm
 * Date: 3/28/13
 * Time: 11:46 AM
 * To change this template use File | Settings | File Templates.
 */

var province = {
    dialog:{
        show: function(code){
            $('<div/>', {id: 'dialog',class: 'nyroModalBg'}).appendTo('body');
            $('<div/>', {id: 'dialog-province', class: 'dialog-province'}).appendTo('body');
            $('<div/>', {id: 'dialog-province-item',class: 'item'}).appendTo('#dialog-province');
            $.ajax({
                type: "POST",
                url: "/get-all-province/",
                dataType: 'json'
            }).done(function(result) {
                var obj = result;
                var select = $('<select />');
                $('<option />', {value: '', text: 'Chọn tỉnh/Thành phố'}).appendTo(select);
                $.each(obj, function(i, item) {
                    $('<option />', {value: item.rewrite_url, text: item.name}).appendTo(select);
                })
                select.appendTo('#dialog-province-item');
                select.selectbox({
                    onChange: function (val, inst) {
                        if(val.length > 0)
                            window.location.href = val;
                    }
                });
            });
        }

    }

}
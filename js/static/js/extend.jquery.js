$.extend({
        getUrlVars:function () {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
//      vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar:function (name) {
            return $.getUrlVars()[name];
        },
        getCmsThumb:function(imgPath){
            if(!imgPath) return '';
            var secondPath = imgPath.substr(CMS_ASSETS_PATH.length -1);
            return CMS_ASSETS_THUMB_PATH+secondPath ;
        },

        /**
         *
         * @param checkAllClass
         * @param checkChildClass
         * usage:   $.setupCheckGroup("checkAll","cb-element");
         * where checkAll is class name of parent checkbox, cb-element is class name of children checkbox
         */

        setupCheckGroup:function(checkAllClass,checkChildClass){
            $('.'+checkAllClass).change(function(){
                if($( this ).is( ':checked' ))
                    $( '.'+checkChildClass ).attr(  'checked' , true );
                else
                    $( '.'+checkChildClass ).removeAttr(  'checked' );
            })
            $( '.' + checkChildClass).change(function(){
                if(!$( this ).is( ':checked' ))
                    $( '.'+checkAllClass ).removeAttr(  'checked' );
                else{
                    isAll=true;
                    $( '.' + checkChildClass).each(function(){
                        if(!$( this ).is( ':checked' )) isAll = false;
                    })
                    if(isAll) $( '.' + checkAllClass).attr(  'checked' , true );
                }

            })
        },


        randomString:function() {
            var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
            var string_length = 8;
            var randomstring = '';
            for (var i=0; i<string_length; i++) {
                var rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum,rnum+1);
            }
            return randomstring;
        },
        getNullString:function(str) {
            if(str) return str;
            return '';
        },
        getArrLength: function(arr){
            var key,len=0;
            for(key in arr){
                len += Number( arr.hasOwnProperty(key) );
            }
            return len;
        },

//check vietnam mobile format
        isPhone:function(p){
            re = /^0\d{9,12}$/;
            if(!p) return true;
            if(p.match(re)){

                return true;
            }else{

                return false;
            }

        },


        isValidDate:function(Day,Mn,Yr){
            DateVal = Mn + "/" + Day + "/" + Yr;
            dt = new Date(DateVal);

            if(dt.getDate()!=Day){

                return false;
            }
            else if(dt.getMonth()!=Mn-1){

                return false;
            }
            else if(dt.getFullYear()!=Yr){

                return false;
            }

            return true;
        },

        formatCurrency:function(num){
            var p = num.toFixed(0).split(".");
            return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
                return  num + (i && !(i % 3) ? "," : "") + acc;
            }, "") ;

        },

        vietnameseToASCII:function(str) {
            str= str.toLowerCase();
            str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
            str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
            str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
            str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
            str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
            str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
            str= str.replace(/đ/g,"d");
            str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
            /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
            str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
            str= str.replace(/^\-+|\-+$/g,"");
//cắt bỏ ký tự - ở đầu và cuối chuỗi
            return str;
        },

        putCursorAtEnd:function(elem){
            elem.focus()


            // If this function exists...
            if (elem.setSelectionRange)
            {
                // ... then use it
                // (Doesn't work in IE)

                // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
                var len = elem.val().length * 2;
                elem.setSelectionRange(len, len);
                alert(elem.val())
            }
            else
            {
                // ... otherwise replace the contents with itself
                // (Doesn't work in Google Chrome)
                elem.val(elem.val());

            }

            // Scroll to the bottom, in case we're in a tall textarea
            // (Necessary for Firefox and Google Chrome)
            elem.scrollTop = 999999;
        },
//    dateString = "2010-08-09 01:02:03";
        parseMysqlDate:function(dateString){
            if(!dateString || dateString.length == 0)
            return null;
             reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
             dateArray = reggie.exec(dateString);
             dateObject = new Date(
                (+dateArray[1]),
                (+dateArray[2])-1, // Careful, month starts at 0!
                (+dateArray[3]),
                (+dateArray[4]),
                (+dateArray[5]),
                (+dateArray[6])
            );
            return dateObject;
        }
    }
);


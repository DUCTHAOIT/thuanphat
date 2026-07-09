/*
$(function () {
    $("#mdb-lightbox-ui").load("skins/frontend/includes/lightbox-ui.html");
});
*/

new WOW().init();

$('.carousel').carousel({
  interval: 5000
});

$('#carousel-slider').hammer().on('swipeleft', function () {
    $(this).carousel('next');
});
$('#carousel-slider').hammer().on('swiperight', function () {
    $(this).carousel('prev');
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$('.mdb-select').material_select();

var pickerOption = {
    min: true,
}
$('#date-picker-start').pickadate(pickerOption);
$('#date-picker-end').pickadate(pickerOption);

Waves.attach('.btn, .btn-floating', ['waves-light']);
Waves.attach('.waves-light', ['waves-light']);
Waves.attach('.navbar a', ['waves-light']);
Waves.init();

$(".button-collapse").sideNav();

$('#dl-menu-mobile').dlmenu({
	animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' },
	useActiveItemAsBackLabel: true
});

$('.dl-menu > li > a > span').click(function(){
    var href = $(this).parent('a').attr('href');
    window.location.href='<?php echo Url::PageHome(); ?>/' + href;
});

$('li.li-current').parents('li').addClass('li-current');

$('.icon-search-mobile').click(function(){
    $('.search-mobile').slideToggle('fast');
});

$('.dl-trigger').click(function(){
    $('.search-mobile').slideUp('fast');
});

$(window).scroll(function(){
    if($(window).scrollTop() > 500){
        $('#back-to-top').fadeIn();
    }else{
        $('#back-to-top').fadeOut();
    }
});
$('#back-to-top').click(function() {
    $('html, body').animate({scrollTop:0},1000);
});

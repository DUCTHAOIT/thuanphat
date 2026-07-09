/*!
 * 
 * 
 * 
 * @author Thuclfc
 * @version 
 * Copyright 2021. MIT licensed.
 */$(document).ready(function () {
  $('.navbar-toggler').click(function () {
    $('header nav').toggleClass('active');
    $('.modal-menu').addClass('is-open');
  });
  $('.navbar-collapse .close,.modal-menu').click(function () {
    $('.navbar').removeClass('active');
    $('.modal-menu').removeClass('is-open');
  }); // active navbar of page current

  var urlcurrent = window.location.href;
  $(".navbar-nav li a[href$='" + urlcurrent + "']").addClass('active');
  $(window).on("load", function (e) {
    $(".navbar-nav .sub-menu").parent("li").append("<span class='show-menu'></span>");
    $('.loading').hide();
  });
  $('.navbar-nav > li').click(function () {
    $('.navbar-nav > li').removeClass('active');
    $(this).addClass('active');
  }); // effect navbar

  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
      $('header').addClass('scroll');
    } else {
      $('header').removeClass('scroll');
    }
  });
  $('.backtop').on('click', function () {
    $('html,body').animate({
      scrollTop: 0
    }, 1000);
  });

  $.fn.isInViewport = function () {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight() - 100;
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height() - 100;
    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  $(window).on('resize scroll load', function () {
    $('.fadeup').each(function () {
      if ($(this).isInViewport()) {
        $(this).addClass('fadeInUp').css({
          'opacity': '1',
          'visibility': 'visible'
        });
      }
    });
    $('.fadein').each(function () {
      if ($(this).isInViewport()) {
        $(this).addClass('fadeIn').css({
          'opacity': '1',
          'visibility': 'visible'
        });
      }
    });
    $('.zoomin').each(function () {
      if ($(this).isInViewport()) {
        $(this).addClass('zoomIn').css({
          'opacity': '1',
          'visibility': 'visible'
        });
      }
    });
  });
});
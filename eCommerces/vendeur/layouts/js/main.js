/*global window, console*/
//manuelle slider
(function autoSlider(){
  $('.testimonail .active').each(function (){
    if(!$(this).is(':last-child')){
      $(this).delay(3000).fadeOut(1000, function(){
        $(this).removeClass('active').next().addClass('active').fadeIn();
        autoSlider();
      });
    }else{
      $(this).delay(3000).fadeOut(1000, function(){
        $(this).removeClass('active');
        $('.testimonail .test').eq(0).addClass('active').fadeIn(1000);
        autoSlider();
      });
    }
  });
}());





$(function () {
  'use strict';
  //======================================================
  $('[placeholder]').focus(function () {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
  }).blur(function () {
    $(this).attr('placeholder', $(this).attr('data-text'));
  });

  //confirm dialog
  $('.btn-addComment').click(function(){
    $('.confirmDialog').fadeIn(function(){
      $(this).click(function(){
        $(this).fadeOut();
      });
    });
  });
$('input[name=user]').keyup(function() {
    $('.profile .edit-profile .info-body .show span.user').text($(this).val());
});
$('input[name=Fname]').keyup(function() {
    $('.profile .edit-profile .info-body .show span.Fname').text($(this).val());
});
$('input[name=email]').keyup(function() {
    $('.profile .edit-profile .info-body .show span.email').text($(this).val());
});
/*active class for link info heading
$('.info-heading .link li').click(function() {
  $(this).addClass('active').siblings('li').removeClass('active');
});*/
























  //======================================================
  $('.show-pass').hover(function () {
    $('i.show-pass').removeClass('fa-eye-slash').addClass('fa-eye');
    $('.password').attr('type', 'text');
  }, function (){
    $('i.show-pass').removeClass("fa-eye").addClass("fa-eye-slash");
    $('.password').attr('type', 'password');
  });
  //======================================================
  $('.confirm').click(function () {
    return confirm("Are You Sure ?");
  });
  //======================================================
  /*$('.saber').click(function (){
    $.toast('Here you can put the text of the toast');
  });*/

  /*$('.categories .ordering a').click(function (){
    $(this).addClass('active').siblings('span').removeClass('active');
  });*/
  //======================================================
  $('.categories .view span').click(function (){
    $(this).addClass('active').siblings('span').removeClass('active');
  });
  //======================================================
  $('.categories .category').click(function () {
    $(this).children('.full-content').slideToggle();
  });
  //======================================================
  $('.categories .view .classic').click(function () {
    $('.categories .full-content').slideUp();
  });
  //======================================================
  $('.categories .view .full').click(function () {
    $('.categories .full-content').slideDown();
  });
  //======================================================
  $('.latest .lt-info').click(function (){
    $(this).toggleClass('fa-plus').toggleClass('fa-minus').parent('.panel-heading').next('.panel-body').slideToggle();
  });
});

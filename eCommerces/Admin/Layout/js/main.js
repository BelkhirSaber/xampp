/*global window*/
$(function () {
  'use strict';
  //======================================================
  $('[placeholder]').focus(function () {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
  }).blur(function () {
    $(this).attr('placeholder', $(this).attr('data-text'));
  });
  //======================================================
  $('input, textarea').each(function () {
    if($(this).attr('required') === 'required'){
      $(this).after('<span class="asterisk">*</span>');
    }
  });
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

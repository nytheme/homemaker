$(document).ready(function(){
  $('.modal').modal();
});

$(document).ready(function(){
  $('select').formSelect();
});

//カレンダー切り替え
$('.schedule_select').click(function(){
  //選択時アイコン色付け・解除
  $('.schedule_select').addClass('selected')
  $('.money_select').removeClass('selected')
  //カレンダーの表示・非表示
  $('.money_calendar').addClass('display_none')
  $('.schedule_calendar').removeClass('display_none')
  //ボタンの表示・非表示
  $('.write_btn').removeClass('display_none')
});

$('.money_select').click(function(){
  $('.money_select').addClass('selected')
  $('.schedule_select').removeClass('selected')
  $('.schedule_calendar').addClass('display_none')
  $('.money_calendar').removeClass('display_none')
  $('.write_btn').addClass('display_none')
});

//slideToggle
$(document).on('click', '.write_btn', function() {
  var $toggle = $(this).closest('.slide_parent').find('.slide_content');
  
  if($toggle.hasClass('open')) { 
    $toggle.removeClass('open');
    $toggle.slideUp('fast');
    
  } else {
    $toggle.addClass('open'); 
    $toggle.slideDown();
  }
});
$(document).on('click', '.slide_close', function() {
  var $toggle = $(this).closest('.slide_parent').find('.slide_content');
  
  if($toggle.hasClass('open')) { 
    $toggle.removeClass('open');
    $toggle.slideUp('fast');
    
  } else {
    $toggle.addClass('open'); 
    $toggle.slideDown();
  }
});
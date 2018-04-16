jQuery(document).ready(function($) {


// ==================      Add a button "+ Create New Tab" that require info from  to the <ul>    =================================
	$('.contextual-help-tabs').append('<a href="#" class="create_new_tab">+ Create New Tab</a>');
// ==================      Add a button "+ Create New Tab" that require info from  to the <ul>    =================================


// ==================      Modal window control    =================================
    $('.create_new_tab').on("click", function (e) {
       e.preventDefault();
        $('#window-modal-wrap').fadeIn();
        $('.window-modal-bg').fadeIn();
    });
    $('.edit_current_tab').on("click", function (e) {
        e.preventDefault();
        $('#window-edit-modal-wrap').fadeIn();
        $('.window-edit-modal-bg').fadeIn();
    });
    $('.close-window-modal').on("click", function () {
           $('#window-modal-wrap').fadeOut();
           $('#window-edit-modal-wrap').fadeOut();
           $('.window-modal-bg').fadeOut();
            $('.window-edit-modal-bg').fadeOut();
    });
    $('.cansel-tab').on("click", function (e) {
        e.preventDefault();
        $('#window-modal-wrap').fadeOut();
        $('#window-edit-modal-wrap').fadeOut();
        $('.window-modal-bg').fadeOut();
        $('.window-edit-modal-bg').fadeOut();
    });
// ==================      Modal window control    =================================


// ==================      Control of tubs - in modal window      =================================
  $('ul.tabs__caption').on('click', 'li:not(.active)', function() {
        $(this)
      .addClass('active').siblings().removeClass('active')
      .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
  });

  $('.tab-content').hide();
  $('.tab-content:first').show();
  $('.tabs li:first').addClass('active');

   $('.tabs li').click(function(event){
	   	$('.tabs li').removeClass('active');
	   	$(this).addClass('active');
	   	$('.tab-content').hide();
	   	var selectTab = $(this).find('a').attr('href');
	   	$(selectTab).fadeIn();
   });
// ==================      Control of tubs - in modal window      =================================

});
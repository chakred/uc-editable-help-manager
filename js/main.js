jQuery(document).ready(function($) {


// ==================      Add a button "+ Create New Tub" that require info from  to the <ul>    =================================
	// console.log("it works");
	$('.contextual-help-tabs').append('<a href="/?TB_inline&inlineId=add-new-tab&width=600&height=550" class="thickbox">+ Create New Tub</a>');
	// $(".contextual-help-tabs-wrap").text('');
// ==================      Add a button "+ Create New Tub"  to the <ul>    =================================




// ==================      Control of tubs - modal window      =================================
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
// ==================      Control of tubs - modal window      =================================



});
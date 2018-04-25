jQuery(document).ready(function($) {

    if($(".contextual-help-tabs ul li").length >= 1){
        $(".to-publish").css("display", "block");
        $(".to-unpublish").css("display", "block");
    };


// =======      Add a button "+ Create New Tab" that require info from  to the <ul>    =======
	$('.contextual-help-tabs').append('<span class="button button-primary create_new_tab">+ Create New Tab</span>');
// =======      Add a button "+ Create New Tab" that require info from  to the <ul>    =======


// =======      Modal window control    =======
    var text_sidebar = "";

    $('.create_new_tab').on("click", function (e) {
       e.preventDefault();
        $(".show-tab-name").text("New tab");
        $('#window-modal-wrap').fadeIn();
        $('.window-modal-bg').fadeIn();
    });
    $('.edit_current_tab').on("click", function () {
        $('#window-edit-modal-wrap').fadeIn();
        $('.window-edit-modal-bg').fadeIn();
        $('.hm-tabs-wrap ul .tab1-1').trigger("click");

    });
    $('.close-window-modal').on("click", function () {
        $('#window-modal-wrap').fadeOut();
        $('#window-edit-modal-wrap').fadeOut();
        $('.window-modal-bg').fadeOut();
        $('.window-edit-modal-bg').fadeOut();
        text_sidebar = ""
    });
    $('.cansel-tab').on("click", function (e) {
        e.preventDefault();
        $('#window-modal-wrap').fadeOut();
        $('#window-edit-modal-wrap').fadeOut();
        $('.window-modal-bg').fadeOut();
        $('.window-edit-modal-bg').fadeOut();
        text_sidebar = ""
    });


    $('.contextual-help-sidebar').append($('<span class="edit_sidebar button">Edit sidebar</span>'));
    $('.contextual-help-sidebar .edit_sidebar').on("click", function (){
        $('#window-modal-wrap').fadeIn();
        $('.window-modal-bg').fadeIn();
        $('.hm-tabs-wrap ul li').eq(1).trigger("click");
        $(".show-tab-name").text("Create a new tab");



       $(".contextual-help-sidebar p").each(function () {
           text_sidebar += $(this).html()+"<br>";
       });

        tinymce.get('create_sidebar').setContent(text_sidebar);
    });
// =======      Modal window control    =======


// =======      Control of tubs - in modal window      =======
//   $('ul.tabs__caption').on('click', 'li:not(.active)', function() {
//         $(this)
//       .addClass('active').siblings().removeClass('active')
//       .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
//   });

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
// =======      Control of tubs - in modal window      =======

});
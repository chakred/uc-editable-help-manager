jQuery(document).ready(function($) {
    $("#contextual-help-back").append($('<div id="tab-panel-hidden_tab"><span></span><p>NO TABS CREATED <br><span>Create a new help menu tab to publish content.</span></p></div>'));
    if($(".contextual-help-tabs ul li").length >= 2){
        $("#tab-panel-hidden_tab").css("display", "none");
        $("#contextual-help-back").append($('<br><div class="tab-help-buttons"><a href ="#" class="button button-primary edit_current_tab">Edit</a></div>'));
        $("#contextual-help-back").append($('<br><div class="tab-help-buttons delete"><a href ="#" class="button delete_current_tab">Delete</a></div>'));

        $(".to-publish").css("display", "block");
        $(".to-unpublish").css("display", "block");
    };






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
        $('.hm-tabs-wrap ul li').eq(1).trigger("click");
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
    $('.edit_sidebar').on("click", function (e){
        e.preventDefault();
        if($(".contextual-help-tabs ul li").length == 1){
            alert("Please create at least one tab, only then you will be able to add a sidebar")
        }else {
            $('#window-modal-wrap').fadeIn();
            $('.window-modal-bg').fadeIn();
            $('.hm-tabs-wrap ul li').eq(1).trigger("click");
        };
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
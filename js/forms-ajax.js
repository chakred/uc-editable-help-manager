jQuery(document).ready(function($) {

    var tabs_content;
    var sidebar_content = $(".contextual-help-sidebar>:not('.edit_sidebar')").html();
    var unique_id = 100;

// =======  Control form to add a new tab  =======
    $("#form-for-tab").submit(function(e){
        e.preventDefault();
        unique_id++;
        var tabs_title = $("#tabs_title").val();
        tabs_content = tinyMCE.activeEditor.getContent();
       // console.log(tabs_content);

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    title_tab: tabs_title,
                    content_tab: tabs_content,
                    screen_id: pagenow,
                    action: 'add_tabs_to_db'
                },
                beforeSend: function(data) {
                    $("#form-for-tab").find('input[type="submit"]').attr('disabled', 'disabled');
                    console.log(data);
                },
                success: function(data){
                    console.log(data);
                },
                complete: function(data) {
                    $("#form-for-tab").find('input[type="submit"]').prop('disabled', false);
                    $(".show-tab-name").text(tabs_title)
                    $(".contextual-help-tabs ul").append($('<li><a href="#tab-panel-'+unique_id+'">'+tabs_title+'</a></li>'));
                    $(".contextual-help-tabs-wrap").append($('<div id="tab-panel-'+unique_id+'" class="help-tab-content">'+tabs_content+'</div>'));
                    $("#contextual-help-back").append($('<br><div class="tab-help-buttons"><a href ="#" class="button button-primary " onClick="alert(\'In order to edit the tab, please reload the page!\')">Edit</a></div>'));
                    success_sent("The tab has been successfully added!!!");
                    $(".to-unpublish").css("display", "none");
                    $(".to-publish").css("display", "none");
                    // show_red_notification();
                    $("#tab-panel-hidden_tab").css("display", "none");
                    setTimeout(function () {
                        $('.close-window-modal').trigger("click");
                    },1000);
                    location.reload();

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
            return false;
    });
// =======  Control form to add a new tab  =======


// =======  Control form to edit an existed tab  =======
    var parse_id;

    $(".contextual-help-tabs  ul li").click(function (event) {
        var target = $( event.target );
        if(target.className = "active"){
            var find_id = $(this).attr("id");
            parse_id = parseInt( find_id.replace(/\D+/g,""));

            var tab_title_value = $("#tab-link-"+parse_id).find("a").text();
            var tab_content_value = $("#tab-panel-"+parse_id+"> :not('.tab-help-buttons')");
            // console.log(tab_content_value);
            tinymce.get('edit_created_sidebar').setContent(sidebar_content);

            $("#tabs_title_edit").val(tab_title_value.trim());
            $(".show-tab-name").text(tab_title_value.trim());
            tinymce.get('edit_created_tabs').setContent($(tab_content_value).text());

        };
        // console.log(parse_id);
    });

    $("#form-for-tab-exist").submit(function(e){
        e.preventDefault();

        var tabs_title = $("#tabs_title_edit").val();

        tabs_content = tinyMCE.activeEditor.getContent();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                title_tab: tabs_title,
                content_tab: tabs_content,
                current_tab_id: parse_id,
                action: 'edit_tabs_in_db'
            },
            beforeSend: function(data) {
                $("#form-for-tab").find('input[type="submit"]').attr('disabled', 'disabled');
                console.log(data);
            },
            success: function(data){
                console.log(data);
            },
            complete: function(data) {
                $("#form-for-tab").find('input[type="submit"]').prop('disabled', false);
                $(".show-tab-name").text(tabs_title);
                success_sent("Chosen tab was successfully edited!!!");
                $('.close-window-modal').trigger("click");
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
        return false;
    });

// =======  Control form to edit an existed tab  =======


// =======  Control form to delete an existed tab  =======
    $(".delete_current_tab").on("click", function(e){
        e.preventDefault();
        if(confirm("Are you sure that you want to remove current tab?")){
            $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                current_tab_id: parse_id,
                action: 'remove_tabs_in_db'
            },
            beforeSend: function(data) {
                console.log(data);
            },
            success: function(data){
                console.log(data);
            },
            complete: function(data) {
                success_sent("Chosen tab was successfully removed!!!");
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
        }else{
            return false;
            };
        return false;
    });
// =======  Control form to delete an existed tab  =======


// =======  Control form to add a new sidebar  =======
    $("#form-for-sidebar").submit(function(e){
        e.preventDefault();

        sidebar_content = tinymce.get('create_sidebar').getContent();
        // tinymce.get('create_sidebar').setContent(sidebar_content);
        // console.log(tabs_content);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                content_sidebar: sidebar_content,
                screen_id: pagenow,
                action: 'add_sidebar_to_db'
            },
            beforeSend: function(data) {
                $("#form-for-sidebar").find('input[type="submit"]').attr('disabled', 'disabled');
                console.log(data);
            },
            success: function(data){
                console.log(data);
            },
            complete: function(data) {
                $("#form-for-sidebar").find('input[type="submit"]').prop('disabled', false);
                success_sent("Sidebar successfully added!!!");
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
        return false;
    });

// =======  Control form to add a new sidebar  =======


// =======  Control option to publish/unpublish group of tabs  =======
    $(".to-publish a").on("click", function (e){
        var confirmation = confirm("Please confirm if you want to publish this menu");
        if(confirmation){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                screen_id:pagenow,
                action: 'tabs_to_publish'
            },
            beforeSend: function(data) {
                console.log(data);
            },
            success: function(data){
                console.log(data);
                success_sent("The tabs menu has status - publish");
            },
            complete: function(data) {
                $(".to-publish").css("display", "none");
                // show_green_notification();
                location.reload();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                success_sent("The tabs menu DOESN'T have  status - publish");
            },
        });
        return false;
        };
    });

    $(".to-unpublish a").on("click", function (e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    screen_id: pagenow,
                    action: 'tabs_to_unpublish'
                },
                beforeSend: function (data) {
                    console.log(data);
                },
                success: function (data) {
                    console.log(data);
                    success_sent("The tabs menu has status - trash");
                },
                complete: function (data) {
                    $(".to-unpublish").css("display", "none");
                    // show_red_notification();
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    success_sent("The tabs menu DOESN'T have  status - trash");
                },
            });
            return false;
    });
// =======  Control option to publish/unpublish group of tabs  =======

    function success_sent(message){
        return console.log(message);
    };
    // function show_green_notification() {
    //     return $('<p class="to-unpublish"><svg width="33.00000000000006" height="15" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><path d="M 207.375,425.00c-10.875,0.00-21.175-5.075-27.775-13.825L 90.25,293.225c-11.625-15.35-8.60-37.20, 6.75-48.825 c 15.375-11.65, 37.20-8.60, 48.825,6.75l 58.775,77.60l 147.80-237.275c 10.175-16.325, 31.675-21.325, 48.025-11.15 c 16.325,10.15, 21.325,31.675, 11.125,48.00L 236.975,408.575c-6.075,9.775-16.55,15.90-28.025,16.40C 208.425,425.00, 207.90,425.00, 207.375,425.00z" ></path></svg>The help menu has been published. To unpublish, <a href="#"> Click here</a></p>').insertAfter(".window-edit-modal-bg");

    // };
    // function show_red_notification() {
    //     return $('<p class="to-publish"><svg version="1.1" ' + 'id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n\t width="33px" height="19px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">\n<g>\n\t<g id="Attention">\n\t\t<g>\n\t\t\t<path d="M605.217,501.568l-255-442C341.394,44.302,324.887,34,306,34c-18.887,0-35.394,10.302-44.217,25.568l-255,442\n\t\t\t\tC2.482,509.048,0,517.735,0,527c0,28.152,22.848,51,51,51h510c28.152,0,51-22.848,51-51\n\t\t\t\tC612,517.735,609.535,509.048,605.217,501.568z M50.966,527.051L305.949,85H306l0.034,0.051L561,527L50.966,527.051z M306,408\n\t\t\t\tc-18.768,0-34,15.232-34,34c0,18.785,15.215,34,34,34s34-15.232,34-34S324.785,408,306,408z M272,255\n\t\t\t\tc0,1.938,0.17,3.859,0.476,5.712l16.745,99.145C290.598,367.897,297.585,374,306,374s15.402-6.103,16.762-14.144l16.745-99.145\n\t\t\t\tC339.83,258.859,340,256.938,340,255c0-18.768-15.215-34-34-34C287.232,221,272,236.232,272,255z"/>\n\t\t</g>\n\t</g>\n</g>\n</svg>The help menu has not been published. To publish, <a href=\'#\' onClick="alert(\'In order to change status, please reload the page!\')"> Click here</a></p>').insertAfter(".window-edit-modal-bg");
    // };

});
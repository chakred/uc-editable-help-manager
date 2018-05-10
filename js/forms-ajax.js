jQuery(document).ready(function($) {

    var tabs_content;
    var sidebar_content = '';

// =======  Control form to add a new tab  =======
    $("#form-for-tab").submit(function(e){
        e.preventDefault();

        var tabs_title = $("#tabs_title").val();
        tabs_content = tinyMCE.activeEditor.getContent();

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
                    success_sent("The tab has been successfully added!!!");
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

    $('.tab-help-buttons').click(function(event){
        var target = $( event.target );
        if(target.className = "tab-help-buttons"){
            var find_id = $(this).parent().attr("id");
            parse_id = parseInt( find_id.replace(/\D+/g,""));

            var tab_title_value = $("#tab-link-"+parse_id).find("a").text();
            var tab_content_value = $("#tab-panel-"+parse_id+"> :not('.tab-help-buttons')");

            $("#tabs_title_edit").val(tab_title_value.trim());
            $(".show-tab-name").text(tab_title_value.trim());
            tinymce.get('edit_created_tabs').setContent($(tab_content_value).text());

        };

    });

    $(".contextual-help-tabs  ul li").click(function (event) {
        var target = $( event.target );
        if(target.className = "active"){
            var find_id = $(this).attr("id");
            parse_id = parseInt( find_id.replace(/\D+/g,""));

            var tab_title_value = $("#tab-link-"+parse_id).find("a").text();
            var tab_content_value = $("#tab-panel-"+parse_id+"> :not('.tab-help-buttons')");

            $("#tabs_title_edit").val(tab_title_value.trim());
            $(".show-tab-name").text(tab_title_value.trim());
            tinymce.get('edit_created_tabs').setContent($(tab_content_value).text());

        };

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
                action: 'edit_tabs_in_db',
                screen_id: pagenow
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
                action: 'remove_tabs_in_db',
                screen_id: pagenow
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

// =======  Control form to edit sidebar  =======
    $("#form-for-sidebar-exist").submit(function(e){
        e.preventDefault();

        sidebar_content = tinymce.get('edit_created_sidebar').getContent();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                content_sidebar: sidebar_content,
                screen_id: pagenow,
                action: 'add_sidebar_to_db'
            },
            beforeSend: function(data) {
                $("#form-for-sidebar-exist").find('input[type="submit"]').attr('disabled', 'disabled');
                console.log(data);
            },
            success: function(data){
                console.log(data);
            },
            complete: function(data) {
                $("#form-for-sidebar-exist").find('input[type="submit"]').prop('disabled', false);
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

// =======  Control form to edit sidebar sidebar  =======


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

});
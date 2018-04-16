jQuery(document).ready(function($) {

    var tabs_content ="";
    var sidebar_content ="";
    var uniq_id = 100;
// ==================  Control form to add a new tab  =================================
    $("#form-for-tab").submit(function(e){
        e.preventDefault();
        uniq_id++;
        var tabs_title = $("#tabs_title").val();
        tabs_content = tinyMCE.activeEditor.getContent();
        var screen_id = $('#screen_id').val();
       // console.log(tabs_content);

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    title_tab: tabs_title,
                    content_tab: tabs_content,
                    screen_id:screen_id,
                    action: 'add_help_tabs_to_db'
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
                    $("<p>Successfully saved!</p>").insertBefore(".control-buttons");
                    $(".contextual-help-tabs ul").append($('<li><a href="#tab-panel-'+uniq_id+'">'+tabs_title+'</a></li>'));
                    $(".contextual-help-tabs-wrap").append($('<div id="tab-panel-'+uniq_id+'" class="help-tab-content">'+tabs_content+'</div><br><hr><div class="tab-help-buttons"><a href ="#" onClick="window.location.reload()" class="button edit_current_tab">Edit</a></div>'));
                    success_sent();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
            return false;
    });

    function success_sent(){
       console.log("success!!!");
    };
// ==================  Control form to add a new tab  =================================

    $("#form-for-sidebar").submit(function(e){
            e.preventDefault();

            sidebar_content = tinyMCE.activeEditor.getContent();

           // console.log(tabs_content);

                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        content_sidebar: sidebar_content,
                        screen_id:screen_id,
                        action: 'add_help_tabs_sidebar_to_db'
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
                        $(".show-tab-name").text(tabs_title)
                        $("<p>Successfully saved!</p>").insertBefore(".control-buttons");
                        $(".contextual-help-tabs ul").append($('<li><a href="#tab-panel-'+uniq_id+'">'+tabs_title+'</a></li>'));
                        $(".contextual-help-tabs-wrap").append($('<div id="tab-panel-'+uniq_id+'" class="help-tab-content">'+tabs_content+'</div><br><hr><div class="tab-help-buttons"><a href ="#" onClick="window.location.reload()" class="button edit_current_tab">Edit</a></div>'));
                        success_sent();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
                return false;
        });

        function success_sent(){
           console.log("success!!!");
        };

// ==================  Control form to edit an existed tab  =================================
    var parse_id ="";
    $(".contextual-help-tabs  ul li").click(function (event) {
        var target = $( event.target );
        if(target.className = "active"){
            var find_id = $(this).attr("id");
            parse_id = parseInt( find_id.replace(/\D+/g,""));

            var tab_title_value = $("#tab-link-"+parse_id).find("a").text();
            var tab_content_value = $("#tab-panel-"+parse_id);

            $("#tabs_title_edit").val(tab_title_value.trim());
            $(".show-tab-name").text(tab_title_value.trim());
            tinymce.get("#tab-panel-"+parse_id).getContent()
            // tinyMCE.activeEditor.getContent(tab_content_value);
        };
    });

    $("#form-for-tab-exist").submit(function(e){
        e.preventDefault();

        var tabs_title = $("#tabs_title_edit").val();
        tabs_content = tinyMCE.activeEditor.getContent();

        // console.log(tabs_content);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                title_tab: tabs_title,
                content_tab: tabs_content,
                current_tab_id: parse_id,
                action: 'editing_existed_help_tabs_from_db'
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
                $("<p>Successfully saved!</p>").insertBefore(".control-buttons");
                success_sent();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
        return false;
    });

    function success_sent(){
        console.log("success!!!");
    };
// ==================  Control form to edit an existed tab  =================================
});
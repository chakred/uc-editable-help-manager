jQuery(document).ready(function($) {

    // $('textarea.wp-editor-area').each(function () {
    //     var id = $(this).attr('id');
    //     tinymce.execCommand('mceRemoveEditor', false, id);
    //     tinymce.execCommand('mceAddEditor', false, id);
    // });

    $("#form-for-tab").submit(function(e){
        e.preventDefault();

        var tabs_title = $("#tabs_title").val();
        var tabs_content = $("#create_tabs").val();


            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    title_tab: tabs_title,
                    content_tab: tabs_content,
                    action: 'add_help_tabs_to_db'
                },

                beforeSend: function(data) {
                    // form.find('input[type="submit"]').attr('disabled', 'disabled');
                    console.log(data);
                },
                success: function(data){
                    console.log(data);
                },
                complete: function(data) {
                    // form.find('input[type="submit"]').prop('disabled', false); // в любoм случae включим кнoпку oбрaтнo
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
    }
});
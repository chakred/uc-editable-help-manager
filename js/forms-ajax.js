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
                    $("#form-for-tab").find('input[type="submit"]').attr('disabled', 'disabled');
                    console.log(data);
                },
                success: function(data){
                    console.log(data);
                },
                complete: function(data) {
                    $("#form-for-tab").find('input[type="submit"]').prop('disabled', false); // в любoм случae включим кнoпку oбрaтнo
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

    //========================================================================================================================

$(".contextual-help-tabs  ul li").click(function (event) {
    var target = $( event.target );
    if(target.className = "active"){
        var find_id = $(this).attr("id");
        var parse_id = parseInt( find_id.replace(/\D+/g,""));

        var tub_title_value = $("#tab-link-"+parse_id).find("a").text();
        var tub_content_value = $("#tab-panel-"+parse_id).find("a").text();

        $("#tabs_title_edit").val(tub_title_value.trim());
        $(".show-tab-name").text(tub_title_value.trim());
        // $("#edit_created_tabs").text(tub_content_value);


        // var tabs_content = $("#create_tabs").val();

        // alert(typeof(tub_title_value));
        // console.log($("#tabs_title_edit").val(rrr));

    }

});

//
//
//     $.ajax({
//         type: 'POST',
//         url: ajaxurl,
//         data: {
//             title_tab: tabs_title,
//             content_tab: tabs_content,
//             action: 'add_help_tabs_to_db'
//         },
//
//         beforeSend: function(data) {
//             $("#form-for-tab").find('input[type="submit"]').attr('disabled', 'disabled');
//             console.log(data);
//         },
//         success: function(data){
//             console.log(data);
//         },
//         complete: function(data) {
//             $("#form-for-tab").find('input[type="submit"]').prop('disabled', false); // в любoм случae включим кнoпку oбрaтнo
//             $(".show-tab-name").text(tabs_title)
//             $("<p>Successfully saved!</p>").insertBefore(".control-buttons");
//             success_sent();
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             console.log(xhr.status);
//             console.log(thrownError);
//         },
//
//     });
//     return false;



});
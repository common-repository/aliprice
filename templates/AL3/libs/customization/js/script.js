jQuery( function($) {
    $('.cz_color').wpColorPicker({
        defaultColor: false,
        change: function(event, ui){ },
        clear: function(){ },
        hide: true,
        palettes: true
    });

    $('.cz_upload_file').click(function(){
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            $(button).parent().prev().attr('src', attachment.url);
            $(button).prev().val(attachment.url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        };
        wp.media.editor.open(button);
        return false;
    });

    $('.cz_remove_file').click(function(){
        var r = true;//confirm("Уверены?");
        if (r == true) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');
        }
        return false;
    });
});
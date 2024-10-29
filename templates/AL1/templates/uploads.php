<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 17.02.15 * Time: 10:58 */ ?><h2>Uploads</h2><div id="ssdma_event_js" class="updated settings-error" style="display: none"></div><div id="plupload-upload-ui" class="hide-if-no-js"><div id="drag-drop-area"><div class="drag-drop-inside"><p class="drag-drop-info"><?php _e('Drop files here', 'ssdma'); ?></p><p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p><p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p></div></div></div><script type="text/javascript">

    jQuery(document).ready(function($){

        function noticeElement(c, name) {
            return $('<p>').addClass(c).text(name).append($('<span>').css('padding-left', '10px'));
        }

        var notice = $('#ssdma_event_js'),
            uploader;

        // create the uploader and pass the config from above
        uploader = new plupload.Uploader(<?php echo json_encode(ssdma_get_uploadparams()); ?>);

        // checks if browser supports drag and drop upload, makes some css adjustments if necessary
        uploader.bind('Init', function(up){
            var uploaddiv = $('#plupload-upload-ui');

            if(up.features.dragdrop){
                uploaddiv.addClass('drag-drop');
                $('#drag-drop-area')
                    .bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
                    .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });

            }else{
                uploaddiv.removeClass('drag-drop');
                $('#drag-drop-area').unbind('.wp-uploader');
            }
        });

        uploader.init();

        // a file was added in the queue
        uploader.bind('FilesAdded', function(up, files){
            var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);

            plupload.each(files, function(file){
                if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5'){
                    // file size error?
                    notice.append( noticeElement(file.id, 'File: ' + file.name + ';').find('span').text('Error: file size > ' + up.settings.max_file_size).css('color', 'red') ).css('display', 'block');
                }
            });

            up.refresh();
            up.start();
        });

        // add new files refrash old notice
        uploader.bind('QueueChanged', function() {
            notice.html('').css('display', 'none');
        });

        // before upload add notice
        uploader.bind('BeforeUpload', function(up, file, response) {

            notice.append( noticeElement(file.id, 'File: ' + file.name + ';') ).css('display', 'block');
        });

        uploader.bind('UploadProgress', function(up, file, response) {
            $('.' + file.id + ' span').text(file.percent + '%');
        });

        // a file was uploaded
        uploader.bind('FileUploaded', function(up, file, response) {
            var e = $('.' + file.id + ' span'),
                r = $.parseJSON(response.response);

            if(r.error) {
                text = 'Error: ' + r.error;
                e.css('color', 'red');
            } else {
                text = 'Uploaded';
            }

            e.text(text);
        });

    }(jQuery));

</script>
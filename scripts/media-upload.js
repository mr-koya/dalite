/****************************************************************
Francisco Charrua

Uploads an image to the server. Had to use the jquery.form plugin
Jquery alone did not work.

Also embeds a youtube video in an iframe.

*****************************************************************/


$(document).ready(
        function() {
            $('#collapseOne input[type=radio][name=media1]').change(
                    function(data) {
                        switch(data.target.value) {
                            case 'Video':
                                $('#collapseOne #img_div').hide();                                
                                $('#collapseOne #youdiv').show();
                                break;
                                
                            case 'Image':
                                $('#collapseOne #img_div').show();                               
                                $('#collapseOne #youdiv').hide();
                                break;
                        }
                    }
                );
                
            $('#collapseTwo input[type=radio][name=media2]').change(
                    function(data) {
                        switch(data.target.value) {
                            case 'Video':
                                $('#collapseTwo #img_div').hide();                                
                                $('#collapseTwo #youdiv').show();
                                break;
                                
                            case 'Image':
                                $('#collapseTwo #img_div').show();                               
                                $('#collapseTwo #youdiv').hide();
                                break;
                        }
                    }
                );                
                
            $('#collapseOne #youtube').change(
                    function(data) {                        
                        var id = getYoutubeId(data.target.value);
                        
                        $('#collapseOne #youframe').attr('src', 'http://youtube.com/embed/' + id);
                        $('#collapseOne #youframe').show();
                        
                        $('#collapseOne input[type=radio][name=media1][value=Video]').attr('checked', 'checked');
                        $('#collapseOne input[type=radio][name=media1][value=Video]').trigger('change');
                        
                        $('#collapseOne #youtube1_id').val(id);
                    }
                );
                
            $('#collapseTwo #youtube').change(
                    function(data) {                        
                        var id = getYoutubeId(data.target.value);
                        
                        $('#collapseTwo #youframe').attr('src', 'http://youtube.com/embed/' + id);
                        $('#collapseTwo #youframe').show();
                        
                        $('#collapseTwo input[type=radio][name=media2][value=Video]').attr('checked', 'checked');
                        $('#collapseTwo input[type=radio][name=media2][value=Video]').trigger('change');
                        
                        $('#collapseTwo #youtube2_id').val(id);
                    }
                );                
    
            $('#form').ajaxForm({error: function(data) {alert(data.responseText);},
                       complete: function(data) {eval(data.responseText);}});
    
            $('#collapseOne input[type=file]').change(
                    function(filedata) {
                        $('#form').attr('action', '/media-upload.ajax.php');
                        $('#form').submit();
                        $('#form').attr('action', '');
                    }
            );
            
            $('#collapseTwo input[type=file]').change(
                    function(filedata) {
                        $('#form').attr('action', '/media-upload.ajax.php');
                        $('#form').submit();
                        $('#form').attr('action', '');
                    }
            );            
        }
);

/**************************
 Displays an uploaded image.
                
 **************************/
function uploadReady(file) {
    var file_url = '/img-uploads/' + file;
    var ext = file.substr(file.lastIndexOf('.') + 1);

    $('#collapseOne #filename').val(file);
    
    if(ext != 'jpg' && ext != 'png' && ext != 'gif') {
        $('#collapseOne #img_success').text('please choose an image file (jpeg, gif, or png)');
        return;
    } else {
        $('#collapseOne #img_success').text(file + ' uploaded');
    }
     
    $('#collapseOne #img_show').attr('src', file_url);
    $('#collapseOne #img_show').show();
    
    $('#collapseOne input[type=radio][name=media1][value=Image]').attr('checked', 'checked');
    $('#collapseOne input[type=radio][name=media1][value=Image]').trigger('change');
}

function uploadReadyB(file) {
    var file_url = '/img-uploads/' + file;
    var ext = file.substr(file.lastIndexOf('.') + 1);

    $('#collapseTwo #filename').val(file);
    
    if(ext != 'jpg' && ext != 'png' && ext != 'gif') {
        $('#collapseTwo #img_success').text('please choose an image file (jpeg, gif, or png)');
        return;
    } else {
        $('#collapseTwo #img_success').text(file + ' uploaded');
    }
     
    $('#collapseTwo #img_show').attr('src', file_url);
    $('#collapseTwo #img_show').show();
    
    $('#collapseTwo input[type=radio][name=media2][value=Image]').attr('checked', 'checked');
    $('#collapseTwo input[type=radio][name=media2][value=Image]').trigger('change');
}

/*********************************************************
 Used to properly display a youtube video, by getting its
 11 character id.

 *********************************************************/

function getYoutubeId(text) {
    return(text.match(/[a-zA-Z0-9\-\_]{11}/));
}
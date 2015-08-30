<?php
//Handles file uploads. May have to be relocated.
//If the location is changed, so should $image_file,
//since the path is relative to this script.

function getUploadedFile($name) {
    $tmp_name = $_FILES[$name]['tmp_name'];
    
    
    $info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($info, $tmp_name);
    finfo_close($info);
    
    $extension = '';
    switch($mime_type) {
        case 'image/jpeg':
            $extension = 'jpg';
            break;
    
        case 'image/gif':
            $extension = 'gif';
            break;
    
        case 'image/png':
            $extension = 'png';
            break; 
    
        default:
            $extension = '';
    }
    
    if($extension != '') {
        $image_name = pathinfo($_FILES[$name]['name'])['filename'] . '.' . $extension;
    
        $image_file = 'img-uploads/' . $image_name;
    
        try {
            move_uploaded_file($tmp_name, $image_file);
        }
        catch (Exception $e) {
            print_r($e);    
        }
    }
    
    return($image_name);
}

if(isset($_FILES['media1'])) {
    $file_name = getUploadedFile('media1');
    echo("uploadReady('" . $file_name ."');");
}

if(isset($_FILES['media2'])) {
    $file_name = getUploadedFile('media2');
    echo("uploadReadyB('" . $file_name ."');");
}
?>

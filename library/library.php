<?php
/**
 * Created by PhpStorm.
 * User: Naeem_Sohrabi
 * Date: 10/27/2017
 * Time: 7:55 PM
 */

function upload($files)
{

    $target_dir = APP_DIR . "/public/uploads/";
    $target_file = $target_dir . time() .basename($files["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//    $check = getimagesize($files["tmp_name"]);
//    if ($check == false) {
////        echo "File is not an image.";
//        return false;
//    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        return false;
    }
// Check file size
    if ($files["size"] > 500000000) {
        echo "Sorry, your file is too large.";
        return false;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "zip"
    ) {
        echo "Sorry, only JPG, JPEG, PDF, PNG & GIF files are allowed.";
        return false;
    }

    if (move_uploaded_file($files["tmp_name"], $target_file)) {

        echo "The file " . basename($files["name"]) . " has been uploaded.";
        return time() .basename($files["name"]);
//        echo 'Ooops';
    } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
    }

}

function redirect($url){
    header("Location: ".\App\Config::URL_BASE.$url);
    exit();
}

function refUrl($url){
    if(strpos($url, \App\Config::URL_BASE) >= 0 && ($url != \App\Config::URL_BASE)){
        $reffer_url = str_replace(\App\Config::URL_BASE, '', $url);
        echo $reffer_url;
    }else{
        $reffer_url = 'home/index';
        echo $reffer_url;
    }
    return $reffer_url;
}

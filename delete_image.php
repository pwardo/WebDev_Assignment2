<?php
include 'init.php';

if (!logged_in()){
    header('Location: index.php');
    exit ();
}

if (image_check($_GET['image_id']) === TRUE){
    header('Location: albums.php');
    exit ();
}

if(isset ($_GET['image_id']) || empty ($_GET['image_id'])){
    
    delete_image($_GET['image_id']);
    header('Location: '.$_SERVER['HTTP_REFERER']);
  
    // HTTP_REFERRER returns users to the page they last came from
    exit ();
} 
?>

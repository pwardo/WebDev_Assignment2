<?php
include 'init.php';

if(!logged_in()){
    header('Location: index.php');
    exit();
}

// if album does not belong to this user
if (blog_post_check($_GET['post_id']) === FALSE){
    header('Location:index.php');
    exit ();
}

if(isset ($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    delete_blog_post($post_id);
    header('Location: blog.php?user_id='.$_SESSION['user_id']);
    exit ();
}
?>
<?php
include 'init.php';

if(!logged_in()){
    header('Location: index.php');
    exit ();
}

include 'template/header.php';

$image_id = $_GET['image_id'];

echo 'uploads/', $image['album'], '/', $image['id'], '.', $image['ext'],'';

include 'template/footer.php';
?>
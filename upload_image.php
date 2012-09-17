<?php
include 'init.php';

if (!logged_in()){
    header('Location: index.php');
    exit ();
}

include 'template/header.php';

if(isset ($_FILES['image'], $_POST['album_id'])){
    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_temp = $_FILES['image']['tmp_name'];
    
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    $image_ext = strtolower(end(explode('.', $image_name)));
    // end function takes end part of the file name
    
    $album_id = $_POST['album_id'];
    
    $errors = array();
    
    if (empty ($image_name) || empty ($album_id)){
        $errors[] = 'Something is missing';
    } else {
        
        // in array checks extension against allowed extension array, $allowed_ext
        if (in_array($image_ext, $allowed_ext) === FALSE){
            $errors[] = 'File type not allowed';
        }
        
        // 2097152 bytes = 2mb
        if ($image_size > 2097152){
             $errors[] = 'Maximum file size is 2mb';
        }
        
        // check album belongs to this user
        if(album_check($album_id) === FALSE){
            $errors[] = 'Couldn\'t upload to that album';
        }
    }
    
    if (!empty ($errors)){
        foreach ($errors as $error){
            echo $error, '<br />';
        }
        
    } else {
        upload_image($image_temp, $image_ext, $album_id);
        header('Location: view_album.php?album_id='.$album_id);
        exit ();
    }
}   

$user_id = $_SESSION['user_id'];
$albums = get_albums($user_id);

if(empty ($albums)){
    echo '<p>You don\'t have any albums. <a href="create_album.php">Create an album</a></p>';
} else {
?>
<section id="main_section">    
    <article class="transparent">
        <h2>Upload image</h2><br/>

        <form id="image_upload" action="" method="post" enctype="multipart/form-data">
            <p>Choose a file: <input type="file" name="image"/></p>
            <p>
            Choose an album: <br />
            <select name="album_id">
                <?php
                foreach ($albums as $album){
                    echo '<option value="', $album['id'],'">',$album['name'], '</option>';
                }
                ?>
            </select>
            </p>
            <p><input type="submit" value="Upload"/></p>
            <!--<p><a id="add_more" href="#"/>Add more... </a> -->
        </form>
    </article>
</section>
    
<?php include 'widgets/photo_options.php' ?>

   
<?php  
}

include 'template/footer.php';
?>

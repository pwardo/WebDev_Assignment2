<?php
include 'init.php';

// check to make sure only logged in  users can create albums
if (!logged_in()){
    header('Location: index.php');
    exit;
}

if (isset ($_POST['album_name'], $_POST['album_description'])){
    $album_name = $_POST['album_name'];
    $album_description = $_POST['album_description'];

    $errors = array();
    if (empty ($album_name) || empty ($album_description)){
        $errors[] = 'Album name and description required';
        
    } else{
        if (strlen($album_name) > 55 || strlen($album_description) > 255){
            $errors[] = 'One or more fields contains too many characters';
        }
        
    }
    
    if(!empty($errors)){
        foreach ($errors as $error){
            echo $error, '<br />';
        }
    } else {
        create_album($album_name, $album_description);
        header('Location: albums.php?user_id='.$_SESSION['user_id']);
    }
}

include 'template/header.php';
?>
<section id="main_section">
    <article class="transparent">
        <h2>Create Album</h2>
        <form action="" method="post">
            <p>Name: <br /><textarea id="album_name" name="album_name" maxlength="55" rows="1" cols="75"></textarea></p>
            <div id="album_name_feedback" align="right"></div>

            <p>Description: <br/><textarea id="album_description" name="album_description" maxlength="255" rows="6" cols="75"></textarea></p>
            <div id="album_description_feedback" align="right"></div>
            <p><input type="submit" value="Create"/></p>

        </form>
    </article>
</section>
    <?php include 'widgets/photo_options.php' ?>

<?php
include 'template/footer.php';
?>
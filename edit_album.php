<?php
include 'init.php';

if (!logged_in()){
    header('Location: index.php');
    exit;
}

// empty ($_GET['album_id']) means if no album is set
// if False means albums do not belong to this user
if(!isset ($_GET['album_id']) || empty ($_GET['album_id']) || album_check($_GET['album_id']) === FALSE){
    header('Location: albums.php?user_id='.$_SESSION['user_id']);
    exit;
}



include 'template/header.php';
?>

<?php
$album_id = $_GET['album_id'];
$album_data = album_data($album_id, 'name', 'description');

if(isset ($_POST['album_name'], $_POST['album_description'])){
    $album_name = $_POST['album_name'];
    $album_description = $_POST['album_description'];
    
    if(empty ($album_name) || empty ($album_description)){
        $errors[] = 'Album name and description required';
    } else {
        
        if (strlen($album_name) > 55 || strlen($album_description) > 255){
            $errors = 'One or more fields contains too many characters';
        }
    }
    
    if(!empty($errors)){
        foreach ($errors as $error){
            echo $error, '<br />';
        }
    } else {
        edit_album($album_id, $album_name, $album_description);
        header('Location: albums.php?user_id='.$_SESSION['user_id']);
        exit();
    }    
}

?>
<section id="main_section">
    <article class="transparent">
        <h2>Create Album</h2>
            <form action="?album_id=<?php echo $album_id; ?>" method="post">

                <p>Name: <br /><textarea id="album_name" name="album_name" maxlength="55" rows="1" cols="75"><?php echo $album_data['name'] ?></textarea></p>
                <div id="album_name_feedback" align="right"></div>                
                
                <p>Description: <br/><textarea id="album_description" name="album_description" maxlength="255" rows="6" cols="75"><?php echo $album_data['description'] ?></textarea></p>
                <div id="album_description_feedback" align="right"></div>
                
                <p><input type="submit" value="Edit"/></p>        
            </form>
    </article>
</section>

<?php include 'widgets/photo_options.php' ?>

<?php
include 'template/footer.php';
?>
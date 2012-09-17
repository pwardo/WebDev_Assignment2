<?php
include 'init.php';

if(!logged_in()){
    header('Location: index.php');
    exit ();
}

//if(!isset ($_GET['album_id']) || empty ($_GET['album_id']) || album_check($_GET['album_id']) === FALSE){
//    header('Location: albums.php');
//    exit();
//}

include 'template/header.php';
$album_id = $_GET['album_id'];
$album_data = album_data($album_id, 'user_id', 'name', 'description');
$user_id = $album_data['user_id'];

?>
<section id="main_section">
    <article class="transparent">
        <h2><?php echo $album_data['name']; ?></h2>
        <h3><?php echo $album_data['description']; ?></h3><br />
        
        <?php
        $images = get_images($album_id, $user_id);

        if(empty ($images)){
            echo '<p>There are no images in this album</p>';
        } else {
            foreach ($images as $image){
                    echo '<a href="uploads/', $image['album'], '/', $image['id'], '.', $image['ext'],'"><img src="uploads/thumbs/', $image['album'], '/', $image['id'], '.', $image['ext'],'" title="Uploaded ', date('D M Y / h:1', $image['timestamp']), '" alt="" /></a> [<a href="delete_image.php?image_id=', $image['id'], '">x</a>] ';
            }
        }
        ?>
        
    </article>
</section>
<?php 
include 'widgets/photo_options.php';
include 'template/footer.php';
?>
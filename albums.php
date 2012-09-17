<?php
include 'init.php';

if(!logged_in()){
    header('Location: index.php');
    exit;
}

include 'template/header.php';
?>

<section id="main_section" class="blog">
    <?php
    $user_id = $_GET['user_id'];
    $albums = get_albums($user_id);

    if (empty ($albums)){
        echo '
            <article id="album_page"
                <h2>You don\'t have any albums yet.</h2>
            </article>
        ';
        } else {
        foreach ($albums as $album){
            ?>
   
            <article class="transparent" id="blog_album_page">
                <?php
                    
                if(album_check($album['id']) === FALSE){
                    echo '
                        <hgroup>
                        <h2><a href="view_album.php?album_id=', $album['id'] ,'">', $album['name'], '</a></h2>
                            <p> (', $album['count'],' images)</p>
                        </hgroup>
                            <p>', $album['description'] ,'...</h3><br />

                        <footer>
                        </footer>                       ';

                    $album_id = $album['id'];                                    
                    $single_image = get_single_image($album_id);

                    foreach ($single_image as $image){
                        echo '
                         <figure>
                            <a href="view_album.php?album_id=', $album['id'] ,'"><img src="uploads/thumbs/', $image['album'], '/', $image['id'], '.', $image['ext'],'" /></a>
                         </figure>

                    ';
                    }
                } else{
                    echo '
                        <hgroup>
                        <h2><a href="view_album.php?album_id=', $album['id'] ,'">', $album['name'], '</a></h2>
                            <p> (', $album['count'],' images)</p>
                        </hgroup>
                            <p>', $album['description'] ,'...</h3><br />

                        <footer>
                            <a href="edit_album.php?album_id=', $album['id'],'">Edit</a> / <a href="delete_album.php?album_id=', $album['id'],'">Delete</a>
                        </footer>                        
                        ';

                    $album_id = $album['id'];                                    
                    $single_image = get_single_image($album_id);

                    foreach ($single_image as $image){
                        echo '
                         <figure>
                            <a href="view_album.php?album_id=', $album['id'] ,'"><img src="uploads/thumbs/', $image['album'], '/', $image['id'], '.', $image['ext'],'" /></a>
                         </figure>

                    ';
                    }                 
               }
            ?>

            </article>
            <?php
        }
    }
    ?>
</section>
<?php 
include 'widgets/photo_options.php';
include 'template/footer.php';
?>
<?php
include 'init.php';

if(!logged_in()){
    header('Location: index.php');
    exit ();
}

//if(isset ($_GET['post_id']) === FALSE){
//    header('Location: blog.php?user_id='.$_SESSION['user_id']);
//    exit();
//}

include 'template/header.php';

$post_id = $_GET['post_id'];
$blog_post_data = blog_post_data($post_id, 'user_id', 'title', 'content', 'timestamp');
$user_id = $blog_post_data['user_id'];

?>
<section id="main_section">
    <article class="transparent" id="blog_album_page">
        <?php
        if(blog_post_check($post_id) === FALSE){
        echo '
            <hgroup>
            <h2>', $blog_post_data['title'],'</h2>
            </hgroup>
                <p>', nl2br($blog_post_data['content']),'...</p><br />

            <footer>
                    <p align="right"><b>Posted on '. date('D M Y / h:m', $blog_post['timestamp']).'</b></p>
            </footer>
            ';
        } else{
        echo '
            <hgroup>
            <h2>', $blog_post_data['title'],'</h2>
            </hgroup>
                <p>', nl2br($blog_post_data['content']),'...</p><br />

            <footer>
                    <p><a href="edit_blog_post.php?post_id=', $post_id,'">Edit</a> / <a href="delete_blog_post.php?post_id=', $post_id,'">Delete</a></p>
                    <p align="right"><b>Posted on '. date('D M Y / h:m', $blog_post['timestamp']).'</b></p>
            </footer>
            ';
            
        }
    ?>
    </article>
</section>
<?php 
include 'widgets/blog_options.php';
include 'template/footer.php';
?>
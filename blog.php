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
    $blog_posts = get_blog_posts($user_id);

    if (empty ($blog_posts)){
        echo '
            <article id="blog_album_page">
                <h2>You don\'t have any blog posts yet.</h2>
            </article>
        ';
        } else {
            foreach ($blog_posts as $blog_post){
                ?>                    
                <article class="transparent" id="blog_album_page">
                    <?php
                    if(blog_post_check($blog_post['post_id']) === FALSE){
                    echo '
                        <hgroup>
                        <h2><a href="view_blog_post.php?post_id=', $blog_post['post_id'],'">', $blog_post['title'], '</a></h2>
                        </hgroup>
                            
                            <p>', nl2br(substr($blog_post['content'],0,120)) ,'<br><br/><b><a href="view_blog_post.php?post_id=', $blog_post['post_id'] ,'">Continue Reading....</a></b></p><br /> 
                        
                        <footer>
                                <p align="right"><b>Posted on '.date('D', $blog_post['timestamp']).', '.date('d M Y / h:m', $blog_post['timestamp']).'</b></p>
                        </footer>
                        ';
                    } else{
                    echo '
                        <hgroup>
                        <h2><a href="view_blog_post.php?post_id=', $blog_post['post_id'] ,'">', $blog_post['title'], '</a></h2>
                        </hgroup>
                            
                            <p>', nl2br(substr($blog_post['content'],0,120)) ,'....... <br><br/><b><a href="view_blog_post.php?post_id=', $blog_post['post_id'] ,'">Continue Reading....</a></b></p><br /> 
                        
                        <footer>
                                <p><a href="edit_blog_post.php?post_id=', $blog_post['post_id'],'">Edit</a> / <a href="delete_blog_post.php?post_id=', $blog_post['post_id'],'">Delete</a></p>
                                <p align="right"><b>Posted on '.date('D', $blog_post['timestamp']).', '.date('d M Y / h:m', $blog_post['timestamp']).'</b></p>
                        </footer>
                        ';                    
                    
                    }


                ?>
                </article>
                <?php
            }                                        
        }
    ?>    
</section>
<?php 
include 'widgets/blog_options.php';
include 'template/footer.php';
?>
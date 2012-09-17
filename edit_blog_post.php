<?php
include 'init.php';

if (!logged_in()){
    header('Location: index.php');
    exit;
}

// empty ($_GET['album_id']) means if no album is set
// if False means albums do not belong to this user
if(!isset ($_GET['post_id']) ||  blog_post_check($_GET['post_id']) === FALSE){
    header('Location: albums.php');
    exit;
}

include 'template/header.php';
?>

<?php
$post_id = $_GET['post_id'];
$blog_post_data = blog_post_data($post_id, 'title', 'content');

if(isset ($_POST['post_title'], $_POST['post_content'])){
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    
    echo $_POST['post_title'], '<br/>';
    echo $_POST['post_content'], '<br/>';
    
    
    if(empty ($post_title) || empty ($post_content)){
        $errors[] = 'Blog post title and content required';
    } else {
        
        if (strlen($post_title) > 255) {
            $errors = 'One or more fields contains too many characters';
        }
    }
    
    if(!empty($errors)){
        foreach ($errors as $error){
            echo $error, '<br />';
        }
    } else {
        edit_blog_post($post_id, $post_title, $post_content);
        header('Location: blog.php?user_id='.$_SESSION['user_id']);
        exit();
    }    
}

?>
<section id="main_section">
    <article class="transparent">
        <h2>Edit Blog Post</h2>
        <form action="" method="post">
            <p>Title: <br /><textarea id="blog_title" name="post_title" rows="2" cols="75" maxlength="255"/><?php echo $blog_post_data['title']; ?></textarea></p>
            <div id="blog_title_feedback" align="right"></div>
            <p>Content: <br/><textarea name="post_content" rows="20" cols="75"><?php echo $blog_post_data['content']; ?></textarea></p>
            <p><input type="submit" value="Post"/></p>
        </form>
    </article>
</section>
    <?php include 'widgets/blog_options.php' ?>

<?php
include 'template/footer.php';
?>
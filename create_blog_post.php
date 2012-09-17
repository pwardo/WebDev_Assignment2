<?php
include 'init.php';

// check to make sure only logged in  users can create posts
if (!logged_in()){
    header('Location: index.php');
    exit;
}

if (isset ($_POST['post_title'], $_POST['post_content'])){
    $cat_id = 0;
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];

    $errors = array();
    if (empty ($post_title) || empty ($post_content)){
        $errors[] = 'Post title and content required';
        
    } else{
        if (strlen($post_title) > 255){
            $errors[] = 'Titles can be 255 characters or less';
        }
    }
    
    if(!empty($errors)){
        foreach ($errors as $error){
            echo $error, '<br />';
        }
    } else {
        create_blog_post($cat_id, $post_title, $post_content);
        header('Location: blog.php?user_id='.$_SESSION['user_id']);
    }
}

include 'template/header.php';
?>
<section id="main_section">
    <article class="transparent">
        <h2>Post A New Blog</h2>
        <form action="" method="post">
            <p>Title: <br/><textarea id="blog_title" name="post_title" rows="2" cols="75" maxlength="255"/></textarea></p>
            <div id="blog_title_feedback" align="right"></div>
            <p>Content: <br/><textarea name="post_content" rows="20" cols="75"></textarea></p>
            <p><input type="submit" value="Post"/></p>
        </form>
    </article>
</section>
    <?php include 'widgets/blog_options.php' ?>

<?php
include 'template/footer.php';
?>
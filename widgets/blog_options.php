<?php
if (!logged_in()){
?>
    <?php
} else {
?>
<aside id="side_options">
    <header><h2>Blog Options</h2></header>
    <ul id="sidebar_content">
        <li><a href="create_blog_post.php">New post</a></li>
    </ul>
</aside>
<?php
}
?>
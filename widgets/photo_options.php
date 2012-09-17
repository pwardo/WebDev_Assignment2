<?php
if (!logged_in()){
?>

    <?php
} else {
    echo '

<aside id="side_options">
    <header><h2>Album Options</h2></header>
    <ul id="sidebar_content">
        <li><a href="create_album.php?user_id=', $_SESSION['user_id'],'">Create album</a></li>
        <li><a href="upload_image.php?user_id=', $_SESSION['user_id'],'">Upload an image</a></li>
    </ul>
</aside>
';
}
?>
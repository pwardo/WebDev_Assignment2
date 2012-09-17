<?php

if (!logged_in()){
?>
    <?php
} else {
    echo '
    <h1>Main Navigation</h1>
    <ul id="sidebar_content">
        <!-- <li><a href="search.php?user_id=', $_SESSION['user_id'],'">Search</a></li> -->
        <li><a href="profile.php?user_id=', $_SESSION['user_id'],'">My Profile</a></li>
        <li><a href="albums.php?user_id=', $_SESSION['user_id'],'">My Photos</a></li>
        <li><a href="blog.php?user_id=', $_SESSION['user_id'],'">My Blog</a></li>
        <li><a href="account.php?user_id=', $_SESSION['user_id'],'">Account</a></li>
        <li><a href="logout.php">Logout </a></li>
    </ul>
    ';
    
}
?>

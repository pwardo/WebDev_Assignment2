<?php
function blog_post_data($post_id){
    $post_id = (int)$post_id;
    // Security: this will only allow integers
        
    $args = func_get_args();
    // func_get_args() returns an array of user data from databse.
    
    unset ($args[0]);
    // This un sets the first element from the array??? 
    
    $fields = '`'.implode('`, `', $args).'`';
    // impode glues stings together, in this case strings are taken from database.
    // result here is `name``email.
    
    $query = mysql_query("SELECT $fields FROM blog_posts WHERE post_id=$post_id ") or die;
    $query_result = mysql_fetch_assoc($query);
    // retrieve the fields passed from implode function for the current logged in user.
    // and make associative array from the results.
    
    foreach ($args as $field){
        $args[$field ] = $query_result[$field];
        // get data from array for each of the $field names i.e. args[`email`]
        
    }
    return $args;   
}

function get_blog_posts($user_id){
    $blog_posts = array();
    
    $blog_posts_query = mysql_query("
        SELECT post_id, cat_id, content, title, timestamp 
        FROM blog_posts
        WHERE blog_posts.user_id = $user_id
            ORDER BY timestamp DESC
        ");
    
    // LEFT(albums.description, 50) this limits characters to 50 from the left of the string
    // LEFT JOIN images to albums
    // the condition matches album.album_id with images.album_id
    // WHERE albums.user_id = the current logged in user.
    
    while ($blog_posts_row = mysql_fetch_assoc($blog_posts_query)){
        // create a multi dimensional array
        // first dimension is albums, 2nd dimension is images 
        $blog_posts[] = array(
            'post_id' => $blog_posts_row['post_id'],
            'cat_id' => $blog_posts_row['cat_id'],
            'content' => $blog_posts_row['content'],
            'title' => $blog_posts_row['title'],
            'timestamp' => $blog_posts_row['timestamp']
        );
    }
    return $blog_posts;
}

function get_latest_blog_posts($user_id){
    $blog_posts = array();
    
    $blog_posts_query = mysql_query("
        SELECT post_id, cat_id, content, title, timestamp 
        FROM blog_posts
        WHERE blog_posts.user_id = $user_id
            ORDER BY timestamp DESC LIMIT 3
        ");
    
    // LEFT(albums.description, 50) this limits characters to 50 from the left of the string
    // LEFT JOIN images to albums
    // the condition matches album.album_id with images.album_id
    // WHERE albums.user_id = the current logged in user.
    
    while ($blog_posts_row = mysql_fetch_assoc($blog_posts_query)){
        // create a multi dimensional array
        // first dimension is albums, 2nd dimension is images 
        $blog_posts[] = array(
            'post_id' => $blog_posts_row['post_id'],
            'cat_id' => $blog_posts_row['cat_id'],
            'content' => $blog_posts_row['content'],
            'title' => $blog_posts_row['title'],
            'timestamp' => $blog_posts_row['timestamp']
        );
    }
    return $blog_posts;
}

function create_blog_post($cat_id, $post_title, $post_content){
    $post_title = mysql_real_escape_string (htmlentities($post_title));
    $post_content = mysql_real_escape_string(htmlentities($post_content));
    // htmlentities prevents html from being inserted, html code will just be displayed instead of being interpretted by system.

    mysql_query("INSERT INTO blog_posts VALUES ('', '".$_SESSION['user_id']."', '$cat_id', '$post_content', '$post_title', UNIX_TIMESTAMP())") or die();   
}

function edit_blog_post($post_id, $post_title, $post_content){
    $post_id = (int)$post_id;
    $post_title = mysql_real_escape_string($post_title);
    $post_content = mysql_real_escape_string($post_content);
    
    mysql_query("UPDATE blog_posts SET title='$post_title', 
            content='$post_content' 
            WHERE post_id = '$post_id'
            AND user_id =".$_SESSION['user_id']
            );
    // .$_SESSION['user_id'] means only the curent user can edit the album
}

function blog_post_check($post_id){
    $post_id = (int)$post_id;
    $query = mysql_query("SELECT COUNT(post_id) FROM blog_posts 
        WHERE post_id=$post_id
        AND user_id=".$_SESSION['user_id'] 
        );
    
    // Count will return number
    // if count = 1, then album_id and user_id correspond meaning the album belongs to this user
    // So true returned
    // if count == 0, album_id and user_id do not correspod meaning album does not belong to this user
    // So false is returned
    // ? true means return true
    // : false means else return false
    return (mysql_result($query, 0) == 1) ? TRUE : FALSE;
}


function delete_blog_post($post_id){
    $post_id = (int)$post_id;

    mysql_query("DELETE FROM blog_posts WHERE post_id=$post_id
            AND user_id=".$_SESSION['user_id']
            );
}

function add_category($name){
    
}

function get_categories($cat_id = null){
    
}

function category_exists($cat_id){
    
}


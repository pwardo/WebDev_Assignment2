<?php
function album_data($album_id){
    $album_id = (int)$album_id;
    // Security: this will only allow integers
        
    $args = func_get_args();
    // func_get_args() returns an array of user data from databse.
    
    unset ($args[0]);
    // This un sets the first element from the array??? 
    
    $fields = '`'.implode('`, `', $args).'`';
    // impode glues stings together, in this case strings are taken from database.
    // result here is `name``email.
    
    $query = mysql_query("SELECT $fields FROM albums WHERE album_id=$album_id ");
    $query_result = mysql_fetch_assoc($query);
    // retrieve the fields passed from implode function for the current logged in user.
    // and make associative array from the results.
    
    foreach ($args as $field){
        $args[$field ] = $query_result[$field];
        // get data from array for each of the $field names i.e. args[`email`]
        
    }
    return $args;   
}

function album_check($album_id){
    $album_id = (int)$album_id;
    $query = mysql_query("SELECT COUNT(album_id) FROM albums 
        WHERE album_id=$album_id
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

function get_albums($user_id){
    $albums = array();
    
    $albums_query = mysql_query("
        SELECT albums.album_id, albums.timestamp, albums.name, LEFT(albums.description, 50) as description, COUNT(images.image_id) as image_count
        FROM albums
        LEFT JOIN images
        ON albums.album_id = images.album_id
        WHERE albums.user_id = $user_id
            GROUP BY albums.album_id
            ORDER BY albums.timestamp DESC
        ");
    
    // LEFT(albums.description, 50) this limits characters to 50 from the left of the string
    // LEFT JOIN images to albums
    // the condition matches album.album_id with images.album_id
    // WHERE albums.user_id = the current logged in user.
    
    while ($albums_row = mysql_fetch_assoc($albums_query)){
        // create a multi dimensional array
        // first dimension is albums, 2nd dimension is images 
        $albums[] = array(
            'id' => $albums_row['album_id'],
            'timestamp' => $albums_row['timestamp'],
            'name' => $albums_row['name'],
            'description' => $albums_row['description'],
            'count' => $albums_row['image_count']
            
        );
    }
    return $albums;
}

function create_album($album_name, $album_description){
    $album_name = mysql_real_escape_string (htmlentities($album_name));
    $album_description = mysql_real_escape_string(htmlentities($album_description));
    // htmlentities prevents html from being inserted, html code will just be displayed instead of being interpretted by system.

    mysql_query("INSERT INTO albums VALUES ('', '".$_SESSION['user_id']."', UNIX_TIMESTAMP() , '$album_name', '$album_description')");
    mkdir('uploads/'.mysql_insert_id(), 0744);
    mkdir('uploads/thumbs/'.mysql_insert_id(), 0744);
    // 0744 is file permissions for the folders that are being created.
    
}

function edit_album($album_id, $album_name, $album_description){
    $album_id = (int)$album_id;
    $album_name = mysql_real_escape_string($album_name);
    $album_description = mysql_real_escape_string($album_description);
    
    mysql_query("UPDATE albums SET name='$album_name', 
            description='$album_description' 
            WHERE album_id = '$album_id'
            AND user_id =".$_SESSION['user_id']
            );
    // .$_SESSION['user_id'] means only the curent user can edit the album
}   


// delete album is not working properly, removes from db but does not delete files
function delete_album($album_id){
    $album_id = (int)$album_id;
    
    // open dir
//    $open_dir = opendir("uploads/".$album_id);
    
    // get info of each image in dir
//    while ($image = readdir($open_dir)){
//        $images[] = $image;
//    }
//    closedir();
    
//    foreach ($images as $image){
//        unlink($image) or die ("Some images could not be deleted!");
//    }
    
    // remove album directory
//    remdir("uploads/.$album_id") or die ("Directory ". $album_id ." not removed!");
    
    
    // remove thumbs ---------------------------------------
//    $open_thumbs_dir = opendir("uploads/thumbs/".$album_id);
//    while ($thumbs = readdir($open_thumbs_dir)){
//        $thumbs[] = $thumb;
//    }
//    closedir();
//    
//    foreach ($thumbs as $thumb){
//        unlink($thumb) or die ("Error : some thumbs could not be deleted!");
//    }
//    rmdir('uploads/thumbs/'.$album_id) or die ("Thumbs directory ". $album_id ." not removed!");
    

    // remove from db -----------------------------------------------------
    mysql_query("DELETE FROM albums WHERE album_id=$album_id
            AND user_id=".$_SESSION['user_id']
            );
    
    mysql_query("DELETE FROM images WHERE album_id=$album_id
            AND user_id=".$_SESSION['user_id'] 
            );
}


// Extras for PROFILE PAGE

// get last 3 albums for profile page
function get_latest_albums($user_id){
    $albums = array();
    
    $albums_query = mysql_query("
        SELECT albums.album_id, albums.timestamp, albums.name, LEFT(albums.description, 50) as description, COUNT(images.image_id) as image_count
        FROM albums
        LEFT JOIN images
        ON albums.album_id = images.album_id
        WHERE albums.user_id = $user_id
            GROUP BY albums.album_id
            ORDER BY album_id DESC LIMIT 3
        ");
        
    // LEFT(albums.description, 50) this limits characters to 50 from the left of the string
    // LEFT JOIN images to albums
    // the condition matches album.album_id with images.album_id
    // WHERE albums.user_id = the current logged in user.
    
    while ($albums_row = mysql_fetch_assoc($albums_query)){
        // create a multi dimensional array
        // first dimension is albums, 2nd dimension is images 
        $albums[] = array(
            'id' => $albums_row['album_id'],
            'timestamp' => $albums_row['timestamp'],
            'name' => $albums_row['name'],
            'description' => $albums_row['description'],
            'count' => $albums_row['image_count']
            
        );
    }
    return $albums;
}
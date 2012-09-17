<?php
function upload_image($image_temp, $image_ext, $album_id){
    $album_id = (int)$album_id;
    
    mysql_query("INSERT INTO images VALUES 
        ('', '".$_SESSION['user_id']."', '$album_id', UNIX_TIMESTAMP(),'$image_ext')"
        );
    
    $image_id = mysql_insert_id();
    // takes id from previous mysql_query
    
    $image_file = $image_id.'.'.$image_ext;
    // the image file name will consist of image_id and image_ext i.e. 1.jpg, 2.jpg etc.
    
    move_uploaded_file($image_temp, 'uploads/'.$album_id.'/'.$image_file);
    
    create_thumb('uploads/'.$album_id.'/', $image_file, 'uploads/thumbs/'.$album_id.'/');
}


function upload_profile_image($image_temp, $image_ext, $user_id){
    $user_id = (int)$user_id;  
    
    mysql_query("INSERT INTO profile_images VALUES 
        ('', '$user_id', UNIX_TIMESTAMP(), '$image_ext')"
        );
    
    $image_id = mysql_insert_id();
    // takes id from previous mysql_query
       
    $image_file = $image_id.'.'.$image_ext;
    // the image file name will consist of image_id and image_ext i.e. 1.jpg, 2.jpg etc.
    
    move_uploaded_file($image_temp, 'profile_images/'.$user_id.'/'.$image_file);
    
    create_profile_thumb('profile_images/'.$user_id.'/', $image_file, 'profile_images/thumbs/'.$user_id.'/');
}


function get_images($album_id, $user_id){
    $user_id = (int)$user_id;
    $album_id = (int)$album_id;
    
    $images = array();
    
    $image_query = mysql_query("SELECT image_id, album_id, timestamp, ext
        FROM images
        WHERE album_id=$album_id
        AND user_id= $user_id
        ");
    
    while ($images_row = mysql_fetch_assoc($image_query)){
        $images[] = array(
            'id' => $images_row['image_id'],
            'album' => $images_row['album_id'],
            'timestamp' => $images_row['timestamp'],
            'ext' => $images_row['ext']
        );
    }
    return $images;
}

function image_check($image_id){
    $image_id = (int)$image_id;
    $query = mysql_query("SELECT COUNT(image_id) 
        FROM images 
        WHERE image_id=$image_id
        AND user_id=".$_SESSION['user_id']
        );
    
    return (mysql_query($query, 0) == 0) ? FALSE : TRUE;
   
}

function delete_image($image_id){
    $image_id = (int)$image_id;
    
    $image_query = mysql_query("SELECT album_id, ext 
        FROM images
        WHERE image_id=$image_id
        AND user_id=".$_SESSION['user_id']
        );
    
    $image_result = mysql_fetch_assoc($image_query);
    
    $album_id = $image_result['album_id'];
    $image_ext = $image_result['ext'];
    
    // unlink is used in PHP to delete files
    unlink('uploads/'.$album_id.'/'.$image_id.'.'.$image_ext);
    unlink('uploads/thumbs/'.$album_id.'/'.$image_id.'.'.$image_ext);

    // delete from database
    mysql_query("DELETE FROM images
        WHERE image_id=$image_id
        AND user_id=".$_SESSION['user_id']
        );
}

// This is to get album thumb
function get_single_image($album_id){
    $album_id = (int)$album_id;
    
    $images = array();
    
    $image_query = mysql_query("SELECT image_id, album_id, timestamp, ext
        FROM images
        WHERE album_id=$album_id
            ORDER BY timestamp DESC LIMIT 1"
            ) or die("display_db_query:" . mysql_error());
    
    while ($images_row = mysql_fetch_assoc($image_query)){
        $images[] = array(
            'id' => $images_row['image_id'],
            'album' => $images_row['album_id'],
            'timestamp' => $images_row['timestamp'],
            'ext' => $images_row['ext']
        );
    }
    return $images;
}

// This is to get profile image
function get_profile_image($user_id){
    $user_id = (int)$user_id;
    
    $images = array();
    
    $image_query = mysql_query("SELECT profile_image_id, timestamp, ext
        FROM profile_images
        WHERE user_id= $user_id
            ORDER BY timestamp DESC LIMIT 1"
        ) or die("display_db_query:" . mysql_error());
    
    while ($images_row = mysql_fetch_assoc($image_query)){
        $images[] = array(
            'id' => $images_row['profile_image_id'],
            'timestamp' => $images_row['timestamp'],
            'ext' => $images_row['ext']
        );
    }
    return $images;
}



?>

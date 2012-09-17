<?php
function get_class_mates($courseID){
    $class_mates = array();
    
    $class_mates_query = mysql_query("
        SELECT user_id, firstName, lastName, otherNames, gender, dateOfBirth, mobileNumber, email, joined, courseID, status 
        FROM users
        WHERE users.courseID = '$courseID' AND users.user_id !=".$_SESSION['user_id']."
        ") or die();
    while ($class_mates_row = mysql_fetch_assoc($class_mates_query)){
        $class_mates[] = array(
            'user_id' => $class_mates_row['user_id'],
            'firstName' => $class_mates_row['firstName'],
            'lastName' => $class_mates_row['lastName'],
            'otherNames' => $class_mates_row['otherNames'],
            'gender' => $class_mates_row['gender'],
            'dateOfBirth' => $class_mates_row['dateOfBirth'],
            'mobileNumber' => $class_mates_row['mobileNumber'],
            'email' => $class_mates_row['email'],
            'joined' => $class_mates_row['joined'],
            'courseID' => $class_mates_row['courseID'],
            'status' => $class_mates_row['status']
        );
    }
    return $class_mates;
}

function get_news_items($userID){
    $news_items = array();
    
    $news_items_query = mysql_query("
        SELECT blog_posts.timestamp as timestamp, blog_posts.user_id, blog_posts.post_id, blog_posts.title
            FROM blog_posts 
            WHERE blog_posts.user_id = 9
        
        Union
        
        SELECT albums.timestamp as timestamp, albums.user_id, albums.album_id, albums.name
            FROM albums WHERE albums.user_id = 9
            
        ORDER BY timestamp

        ");
    
    
    while ($news_items_row = mysql_fetch_assoc($news_items_query)){
        // create a multi dimensional array
        // first dimension is albums, 2nd dimension is images 
        $news_items[] = array(
            'user_id' => $news_items_row['user_id'],
            'post_id' => $news_items_row['post_id'],
            'title' => $news_items_row['title'],
            'name' => $news_items_row['name'],
            'timestamp' => $news_items_row['timestamp'],
        );
    }
    return $news_items;
}
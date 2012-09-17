<?php
function logged_in(){
    return isset($_SESSION['user_id']);
}

function login_check($studentID, $password){
    $studentID = mysql_real_escape_string($studentID) or die(mysql_error()); // sanitise string
    
    $login_query = mysql_query("SELECT COUNT(`user_id`) as `count`, `user_id` FROM `users` WHERE `studentID`='$studentID' AND `password`='".md5($password)."'")  or die(mysql_error());  
//    count the user id, condition is where email and password match a current user. count will be 0 or 1. 1 if user is registered.
    
    return(mysql_result($login_query, 0) == 1) ? mysql_result($login_query, 0, 'user_id') : false;
//    if result is 1, then there is a match and we want to return the user_id. ELSE return FALSE.
}

function user_data(){
    $args = func_get_args();
    // func_get_args() returns an array of user data from database.
    
    $fields = '`'.implode('`, `', $args).'`';
    // impode glues stings together, in this case strings are taken from database.
    // result here is `name``email.
    
    $query = mysql_query("SELECT $fields FROM users WHERE users.user_id =".$_SESSION['user_id']) or die(mysql_error());
    $query_result = mysql_fetch_assoc($query);
    // retrieve the fields passed from implode function for the current logged in user.
    // and make associative array from the results.
    
    foreach ($args as $field){
        $args[$field] = $query_result[$field];
        // get data from array for each of the $field names i.e. args[`email`]
        
    }
    return $args;
}
function user_register($studentID, $firstName, $lastName, $email, $password, $courseID){
    $studentID = mysql_real_escape_string($studentID); // sanitise email
    $firstName = mysql_real_escape_string($firstName); // sanitise name
    $lastName = mysql_real_escape_string($lastName); // sanitise name
    $email = mysql_real_escape_string($email); // sanitise name
    $courseID = mysql_real_escape_string($courseID); // sanitise name
    
    mysql_query("INSERT INTO users VALUES('', '$studentID', '$firstName', '$lastName', '', '', '', '', '$email', '".md5($password)."', '', UNIX_TIMESTAMP() , '$courseID', '')") or die(mysql_error());
    mysql_insert_id();  

    mkdir('profile_images/'.mysql_insert_id(), 0744);
    mkdir('profile_images/thumbs/'.mysql_insert_id(), 0744);
    
    return mysql_insert_id(); // gets the id of newly registered user.    
}

function user_exists($studentID){
    $studentID = mysql_real_escape_string($studentID); // sanitise email
   
    $query = mysql_query("SELECT COUNT(user_id) FROM users WHERE studentID = '$studentID'"); // returns integer 
    return(mysql_result($query, 0) == 1) ? true : false; 
    // if returned integer is 0, user is not registered. If interger is 1, student ID is already registered.
}

function get_user_data($user_id){
    $user_data_query = mysql_query("
        SELECT studentID, firstName, lastName, otherNames, gender, dateOfBirth, mobileNumber, email, joined, courseID, status
        FROM users

        WHERE user_id = $user_id
        ") or die();
        
    
    while ($user_data_row = mysql_fetch_assoc($user_data_query)){
        $user_data = array(
            'studentID' => $user_data_row['studentID'],
            'firstName' => $user_data_row['firstName'],
            'lastName' => $user_data_row['lastName'],
            'otherNames' => $user_data_row['otherNames'],
            'gender' => $user_data_row['gender'],
            'dateOfBirth' => $user_data_row['dateOfBirth'],
            'mobileNumber' => $user_data_row['mobileNumber'],
            'email' => $user_data_row['email'],
            'joined' => $user_data_row['joined'],
            'courseID' => $user_data_row['courseID'],
            'status' => $user_data_row['status']
        );
    }
    return $user_data;
}

?>
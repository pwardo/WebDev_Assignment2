<?php
include 'init.php';

if (!logged_in()){
    header('Location: index.php');
    exit;
} else{
    $user_data = user_data('studentID', 'firstName', 'lastName', 'otherNames', 'gender', 'dateOfBirth', 'mobileNumber', 'email', 'password', 'about', 'courseID', 'status');

    $changeTo = $_POST['changeTo']; // If edit button is pressed and new value is entered.
    
    $submitFirstName = $_POST['submitFirstName'];
    if ($submitFirstName && $changeTo){
        $changeTo = mysql_real_escape_string($changeTo);
	mysql_query("UPDATE users SET users.firstName = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }
    
    $submitLastName = $_POST['submitLastName'];
    if ($submitLastName && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
        mysql_query("UPDATE users SET lastName = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }        
    
    $submitOtherNames = $_POST['submitOtherNames'];
    if ($submitOtherNames && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
        mysql_query("UPDATE users SET otherNames = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }
    
    $submitMobileNumber = $_POST['submitMobileNumber'];
    if ($submitMobileNumber && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
	mysql_query("UPDATE users SET mobileNumber = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }
    
    $submitEmail = $_POST['submitEmail'];
    if ($submitEmail && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
	mysql_query("UPDATE users SET email = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }
    
    $submitDateOfBirth = $_POST['submitDateOfBirth'];
    if ($submitDateOfBirth && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
        mysql_query("UPDATE users SET dateOfBirth = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }
    
    $updateStatus = $_POST['updateStatus'];
    if ($updateStatus && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
	mysql_query("UPDATE users SET status = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }
    
    $updateCourseID = $_POST['updateCourseID'];
    if ($updateCourseID && $changeTo)
    {
        $changeTo = mysql_real_escape_string($changeTo);
	mysql_query("UPDATE users SET courseID = '$changeTo' WHERE user_id = ".$_SESSION['user_id']) or die("display_db_query:" . mysql_error());
        header('Location: account.php');
    }

    // For profile image
    
    $upload_profile_image = $_POST['upload_profile_image'];
    if ($upload_profile_image){
        $image_name = $_FILES['profile_image']['name'];
        $image_size = $_FILES['profile_image']['size'];
        $image_temp = $_FILES['profile_image']['tmp_name'];

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $image_ext = strtolower(end(explode('.', $image_name)));
        // end function takes end part of the file name

        $errors = array();
        
        if (empty ($image_name)){
            $errors[] = 'Something is missing';
        } else {
            
            // in array checks extension against allowed extension array, $allowed_ext
            if (in_array($image_ext, $allowed_ext) === FALSE){
                $errors[] = 'File type not allowed';
            }

            // 2097152 bytes = 2mb
            if ($image_size > 2097152){
                 $errors[] = 'Maximum file size is 2mb';
            }
        }

        if (!empty ($errors)){
            foreach ($errors as $error){
                echo $error, '<br />';
            }

        } else {
            $user_id = $_SESSION['user_id'];
            upload_profile_image($image_temp, $image_ext, $user_id);
            header('Location: account.php?user_id='.$user_id);
            exit ();
        }
    }
    // end of script for profile image

 
include 'template/header.php';
?>
<section id="main_section">
    <article class="transparent" id="account">
        <h2>Personal Information</h2>

        <table class="Table">
            <form action="" method='POST'>
                <tr> <td><h3>Status:</h3></td></tr>
                <tr> <!-- to Change First Name -->
                    <td colspan = '6'>
                        <textarea id="status_update" style="float:center" name='changeTo' type='text' cols='70' rows ="5"><?php echo $user_data['status']; ?></textarea>							
                        <div id="status_update_feedback" align="right"></div>
                    </td>
		</tr>
		<tr><td><input type='submit' name='updateStatus' value='Update'></td></tr>
            </form>	
				
            <form action="" method='POST'>
                <tr> <td><h3>Personal Details:</h3></td></tr>
                <tr> <!-- to Change First Name -->
                    <td><span class="Bold">First Name: </span></td>
                    <td></td>
                    <td> <span class="Bold"> Change to: </span></td>
                    <td><input type='text' name='changeTo' value='<?php echo $user_data['firstName']; ?>'></td>
                    <td><input type='submit' name='submitFirstName' value='Update'></td>
                </tr>	
            </form>		
            
            <form action="" method='POST'>
		<tr> <!-- change last name -->
                    <td><span class="Bold">Last Name: </span></td>
                    <td></td>
                    <td> <span class="Bold"> Change to: </span> </td>
                    <td> <input type='text' name='changeTo' value='<?php echo $user_data['lastName']; ?>'> </td>
                    <td><input type='submit' name='submitLastName' value='Update'></td>
                </tr>
            </form>
            
            <form action="" method='POST'>
                <tr> <!-- change last name -->
                    <td><span class="Bold">Course ID: </span></td>
                    <td></td>
                    <td><span class="Bold"> Change to: </span></td>
                    <td><input type='text' name='changeTo' value='<?php echo $user_data['courseID']; ?>'></td>
                    <td><input type='submit' name='updateCourseID' value='Update'></td>
                </tr>
            </form>
				
            <form action="" method='POST'>
                <tr> <!-- change last name -->
                    <td><span class="Bold">Date Of Birth: </span></td>
                    <td></td>
                    <td><span class="Bold"> Change to: </span> </td>
                    <td><input type='text' name='changeTo' value='<?php echo $user_data['dateOfBirth']; ?>'></td> 
                    <td><input type='submit' name='submitDateOfBirth' value='Update'></td>
		</tr>
            </form>
				
            <form action="" method='POST'>
		<tr> <!-- change or add Mobile Number -->
                    <td><span class="Bold">Other Names: </span></td>
                    <td></td>
                    <td><span class="Bold"> Change to: </span></td>
                    <td><input type='text' name='changeTo' value='<?php echo $user_data['otherNames']; ?>'></td>
                    <td><input type='submit' name='submitOtherNames' value='Update'></td>
                </tr>
            </form>
					
            <form action="" method='POST'>
		<tr><td></td></tr>
		<tr><td><h3>Contact Details:</h3></td></tr>
		<tr> <!-- change or add Mobile Number -->
                    <td><span class="Bold">E-mail Address: </span></td>
                    <td></td>
                    <td><span class="Bold"> Change to: </span></td>
                    <td><input type='text' name='changeTo' value='<?php echo $user_data['email']; ?>'></td>
                    <td><input type='submit' name='submitEmail' value='Update'></td>
		</tr>
            </form>
            
            <form action="" method='POST'>
                <tr> <!-- change or add Mobile Number -->
                    <td><span class="Bold">Mobile Number: </span></td>
                    <td></td>
                    <td><span class="Bold"> Change to: </span></td>
                    <td><input type='text' name='changeTo' value='<?php echo $user_data['mobileNumber']; ?>'></td>
                    <td><input type='submit' name='submitMobileNumber' value='Update'></td>
                </tr>
            </form>
	</table>	
    </article>			
</section>
    
<aside>
    <article>
        <?php
        $user_id = $_SESSION['user_id'];
        $profile_images = get_profile_image($user_id);

        if(empty ($profile_images)){
            echo '<p>You don\'t have a profile image yet!!!! </p>';
        } else {
            foreach ($profile_images as $profile_image){
                    echo '<a href="profile_images/', $user_id, '/', $profile_image['id'], '.', $profile_image['ext'],'"><img src="profile_images/thumbs/', $user_id, '/', $profile_image['id'], '.', $profile_image['ext'],'" title="Uploaded ', date('D M Y / h:1', $profile_image['timestamp']), '" alt="" /></a>';
            
                    
                    echo '<br/>';
                    echo '<br/>';
                    echo '<br/>';
                }
        }
        ?>

    </article>
            <br/>
            <br/>
        <h2>Upload a new profile image</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <p>Choose a file: <input type="file" name="profile_image"/></p>
                <p><input type="submit" name="upload_profile_image" value="Upload "/></p>
            </form>
</aside>

<?php
}
include 'template/footer.php';
?>
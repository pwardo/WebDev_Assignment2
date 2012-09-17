<?php
include 'init.php';
include 'func/search.func.php';
// check to make sure only logged in  users can create albums
if (!logged_in()){
    header('Location: index.php');
    exit;
}

include 'template/header.php';
?>
<section id="main_section">
    <article class="transparent">
        <h2>Search</h2>
        <form action="" method="post">
            <p>
                <input type="text" name="keywords"/> <input type="submit" value="Search"/>
            </p>

        </form>
    </article>
    
<?php    
    if(isset($_POST['keywords'])){
        $keywords = mysql_real_escape_string(htmlentities(trim($_POST['keywords'])));
        
        $errors = array();
        
        if(empty($keywords)){
            $errors[] = 'Please enter a search term';
        } else if(strlen($keywords) < 3){
            $errors[] = 'Your search term must be 3 or more characters long';
        } else if (1==2) {
            $errors[] = 'Your search for '.$keywords.'returned no results';
        }
        
        if (empty ($errors)){
            search_results($keywords);
        } else {
            foreach ($errors as $error){
                echo $error, '</br>';
            }
        }
    }
    
 ?>
</section>

<?php
include 'template/footer.php';
?>
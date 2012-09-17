<?php
include 'init.php';
include 'template/header.php';

if (logged_in()){
    $user_data = user_data('firstName');

    ?>

    <section id="main_section">
        <article class="transparent" id="blog_album_page">
            <h3>Hi <?php echo $user_data['firstName'];?>, welcome to your DIT Social portal..... </h3>
	</article>
    </section>

<?php
} else {

?>
    <?php include 'widgets/login.php' ?>
    <?php include 'widgets/welcome.php' ?>
		
    
<?php    
}

include 'template/footer.php';
?>
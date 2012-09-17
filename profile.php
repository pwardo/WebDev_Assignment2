<?php
include 'init.php';

if (!logged_in()){
    header('Location: index.php');
    exit;
} else{
    $_SESSION['studentID'];
    $user_id = $_GET['user_id'];
    $user_data = get_user_data($user_id);
    
    $albums = get_latest_albums($user_id);
    $blog_posts = get_latest_blog_posts($user_id);

    $single_image = get_single_image($user_id, $album_id);
}
include 'template/header.php';
?>
    <section id="profile_section1">	
        <article class="transparent" id="personal_details">
            <h2><?php echo $user_data['firstName'], ' ', $user_data['lastName']; ?> </h2>
		<p><span class="Bold">Birthday: </span> <?php echo $user_data['dateOfBirth']; ?></p>
		<p><span class="Bold">Course: </span> <?php echo $user_data['courseID']; ?>  </p>
		<p><span class="Bold">Student ID: </span> <?php echo $user_data['studentID']; ?></p>	
                <p><span class="Bold">Email: </span> <?php echo $user_data['email']; ?></p>
                <p><span class="Bold">Mobile: </span> <?php echo $user_data['mobileNumber']; ?></p>
        </article>
			
	<article class="transparent" id="my_status">
            <h2>My Status</h2>    
                <p><?php echo nl2br($user_data['status']); ?></p>
	</article>
		
	<article id="profile_photo">
                <?php
                $profile_images = get_profile_image($user_id);

                if(empty ($profile_images)){
                    echo '<p>You don\'t have a profile image yet!!!! </p>';
                } else {
                    foreach ($profile_images as $profile_image){
                            echo '<a href="profile_images/', $user_id, '/', $profile_image['id'], '.', $profile_image['ext'],'"><img src="profile_images/thumbs/', $user_id, '/', $profile_image['id'], '.', $profile_image['ext'],'" title="Uploaded ', date('D M Y / h:1', $profile_image['timestamp']), '" alt="" /></a>';
                        }
                }
                ?>
        </article>		
    </section>
		
    <section id="profile_section2">
        <section id="myPhotos_preview" class="transparent">
            <?php 
            echo '
            <h2><a href="albums.php?user_id=',$user_id, '"/>My Latest Photo Albums</a></h2>
            <br/>
            ';
            if (empty ($albums)){
                echo '
                    <article id="album_page">
                        <h2>You don\'t have any albums yet.</h2>
                    </article>
                ';
            } else {
                foreach ($albums as $album){
                    ?>                 
                    <article>
                        <?php

                        echo '
                            <hgroup>
                            <h2><a href="view_album.php?album_id=', $album['id'] ,'">', $album['name'], '</a></h2>
                                <p> (', $album['count'],' images)</p></th>
                            </hgroup>
                         ';

                        $album_id = $album['id'];
                        $single_image = get_single_image($album_id);

                        foreach ($single_image as $image){
                            echo '
                             <figure>
                                <a href="view_album.php?album_id=', $album['id'] ,'"><img src="uploads/thumbs/', $image['album'], '/', $image['id'], '.', $image['ext'],'" /></a>
                             </figure>
                            ';
                        }                                    
                    ?>
                    </article>
                <?php
                }
            }
        ?> 
        </section>
        
        <article id="friends_list">
            <h2>Class Mates List</h2>
            <br/>
            <?php
            $class_mates = get_class_mates($user_data['courseID']);

            if (empty ($class_mates)){
                echo '
                    <article id="blog_album_page">
                        <h2>Looks like there are no other students on the course: '.$user_data['courseID'].' </h2>
                    </article>
                ';
                } else {
                    foreach ($class_mates as $class_mate){
                        ?>                    
                        <article>
                            <?php

                            echo '
                                <hgroup>
                                <h3><a href="profile.php?user_id=', $class_mate['user_id'] ,'">', $class_mate['firstName'],' ', $class_mate['lastName'],'\'s Profile</a></h3>
                                <p><a href="albums.php?user_id=', $class_mate['user_id'] ,'">', $class_mate['firstName'],'\'s albums </a></p>
                                <p><a href="blog.php?user_id=', $class_mate['user_id'] ,'">', $class_mate['firstName'],'\'s blog </a></p>
                                </hgroup>,

                                ';
                        ?>
                        </article>
                        <?php
                    }      
                }
            ?>
	</article>
	
        <article class="transparent" id="myBlog_preview">
            <?php echo '
            <h2><a href="blog.php?user_id=', $user_id,'"/>My Lastest Blog Posts</a></h2>
            <br/>
            ';
            ?>
            <?php
            $blog_posts = get_latest_blog_posts($user_id);

            if (empty ($blog_posts)){
                echo '
                    <article id="blog_album_page">
                        <h2>You don\'t have any blog posts yet.</h2>
                    </article>
                ';
                } else {
                    foreach ($blog_posts as $blog_post){
                        ?>                    
                        <article>
                            <?php

                            echo '
                                <hgroup>
                                <h2><a href="view_blog_post.php?post_id=', $blog_post['post_id'] ,'">', $blog_post['title'], '</a></h2>
                                </hgroup>

                                    <p>', nl2br(substr($blog_post['content'],0,50)) ,'....... <br><br><b><a href="view_blog_post.php?post_id=', $blog_post['post_id'] ,'">Continue Reading....</a></b></p><br /> 
                                        
                                <footer>
                                        <p align="right"><b>Posted on '. date('D M Y / h:m', $blog_post['timestamp']).'</b></p>
                                </footer>
                                ';
                        ?>
                        </article>
                        <?php
                    }                                        
                }
            ?>
        </article>
    </section>
<?php
include 'template/footer.php';
?>

<?php
include 'init.php';

if(!logged_in()){
    header('Location: index.php');
    exit;
}

include 'template/header.php';
?>

<section id="main_section">
    <?php
    $user_id = $_GET['user_id'];
    $user_data = get_user_data($user_id);

    $news_items = get_news_items(10);
    print_r($news_items);
      
    if (empty ($news_items)){
        echo '
            <article id="blog_album_page">
                <h2>No one in on your course has posted anything yet.</h2>
            </article>
        ';
        } else {
            foreach ($news_items as $news_item){
                
                ?>                    
                <article id="blog_album_page">
                    <?php

                    echo $news_item['title'], $news_item['timestamp'];
                ?>
                </article>
                <?php
            }                                        
        }            

    ?>
</section>
<?php
include 'widgets/photo_options.php';
include 'template/footer.php';
?>
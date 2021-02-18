<?php 
get_header();

while (have_posts()) {
the_post(); 
pageBanner();
?>

  <div class="container container--narrow page-section">

    <div class="generic-content">
    <div class="row group"> 

    <div class="one-third">
    <?php the_post_thumbnail('cooksPortrait'); ?></div>

    <div class="two-thirds">
    <?php 
    $likeCount = new WP_Query(array(
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'liked_cook_id',
          'compare' => '=',
          'value' => get_the_ID()
         )
      )
    )); 
    
    $existStatus = 'no';

    if (is_user_logged_in()){
      $existQuery = new WP_Query(array(
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_cook_id',
            'compare' => '=',
            'value' => get_the_ID()
           )
        )
      ));
      if ($existQuery->found_posts){
        $existStatus = 'yes';
      }
    }

   


    ?>
    <span class="like-box" data-like="<?php echo $existQuery->posts[0]->ID;?>" data-cooks="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">
    <i class="fa fa-heart-o" aria-hidden="true"> </i>
    <i class="fa fa-heart" aria-hidden="true"> </i>
     <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
    </span>
    <?php the_content(); ?>
    </div>

    </div>
    </div>

    <?php 
    
    $relatedareas = get_field('areas'); 

    if ($relatedareas){
      echo '<ul class="link-list min-list">';
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Areas operating</h2>'; ?>

    <?php foreach($relatedareas as $areas){ ?>

    <li><a href="<?php echo get_the_permalink($areas); ?>"><?php echo get_the_title($areas); ?></a></li>
    <?php }
    echo '</ul>';
   }
 }

get_footer();
?>

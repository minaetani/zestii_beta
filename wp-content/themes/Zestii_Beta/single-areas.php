<?php 
get_header();

while (have_posts()) {
the_post(); 
pageBanner();
?>

<div class="container container--narrow page-section">

  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('areas') ?>"><i class="fa fa-home" aria-hidden="true"></i> Areas Home </a><span class="metabox__main"> <?php the_title(); ?></span></p>
  </div>

  <div class="generic-content"><?php the_field('main_body_content'); ?></div> 
   
    <?php 
    $relatedCooks = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'cooks',
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'areas',
        'compare' => 'LIKE' ,
        'value' => '"' . get_the_ID(). '"'
      )
    )
    ));

    if ($relatedCooks->have_posts()){

    echo '<hr class="section-break">';
    echo '<h2 class="headline headline--medium">Cooks in ' . get_the_title() . '</h2>';

    echo '<ul class="professor-cards">';
    while($relatedCooks -> have_posts()){
      $relatedCooks -> the_post();?>
      <li　class="professor-card__list-item" >
      <a class="professor-card" href="<?php the_permalink(); ?>">
      <img class="professor-card__image" src="<?php the_post_thumbnail_url('cooksLandscape') ?>">
      <span class="professor-card__name"><?php the_title(); ?></span>
      </a></li>
        <?php }
    echo'</ul>';

    }
    wp_reset_postdata();
   
    $relatedpickuppoint = get_field('related_pickup_point');

    if ($relatedpickuppoint){

    echo  '<hr class="section-break">';
    echo  '<h2 class="headline headline--medium">Pickup points in '. get_the_title() .'</h2>';
    
    echo '<ul class="min-list link-list">';
      foreach($relatedpickuppoint as $pickuppoints){
        ?> <li><a href="<?php echo get_the_permalink($pickuppoints); ?>"><?php echo get_the_title($pickuppoints)?></a></li>
      <?php 
      }
    echo '</ul>'; 
  } 
  
  ?>
</div>

<?php }
get_footer();
?>
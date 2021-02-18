<?php 
get_header();

while (have_posts()) {
the_post(); 
pageBanner();
?>

<div class="container container--narrow page-section"> 
  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('locations'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Locations Home </a><span class="metabox__main"> <?php the_title(); ?></span></p>
  </div>

  <div class="generic-content"><?php the_content(); ?> 
    <div class="acf-map"> 
      <?php $maplocation = get_field('location_on_map');?>
      <div class="marker" data-lat="<?php echo $maplocation['lat'] ?>" data-lng="<?php echo $maplocation['lng'] ?>">
      <h3><?php the_title(); ?></h3>
      <?php echo $maplocation['address']; ?>
    </div>
  </div>

  
    <?php 
      $relatedCooks = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'cooks',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'related_pickup_point',
          'compare' => 'LIKE' ,
          'value' => '"' . get_the_ID(). '"'
            )
          )
          ));

          if ($relatedCooks->have_posts()){

          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium">Cooks serving at this location</h2>';

          echo '<ul class="professor-cards">';
          while($relatedCooks -> have_posts()){
            $relatedCooks -> the_post();?>
            <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php the_post_thumbnail_url('cooksLandscape') ?>">
            <span class="professor-card__name"><?php the_title(); ?></span>
            </a>
              <?php }
          echo'</ul>';
          }

        wp_reset_postdata(); ?>


</div>

<?php }
get_footer();
?>

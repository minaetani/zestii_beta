<?php 
get_header();

while (have_posts()) {
the_post(); 
pageBanner();

?> 

  <div class="container container--narrow page-section">

<?php 
$parentpage = wp_get_post_parent_ID(get_the_ID());
if ($parentpage) { ?>
<div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($parentpage); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentpage); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
<?php 
} ?>

<?php 
$testarray = get_pages (array(
    'child_of' => get_the_ID()
));
 if ($parentpage or $testarray) { ?>

    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($parentpage); ?>"><?php echo get_the_title();?></a></h2>
      <ul class="min-list">
          <?php 
          if ($parentpage){
              $findchildrenof = $parentpage;} 
              else  {$findchildrenof = get_the_ID();}
          wp_list_pages(array (
              'title_li' => NULL,
              'child_of' => $findchildrenof
              
          ));
          ?>
      </ul>
    </div>

        <?php } ?>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>
  </div>

<?php } get_footer(); ?>
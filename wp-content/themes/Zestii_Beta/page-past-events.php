<?php 
get_header();
pageBanner(array(
  'title' => get_the_title(),
  'subtitle'=> 'Memory of our cool events'
));
?>

<!-- **Php function the_archive_title pulls out archives by author, date and category.
If you want to create you own archive labelling, use if statement + old workpress functions as follows: 
     if(is_category()) { single_cat_tite(); }
     if(is_author()) { echo 'Posts by'; the_author(); } 
       ?> 
 -->

  <div class="container container--narrow page-section">

<?php
$today = date('Ymd');
$pastEvents = new WP_Query(array(
'paged' => get_query_var('paged', 1),
'post_type' => 'event',
'meta_key' => 'event_date',
'orderby' => 'meta_value_num',
'order' => 'ASC',
'meta_query' => array(
  array(
    'key' => 'event_date',
    'compare' => '<' ,
    'value' => $today,
    'type' => 'numeric'
  )
)

));

while($pastEvents->have_posts()) {
    $pastEvents->the_post(); 
    get_template_part('TemplateParts/content','event');
     }
 echo paginate_links(array(
  'total' => $pastEvents->max_num_pages   
 ));

?>

<?php
get_footer();


?>
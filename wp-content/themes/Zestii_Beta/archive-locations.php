<?php 
get_header();
pageBanner(array(
  'title' => 'Our pick up points',
  'subtitle' => 'Find your nearby pickup spots!')
);
?>

<!-- 
  Archiveページ(各ポストタイプの一覧表示用ホーム)はwordpressadminにデータがないので、pageBannerファンクションの後ろにarrayでタイトルやサブタイトルなどの要素を指定する。
  **Php function the_archive_title pulls out archives by author, date and category.
If you want to create you own archive labelling, use if statement + old workpress functions as follows: 
     if(is_category()) { single_cat_tite(); }
     if(is_author()) { echo 'Posts by'; the_author(); } 
       ?> 
 -->
    
  <div class="container container--narrow page-section">

<div class="acf-map"> 

<?php
while(have_posts()) {
 the_post(); 
 $maplocation = get_field('location_on_map');
 ?>
<div class="marker" data-lat="<?php echo $maplocation['lat'] ?>" data-lng="<?php echo $maplocation['lng'] ?>">
<h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
<?php echo $maplocation['address']; ?>
</div>
<?php }?>

</div>

<?php
get_footer();


?>

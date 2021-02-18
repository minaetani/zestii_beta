<?php 
get_header();
pageBanner(array(
  'title' => 'Areas',
  'subtitle' => 'Where Zestii operates')
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

<ul class="link-list min-list" > 

<?php
while(have_posts()) {
 the_post(); ?>
<li><a href= <?php the_permalink();?>><?php the_title(); ?></a></li>
<?php }
 echo paginate_links();
?>

</ul>

<?php
get_footer();


?>
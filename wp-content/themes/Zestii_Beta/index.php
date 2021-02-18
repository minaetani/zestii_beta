<?php 
get_header();
pageBanner(array(
  'title' => 'Welcome to our blog!',
  'subtitle'=> 'Keep up our latest news!'
));
?>

<!--   Archiveページ(各ポストタイプの一覧表示用ホーム)はwordpressadminにデータがないので、pageBannerファンクションの後ろにarrayでタイトルやサブタイトルなどの要素を指定する。archiveはブログのカテゴリ別一覧、indexはブログの全カテゴリの一覧。**Php function the_archive_title pulls out archives by author, date and category.
If you want to create you own archive labelling, use if statement + old workpress functions as follows: 
     if(is_category()) { single_cat_tite(); }
     if(is_author()) { echo 'Posts by'; the_author(); } 
       ?> 
 -->


  <div class="container container--narrow page-section">
<?php
while(have_posts()) {
 the_post(); ?>
<div class="post-item">
<h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>

<div class="metabox">
  <p>Posted by <?php the_author_posts_link();?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?> </p>
</div>

<div class="generic-content">
<?php the_excerpt(); ?>
<p><a class="btn btn--blue" href="<?php the_permalink();?>"> Continue Reading &raquo;</a></p>
</div>

<div>

</div>

</div>
<?php }
 echo paginate_links();

?>

<?php
get_footer();


?>
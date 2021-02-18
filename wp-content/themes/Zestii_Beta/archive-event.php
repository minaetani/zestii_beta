<?php 
get_header();
pageBanner(array(
  'title' => 'Events',
  'subtitle' => 'What&#39s up with Zestii Cooks?' 
));
?>

<!--  Archiveページ(各ポストタイプの一覧表示用ホーム)はwordpressadminにデータがないので、pageBannerファンクションの後ろにarrayでタイトルやサブタイトルなどの要素を指定する。 
  **Php function the_archive_title pulls out archives by author, date and category.
If you want to create you own archive labelling, use if statement + old workpress functions as follows: 
     if(is_category()) { single_cat_tite(); }
     if(is_author()) { echo 'Posts by'; the_author(); } 
       ?> 
 -->
  

  <div class="container container--narrow page-section">
<?php
while(have_posts()) {
 the_post();
 get_template_part('TemplateParts/content','event'); 

}
 echo paginate_links();
?>

<hr class="section-break">
<p><a href= "<?php echo site_url('/past-events')?>">Check out our past events here!</a></p>

<?php
get_footer();


?>
<?php 

//()内で指定したパスのファイルからデータを読み込む。
require get_theme_file_path('/includes/like-route.php');
require get_theme_file_path('/includes/search-route.php');

 function zestii_custom_rest(){
   register_rest_field('post', 'authorName', array(
    'get_callback' => function(){return get_the_author();} 
   ));

   register_rest_field('menu', 'userMenuCount', array(
    'get_callback' => function() {return count_user_posts(get_current_user_id(),'menu');} 
   ));

  } 


 add_action('rest_api_init', 'zestii_custom_rest');

/* add_actionは2つのargumentをとるwordpressのfunction. argumentは呼び出したいworpressのeventと、そのevent中に呼び出したいfunctionの名前。add_actionの前に呼び出したいfunctionの内容を設定する。wordpressのfunction  register_rest_fielsはargumentを3つとる。ひとつ目はカスタマイズしたいpost type、2つ目は新しく追加・カスタマイズするフィールドに名前をつける、3つ目はデータのarray(上記の例の場合には'phpでauthor名を取りに行き、返す'をfunctionとして、それをget_callbackで呼び出す。functionのクローズ}の前にregister_rest_fieldを追加することで、他のポストタイプにphpで呼び出せるデータならなんでも呼び出して返すことができるようになる。phpとjsの組み合わせ。rest APIのURLにとび、postmanでみやすくしたデータ列で確認すると、上記の設定結果が反映されているのがわかる。このjsonデータをフロントエンドに反映させるには、jsファイルにゆきget resultsのtemplate literalの中に${item.authorName(追加したデータの名前)}を加えるternary operatorで条件分岐を付け加えることもできる。*/

function pageBanner($args = NULL){
  if(!$args['title']){
    $args['title'] = get_the_title();
  }

  if(!$args['subtitle']){
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
    
  if(!$args['bkgd-photo']){
    if (get_field('page_banner_bkgd_image' AND !is_archive() AND !is_home())) {    
        $args['bkgd-photo'] = get_field('page_banner_bkgd_image')['sizes']['pageBanner'];
    } else {
        $args['bkgd-photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }

/*ここでphp logicを設定[各テンプレート.phpページの$argsの中で各'parameter'が規定されている場合にはそれを、ない場合にはwordpressの投稿に紐づいている同'parameter'を呼び出す。'parameter'がカスタムフィールドで設定されているものの場合にはget_fieldでそのなかの何を呼び出すか指定。バナー背景画像は、テンプレでの指定なし→カスタムフィールドでの指定画像→それもない場合はtheme fileのフォルダ内の画像urlを指定]　　→　各ページ、generic posts、custom post typesのtemplateのトップではpageBanner function を呼び出すだけ。 */

?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php 
    echo ($args)['bkgd-photo'] ?>);"></div>
    <div class="page-banner__content container container--narrow">
     <h1 class="page-banner__title"><?php echo $args['title'] ?> </h1>
     <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>  
  </div>
<?php
}

function Zestii_Fashions() {
    wp_enqueue_style('Fonts','//fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700;900&display=swap" rel="stylesheet');
    wp_enqueue_style('social-icons','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); 

    wp_enqueue_script('GoogleMap','//maps.googleapis.com/maps/api/js?key=AIzaSyAwIHGskmNgE4SE_g1OV-6JcFHQO7QOigA', NULL,'1.0', true); 

    if(strstr($_SERVER['SERVER_NAME'],'zerobasezestii.local')){
        wp_enqueue_script('MainZestii-js','http://localhost:3000/bundled.js', NULL,'1.0', true);
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.1d271ae7c90d0653fd77.js'), NULL,'1.0', true);
        wp_enqueue_script('MainZestii-js', get_theme_file_uri('/bundled-assets/scripts.15055106587cfb958e34.js'), NULL,'1.0', true);
        wp_enqueue_style('Zestii-main-styles', get_theme_file_uri('/bundled-assets/styles.15055106587cfb958e34.css'));
    }
    
  wp_localize_script('MainZestii-js','zestiiData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}
/*wp_localise_scriptはjsのコードをhtmlのソースに読み込ませる。3 argumentsをとる 1: flexibleにしたいメインのjsファイルの名称　2：variableの名前 3: 使いたいjsデータをassociative arrayで入力*/

add_action('wp_enqueue_scripts','Zestii_Fashions');

function Zestii_features(){
    register_nav_menu('headerMenu','Header Menu Location');
    register_nav_menu('footerMenu-1','Footer Menu Location1');
    register_nav_menu('footerrMenu-2','Footer Menu Location2');
    add_theme_support('title_tag'); 
    add_theme_support('post-thumbnails');
    add_image_size('cooksLandscape', 400, 260, true);
    add_image_size('cooksPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
} 

// ↑にadd_theme_supportするだけではdefaultのblog postにしか適用されないため、custom post typesに適用するにはmu-plugin フォルダの各post typeの 'support’のarrayに'thumbnail'を追加する。add_image_sizeはargumentsに、名前、ピクセルサイズ横、ピクセルサイズ縦、クロップするかしないか（する=true, しない＝false。クロップはデフォルトではしない設定。クロップする場合には画像の真ん中を中心に切り取られる。切り取り位置を指定したい場合は、true/falseの部分にarrayでleft right top などのargumentを設定することができる。が、一つ一つ設定するの面倒なので、manual crop のpluginを使用する。このfunctionは設定をした後にアップロードした画像には適用されるが、retroactivelyには自動で画像生成してくれないため、regenerate thumbnailsのプラグインをインストールする// 

add_action ('after_setup_theme','Zestii_features');

function Zestii_adjust_queries($query){
  if (!is_admin() AND is_post_type_archive('locations') AND $query->is_main_query()){
    $query->set('posts_per_page', -1); 
 }

   if (!is_admin() AND is_post_type_archive('areas') AND $query->is_main_query()){
   $query->set('orderby','title');
   $query->set('order', 'ASC'); 
   $query->set('posts_per_page', -1); 
}

   if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
    $today = date('Ymd');
    $query->set('meta_key', 'event_date'); 
    $query->set('orderby', 'meta_value_num'); 
    $query->set('order', 'ASC'); 
    $query->set('meta_query', array(
        array(
            'key' => 'event_date',
            'compare' => '>=' ,
            'value' => $today,
            'type' => 'numeric'
        )));
}
}

add_action('pre_get_posts', 'Zestii_adjust_queries');

function ZestiilocationMapKey($api){
  $api['key'] = 'AIzaSyAwIHGskmNgE4SE_g1OV-6JcFHQO7QOigA';
  return $api;
}
add_filter('acf/fields/google_map/api','ZestiilocationMapKey');

//redirect subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend(){
$ourCurrentUser = wp_get_current_user();
  if(count($ourCurrentUser->roles) ==1 AND $ourCurrentUser->roles[0] == 'subscriber'){
    wp_redirect(site_url('/'));
    exit;
  }
}
//hiding admin bar from the top of the view when subscribers are logged in to website
add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar(){
$ourCurrentUser = wp_get_current_user();
  if(count($ourCurrentUser->roles) ==1 AND $ourCurrentUser->roles[0] == 'subscriber'){
   show_admin_bar(false);
  }
}

//customise login screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
  return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts','ourLoginCSS');

function ourLoginCSS(){
  wp_enqueue_style('Fonts','//fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700;900&display=swap" rel="stylesheet');
  wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.15055106587cfb958e34.css'));
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle(){
  return get_bloginfo('name');
}

//Force 'menu' posts to be private
add_filter('wp_insert_post_data', 'makeMenuPrivate',10, 2);

function makeMenuPrivate($data, $postarr){
  if($data['post_type']=='menu'){
    if(count_user_posts(get_current_user_id(),'menu') > 4 AND !$postarr['ID']){
      die("You have reached your menu post limit.");
    }
    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }
  if ($data['post_type'] == 'menu' AND $data['post_status'] != 'trash'){
    $data['post_status'] = "private";
  }
  return $data;
}

//all in one migrationのPluginで不要なファイルをエクスポートデータから外す方法
add_filter('ai1wm_exclude_content_from_export', 'ignoreCertainFiles');

function ignoreCertainFiles ($exclude_filters) {
  $exclude_filters[] = 'themes/ZestiiBeta/node_module';
  return $exclude_filters;
}

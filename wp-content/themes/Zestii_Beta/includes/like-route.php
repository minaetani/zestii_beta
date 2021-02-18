<?php 

//(name of the wordpress function we want to hook onto(add custom route or new field to custom route), name of the function)
add_action('rest_api_init', 'zestiiLikeRoutes');

/*wp function 'register_rest_route'は3つのargumentをとる。1つ目はnamespace -> /wp-json/wp/v2/post　rest API URLの/wp/に当たる部分。/wp/はワードプレスのコア、ここにunique nameをあてることができる。pluginと被らないようにわかりやすいネーミングを/の後ろにv1..v2をつけてバージョン管理する。2つ目はroute。URLの最後につくpostやpageの部分。3つ目はarrayでこのURLに来た時に起こるべきイベントを設定する。
methodsのWP_REST_SERVERは汎用性があり安全。'GET'のみで良い場合もある。callbackでfunctionの名前を決める。*/

//methodsはこのrouteで使うhttpsリクエストのタイプ 、callbackはリクエストが送られた際に実行したいfunction

function zestiiLikeRoutes(){
    register_rest_route('zestii/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike'
    ));

    register_rest_route('zestii/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
    ));

}

//このfunctionで実行したいことをなんでも指定できる。wp_insert_postはarrayで指定した内容のポストを作成することができる。

function createLike ($data){
    if(is_user_logged_in()){
        $cooks = sanitize_text_field($data['cookId']);
   
    $existQuery = new WP_Query(array(
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_cook_id',
            'compare' => '=',
            'value' => $cooks
           )
        )
      ));
 
//if 'like' does not already exist, create new like post, else cancel current request
         
    if($existQuery->found_posts == 0 AND get_post_type($cooks) == 'cooks'){
        return wp_insert_post (array(
            'post_type' => 'like',
            'post_status' => 'publish',
            'post_title' => 'Liked this cook!',
            'meta_input' => array(
                'liked_cook_id' => $cooks
            )    
           ));
     } else {
         die("Invalid cook ID. You already liked this cook");
     }
       
    } else {
        die("You need to create an account and be logged in.");
    }

}

function deleteLike ($data){
    $likeId = sanitize_text_field($data['like']);
    if(get_current_user_id()== get_post_field('post_author',$likeId) AND get_post_type($likeId)== 'like'){
    wp_delete_post($likeID, true);
    return 'congrats, like deleted.';
} else {
    die("You do not have permission to delete like.");
}
}
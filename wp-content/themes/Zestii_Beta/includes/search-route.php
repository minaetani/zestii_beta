<?php 

/*このファイルはカスタマイズされたデータの呼び出しと返を行う、カスタムAPI　URLを設定するもの*/

add_action('rest_api_init','zestiiRegisterSearch');

/*wp function 'register_rest_route'は3つのargumentをとる。1つ目はnamespace -> /wp-json/wp/v2/post　rest API URLの/wp/に当たる部分。/wp/はワードプレスのコア、ここにunique nameをあてることができる。pluginと被らないようにわかりやすいネーミングを/の後ろにv1..v2をつけてバージョン管理する。2つ目はroute。URLの最後につくpostやpageの部分。3つ目はarrayでこのURLに来た時に起こるべきイベントを設定する。
methodsのWP_REST_SERVERは汎用性があり安全。'GET'のみで良い場合もある。callbackでfunctionの名前を決める。*/

function zestiiRegisterSearch (){
    register_rest_route('zestii/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'zestiiSearchResults'
    ));
}

/* WP_Query は()にどのポストを探しているのかのarrayのオプションを与える。new WP Queryで設定したvariable をループする。続く行でどのデータを抜き出したいかのvariableをarrayで設定し、そのvariableをreturnで返す*/

function zestiiSearchResults($data) {
    $searchQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'cooks', 'areas', 'locations', 'event'),
        's' => sanitize_text_field($data['term'])
    ));
 /* 's'はsearch 、sanitize_text_fieldはセキュリティ。'post_type のarrayの中にpost typeを複数指定すると、指定したタイプが全て検索対象になる*/

    $searchQueryResults = array(
        'fromBlogsAndPages' => array(),
        'cooks' => array(), 
        'areas' => array(),
        'event' => array(),
        'locations' => array()
    );

    while($searchQuery->have_posts()){
        $searchQuery->the_post();

        if(get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($searchQueryResults['fromBlogsAndPages'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
                ));
        }
        
        if(get_post_type() == 'cooks') {
            array_push($searchQueryResults['cooks'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0,'cooksLandscape')
                ));
        }

        if(get_post_type() == 'event') {
            $EventDate = new DateTime(get_field('event_date'));
            $description = null ;
            if (has_excerpt()){
                $description == get_the_excerpt();
            } else { 
                $description == wp_trim_words(get_the_content(),18);}
            
            array_push($searchQueryResults['event'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $EventDate->format('M'),
                'day' => $EventDate->format('d'),
                'description' =>  $description
                ));
        }

        if(get_post_type() == 'areas') {
            $relatedLocations = get_field('related_pickup_point');

            if($relatedLocations){
                foreach($relatedLocations as $locations){
                    array_push($searchQueryResults['locations'],array(
                    'title' => get_the_title($locations),
                    'permalink' => get_the_permalink($locations)
                    ));
                }
            }
            

            array_push($searchQueryResults['areas'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_id()
                ));
        }


        if(get_post_type() == 'locations') {
            array_push($searchQueryResults['locations'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
                ));
        }
    }

/* 該当するポストがあった場合に指定したデータをpushして返す。その際、データをポストタイプべつに仕分けして返す*/  

if($searchQueryResults['areas']){
    $areasMetaQuery =array('relation' => 'OR');

    foreach($searchQueryResults['areas'] as $item){
        array_push($areasMetaQuery,  array(
            'key' => 'related_areas',
            'compare' => 'LIKE',
            'value' => '"'. $item['id'].'"'
        ));
    }
    
    $areasRelationshipQuery = new WP_Query(array(
     'post_type' => array('cooks','event'),
     'meta_query' => $areasMetaQuery
    ));
    
    while($areasRelationshipQuery -> have_posts()){
        $areasRelationshipQuery->the_post();
    
        if(get_post_type() == 'event') {
            $EventDate = new DateTime(get_field('event_date'));
            $description = null ;
            if (has_excerpt()){
                $description == get_the_excerpt();
            } else { 
                $description == wp_trim_words(get_the_content(),18);}
                
            array_push($searchQueryResults['events'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $EventDate->format('M'),
                'day' => $EventDate->format('d'),
                'description' =>  $description
                ));
        }


        if(get_post_type() == 'cook') {
            array_push($searchQueryResults['cooks'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0,'cooksLandscape')
                ));
            }
    }
    
    $searchQueryResults['cooks'] =array_values(array_unique($searchQueryResults['cooks'], SORT_REGULAR));    

    $searchQueryResults['events'] =array_values(array_unique($searchQueryResults['events'], SORT_REGULAR));   

} 
    

    return $searchQueryResults;
    
}



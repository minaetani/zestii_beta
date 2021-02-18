<?php 

function Zestii_post_types(){
 // Location post type - cumpuses in the course
 register_post_type('locations', array(
    'capability_type' => 'locations',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array ('title','editor','excerpt'),
    'rewrite' => array ('slug' => 'locations'),
    'has_archive' => true,
    'public' => true,
 'labels' => array(
     'name' => 'Location',
     'add_new_item' => 'Add New Location',
     'edit_item' => 'Edit Locations',
     'all_items' => 'Locations',
     'singular_name' => 'Location' 
 ),
 'menu_icon' => 'dashicons-pressthis'

 ));     
    /* Events post type 
    capability typeで投稿できるポストタイプの制限を設定できる。デフォルトは'post'で
    'post’にはカスタムポストタイプの投稿も含まれる。より詳細なポストタイプを指定することで
    権限を制限できる。
    */
    register_post_type('event', array(
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array ('title','editor','excerpt'),
    'rewrite' => array ('slug' => 'events'),
    'has_archive' => true,
    'public' => true,
 'labels' => array(
     'name' => 'Events',
     'add_new_item' => 'Add New Events',
     'edit_item' => 'Edit Events',
     'all_items' => 'Events',
     'singular_name' => 'Event' 
 ),
 'menu_icon' => 'dashicons-calendar-alt'

 ));     
// Areas post type - Programmes in the course 'supports'の中の'editor'を消すとデフォルトのテキスト入力欄を非表示にできる。
 register_post_type('areas', array(
    'show_in_rest' => true,
    'supports' => array ('title'),
    'rewrite' => array ('slug' => 'areas'),
    'has_archive' => true,
    'public' => true,
 'labels' => array(
     'name' => 'Areas',
     'add_new_item' => 'Add New Areas',
     'edit_item' => 'Edit Areas',
     'all_items' => 'All Areas ',
     'singular_name' => 'Area' 
 ),
 'menu_icon' => 'dashicons-admin-site-alt3'

 ));     

// Cooks post type - Professors in the course.  'show_in_rest’をtrueに設定しておくと、rest APIのURLでjsonデータを読み込みできるようになる。defalut設定では、カスタムフィールドのポストのjsonデータは読み込まれない。
register_post_type('cooks', array(
    'show_in_rest' => true,
    'supports' => array ('title','editor', 'thumbnail'),
    'public' => true,
 'labels' => array(
     'name' => 'Cooks',
     'add_new_item' => 'Add New Cooks',
     'edit_item' => 'Edit Cooks',
     'all_items' => 'All Cooks ',
     'singular_name' => 'Cook' 
 ),
 'menu_icon' => 'dashicons-universal-access-alt'

 ));  

// 'rewrite' => array ('slug' => 'cooks'),'has_archive' => true, この2つはarchiveの一覧archive-homeが必要な場合のみ設定する

// My menu post type (my notes in the course)  'show_in_rest’をtrueに設定しておくと、rest APIのURLでjsonデータを読み込みできるようになる。defalut設定では、カスタムフィールドのポストのjsonデータは読み込まれない。
register_post_type('menu', array(
    'capability_type' => 'menu',
    'map_meta_cap' => true, 
    'show_in_rest' => true,
    'supports' => array ('title','editor'),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
     'name' => 'Menus',
     'add_new_item' => 'Add New Menus',
     'edit_item' => 'Edit Menus',
     'all_items' => 'All Menus ',
     'singular_name' => 'Menu' 
 ),
 'menu_icon' => 'dashicons-food'

 ));  

// Like function ー cook への"いいね"
register_post_type('like', array(
    'supports' => array ('title'),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
     'name' => 'Likes',
     'add_new_item' => 'Add New Likes',
     'edit_item' => 'Edit Likes',
     'all_items' => 'All Likes ',
     'singular_name' => 'Like' 
 ),
 'menu_icon' => 'dashicons-heart'

 ));  

}

add_action ('init','Zestii_post_types');
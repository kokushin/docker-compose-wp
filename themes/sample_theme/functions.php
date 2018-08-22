<?php
/**
 * sample_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sample_theme
 */

if ( ! function_exists( 'sample_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function sample_theme_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
    add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
    ) );
	}
endif;
add_action( 'after_setup_theme', 'sample_theme_setup' );


/**
 * jQuery, CSSの読み込み
 */
function sample_theme_style() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), NULL, true );
  wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'googlefonts', 'https://fonts.googleapis.com/css?family=Roboto' );
	wp_enqueue_style( 'sample_theme-style', get_template_directory_uri() .'/assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'sample_theme_style' );


/**
 * JavaScriptの読み込み
 */

function sample_theme_script() {
	wp_enqueue_script( 'sample_theme-lib-jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js', array() );
	wp_enqueue_script( 'sample_theme-script', get_template_directory_uri() .'/assets/js/common.js', array() );
}
add_action( 'wp_footer', 'sample_theme_script' );


/**
 * カスタム投稿タイプを設定
 */

function create_post_type() {
  register_post_type( 'member',
    array(
      'labels' => array(
        'name' => __( 'MEMBER' ),
        'singular_name' => __( 'MEMBER' )
      ),
      'menu_position' => 5,
      'public' => true,
      'has_archive' => false,
      'supports' => array( 'title', 'editor', 'thumbnail' ),
      'rewrite' => array('slug' => 'member', 'with_front' => false),
    )
  );
}
add_action( 'init', 'create_post_type' );


/**
 * 管理画面の「投稿」ラベルを「WORKS」に変更
 */

function change_post_menu_label() {
  global $menu;
  global $submenu;
  $menu[5][0] = 'WORKS';
  $submenu['edit.php'][5][0] = 'WORKS一覧';
  $submenu['edit.php'][10][0] = '新規追加';
  $submenu['edit.php'][16][0] = 'タグ';
}
function change_post_object_label() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'WORKS';
  $labels->singular_name = 'WORKS';
  $labels->add_new = _x('追加', 'WORKS');
  $labels->add_new_item = 'WORKSの新規追加';
  $labels->edit_item = 'WORKSの編集';
  $labels->new_item = '新規WORKS';
  $labels->view_item = 'WORKSを表示';
  $labels->search_items = 'WORKSを検索';
  $labels->not_found = '記事が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );


/**
 * ページごとのスラッグ名を出力
 */

function output_page_slug() {
  if (is_front_page()) {
    return 'top';
  } else {
    $page = get_post(get_the_ID());

    return $slug = $page->post_name;
  }
}

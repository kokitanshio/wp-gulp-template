<?php
/**
 * Functions
 */

/**
 * WordPress標準機能
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support
 */
function my_setup(){
// アイキャッチ画像を有効化
add_theme_support('post-thumbnails');
// 投稿とコメントのRSSフィードのリンクを有効化
add_theme_support('automatic-feed-links');
// タイトルタグ自動生成
add_theme_support('title-tag');
//HTML5でマークアップ
add_theme_support(
  'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}
add_action('after_setup_theme', 'my_setup');


/**
 * wp_head内不要な出力の削除
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/remove_action
 */
// バージョン表記削除
remove_action('wp_head', 'wp_generator');
// canonical情報削除
remove_action('wp_head', 'rel_canonical');
// Shortlink削除
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
// RSSフィードのURLの削除
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
// 前の記事、次の記事のリンク削除
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
// DNS Prefetchingの削除
remove_action('wp_head', 'wp_resource_hints', 2); //読み込み速度簡易高速化停止

// 外部ブログツールからの投稿を受け入れ削除
remove_action('wp_head', 'rsd_link'); //EditURI削除
remove_action('wp_head', 'wlwmanifest_link'); //wlwmanifest削除

// Embed機能の停止
remove_action('wp_head', 'rest_output_link_wp_head'); //REST APIのURL表示
remove_action('wp_head', 'wp_oembed_add_discovery_links'); //外部コンテンツの埋め込み
remove_action('wp_head', 'wp_oembed_add_host_js'); //外部コンテンツの埋め込み

// 絵文字利用の削除
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles', 10);

// Global Stylesのコード削除
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

// 最近のコメントウィジェット削除
function remove_wp_widget_recent_comments_style(){
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}
add_action('widgets_init', 'remove_wp_widget_recent_comments_style');


/**
 * 投稿画像サイズ設定
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_image_size
 */
add_image_size('$name', $width, $height, true);


/**
 * 抜粋機能の有効化
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_post_type_support
 */
add_post_type_support('page', 'excerpt');


/**
 * デフォルトのjQueryを読まない
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wp_deregister_script
 */
function my_delete_local_jquery(){
  wp_deregister_script('jquery');
}
add_action('wp_enqueue_scripts', 'my_delete_local_jquery');


/**
 * CSSの読み込み
 *
 * @codex https://wpdocs.osdn.jp/%E3%83%8A%E3%83%93%E3%82%B2%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC
 */
function my_styles(){
  //style.css 読み込み
  wp_enqueue_style('my', get_template_directory_uri().'assets/css/style.css', array(), '1.0.0', 'all');
}
add_action( 'wp_enqueue_scripts', 'my_styles' );


/**
 * JavaScriptの読み込み
 *
 * @codex https://wpdocs.osdn.jp/%E3%83%8A%E3%83%93%E3%82%B2%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC
 */
function my_scripts() {
  //jQuery読み込み
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js', array(), '1.0.0', true);
  //script.js 読み込み
  wp_enqueue_script('my', get_template_directory_uri().'assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'my_scripts' );


/**
 * メニューの登録
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_nav_menus
 */
function menu_init(){
  register_nav_menus(array(
    'header'=>'ヘッダーメニュー',
    'drawer'=>'ドロワーメニュー',
    'footer'=>'フッターメニュー',
  ));
}
add_action('init','menu_init');


/**
 * liのclass整理
 *
 */
// function my_css_attributes_filter($var) {
//     return is_array($var) ? array_intersect($var, array('current-menu-item', 'クラス名を記入')) : '';
// }
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);


/**
 * ウィジェットの登録
 *
 * @codex http://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_sidebar
 */
function my_widget_init(){
  register_sidebar(
    array(
      'name' => 'sidebar',
      'id' => 'sidebar',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
    )
  );
}
add_action('widgets_init', 'my_widget_init');


/**
 * 固定ページ一覧にスラッグを表示させる
 *
 * @developer.wordpress https://developer.wordpress.org/reference/hooks/manage_pages_columns/
 * @developer.wordpress https://developer.wordpress.org/reference/hooks/manage_pages_custom_columns/
 */
function add_page_column_title($columns)
{
  $columns['slug'] = "スラッグ";
  return $columns;
}
function add_page_column($column_name, $post_id)
{
  if ($column_name == 'slug') {
    $post = get_post($post_id);
    $slug = $post->post_name;
    echo esc_attr($slug);
  }
}
add_filter('manage_pages_columns', 'add_page_column_title');
add_action('manage_pages_custom_column', 'add_page_column', 10, 2);


/**
 * 投稿一覧にスラッグを表示させる
 *
 * @developer.wordpress https://developer.wordpress.org/reference/hooks/manage_posts_columns/
 * @developer.wordpress https://developer.wordpress.org/reference/hooks/manage_posts_custom_column/
 */
function add_post_column_title($columns)
{
  $columns['slug'] = "スラッグ";
  return $columns;
}
function add_post_column($column_name, $post_id)
{
  if ($column_name == 'slug') {
    $post = get_post($post_id);
    $slug = $post->post_name;
    echo esc_attr($slug);
  }
}
add_filter('manage_posts_columns', 'add_post_column_title');
add_action('manage_posts_custom_column', 'add_post_column', 10, 2);


/**
 * 管理画面不要メニュー削除 ※コメントアウトしたものは表示される
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/remove_menu_page
 */
function remove_menus()
{
  // remove_menu_page( 'index.php' ); //ダッシュボード
  // remove_menu_page( 'edit.php' ); //投稿メニュー
  // remove_menu_page( 'upload.php' ); //メディア
  // remove_menu_page( 'edit.php?post_type=page' ); //固定ページ
  remove_menu_page('edit-comments.php'); //コメントメニュー
  // remove_menu_page( 'themes.php' ); //外観メニュー
  // remove_menu_page( 'plugins.php' ); //プラグインメニュー
  // remove_menu_page( 'users.php' );  // ユーザー
  // remove_menu_page( 'edit.php?post_type=acf-field-group' ); //ACF
  // remove_menu_page( 'tools.php' ); //ツールメニュー
  // remove_menu_page( 'options-general.php' ); //設定メニュー
}
add_action('admin_menu', 'remove_menus');


/**
 * 【管理画面】投稿編集画面で不要な項目を非表示にする ※コメントアウトしたものは表示される
 *
 * @developer.wordpress https://developer.wordpress.org/reference/functions/remove_meta_box/
 */
function my_remove_meta_boxes()
{
  // remove_meta_box('postexcerpt', 'post', 'normal');      // 抜粋
  remove_meta_box('trackbacksdiv', 'post', 'normal');    // トラックバック
  // remove_meta_box('slugdiv', 'post', 'normal');           // スラッグ
  // remove_meta_box('postcustom', 'post', 'normal');       // カスタムフィールド
  remove_meta_box('commentsdiv', 'post', 'normal');      // コメント
  // remove_meta_box('submitdiv', 'post', 'normal');        // 公開
  // remove_meta_box('categorydiv', 'post', 'normal');       // カテゴリー
  // remove_meta_box('tagsdiv-post_tag', 'post', 'normal'); // タグ
  remove_meta_box('commentstatusdiv', 'post', 'normal'); // ディスカッション
  // remove_meta_box('authordiv', 'post', 'normal');        // 作成者
  remove_meta_box('revisionsdiv', 'post', 'normal');     // リビジョン
  // remove_meta_box('formatdiv', 'post', 'normal');        // フォーマット
  // remove_meta_box('pageparentdiv', 'post', 'normal');    // 属性
}
add_action('admin_menu', 'my_remove_meta_boxes');
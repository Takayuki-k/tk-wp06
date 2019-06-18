<?php
//wordpressフォーマット
include 'format/original_format.php';
include 'format/breadcrumbs_format.php';
include 'ogp/ogp_setting.php';

function thema_init(){
  // メインコンテンツの幅を指定
  if ( ! isset( $content_width ) ) $content_width = 960;

  // file読み込み
  function my_enqueue_scripts() {
    // style
    wp_enqueue_style('style', get_stylesheet_uri(), null);
    // bootstrap_css
    wp_enqueue_style( 'bootstrap_css', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', null, 'all' );
    // swiper_css
    wp_enqueue_style( 'swiper_css', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css', null, 'all' );
    //jquery cdnを出力
    wp_deregister_script( 'jquery' );
    wp_enqueue_script( 'jquery_cdn', '//code.jquery.com/jquery-3.4.1.min.js', array(), null, true );
    // popper_js
    wp_enqueue_script( 'popper_js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery_cdn'), null, true );
    // bootstrap_js
    wp_enqueue_script( 'bootstrap_js', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery_cdn'), null, true );
    // swiper_js
    wp_enqueue_script( 'swiper_js', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js', null, null, true );
    wp_enqueue_script( 'my_swiper', get_template_directory_uri().'/js/my_swiper.js', array('swiper_js'), null, true );
  }
  add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

  // 各スクリプト要素にハッシュ値と crossorigin="anonymous" を挿入する
  add_filter( 'style_loader_tag', 'add_attribs_to_scripts', 10, 3 );
  add_filter( 'script_loader_tag', 'add_attribs_to_scripts', 10, 3 );

  function add_attribs_to_scripts( $tag, $handle, $src ) {
    $jquery_cdn = array( 'jquery_cdn');
    $bootstrap_css = array( 'bootstrap_css');
    $swiper_css = array( 'swiper_css');
    $popper_js = array( 'popper_js');
    $bootstrap_js = array( 'bootstrap_js');
    $swiper_js = array( 'swiper_js');

    if ( in_array( $handle, $jquery_cdn ) ) {
      return '<script src="' . $src . '"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>' ."\n";
    }
    if ( in_array( $handle, $bootstrap_css ) ) {
      return '<link rel=stylesheet href="' . $src . '" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">' . "\n";
    }
    if ( in_array( $handle, $swiper_css ) ) {
      return '<link rel="stylesheet" href="' . $src . '" integrity="sha256-XwfUNXGiAjWyUGBhyXKdkRedMrizx1Ejqo/NReYNdUE=" crossorigin="anonymous">' . "\n";
    }
    if ( in_array( $handle, $popper_js ) ) {
      return '<script src="' . $src . '" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>' . "\n";
    }
    if ( in_array( $handle, $bootstrap_js ) ) {
      return '<script src="' . $src . '" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>' . "\n";
    }
    if ( in_array( $handle, $swiper_js ) ) {
      return '<script src="' . $src . '" integrity="sha256-uckMYBvIGtce2L5Vf/mwld5arpR5JuhAEeJyjPZSUKY=" crossorigin="anonymous"></script>' . "\n";
    }

    return $tag;
  }
  // 読み込み終わり


  // カスタムメニューを有効化
  add_theme_support( 'menus' );

  // カスタムメニューの「場所」を設定
  register_nav_menus( array(
    'header-navi' => 'ヘッダーのナビゲーション',
  ) );

  // サイドバーウィジットを有効化
  register_sidebar( array(
    'name'          => 'サイドバーウィジット',
    'id'            => 'sidebar',
    'description'   => 'サイドバーのウィジットエリアです。',
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
    'before_title' => '<p class="font-italic">',
    'after_title' => '</p>',
  ));

  //moreリンク
  function custom_content_more_link( $output ) {
    $output = preg_replace('/#more-[\d]+/i', '', $output );
    return $output;
  }
  add_filter( 'the_content_more_link', 'custom_content_more_link' );

  // 抜粋
  function new_excerpt_length($length) {
    return 100;
  }
  add_filter('excerpt_length', 'new_excerpt_length');
  function new_excerpt_more($more) {
    return '<a href="'. get_permalink($post->ID) . '" class="more-post">' . '記事を読む' . '</a>';
  }
  add_filter('excerpt_more', 'new_excerpt_more');

  //アイキャッチのサイズを固定化
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 600, 100, true );
  add_image_size( 'size', 320, 60, true );
  add_image_size( 'small_thumbnail', 60, 60, true );
  add_image_size( 'large_thumbnail', 150, 100, true );
  add_image_size( 'pickup_thumbnail', 620, 100, true );

  //アイキャッチ画像
  function thumbnail_check( $post_id, $size='post-thumbnail' ) {
    if ( has_post_thumbnail() ){
      $thumb = get_the_post_thumbnail( $post_id, $size );
    } else {
      $thumb = '<img src="https://placehold.jp/aaa/eee/600x100.jpg?text=lorem" class="attachment-post-thumbnail" alt="">';
    }
    echo $thumb;
  }

  //コメントフォーム
  remove_filter('comment_text', 'make_clickable', 9);
  add_filter('comments_open', 'custom_comment_tags');
  add_filter('pre_comment_approved', 'custom_comment_tags');
  function custom_comment_tags($data) {
      global $allowedtags;
      unset($allowedtags['a']);
      unset($allowedtags['abbr']);
      unset($allowedtags['acronym']);
      unset($allowedtags['div']);
      unset($allowedtags['cite']);
      unset($allowedtags['code']);
      unset($allowedtags['q']);
      unset($allowedtags['strike']);
      return $data;
  }

  //search.phpに特定の記事を検索結果に出さないように追記
  function fb_search_filter($query) {
    if ( !$query -> is_admin && $query -> is_search) {
      $query -> set('post__not_in', array() );
    }
    return $query;
  }
  add_filter( 'pre_get_posts', 'fb_search_filter' );


add_theme_support( 'custom-header' );

$custom_header_args = array(
  // デフォルトで表示するヘッダー画像(画像のURLを入力)
  'default-image' => get_template_directory_uri() . '/img/cafe--farmer01.jpg',
  // ヘッダー画像の横幅
  'width' => 0,
  // ヘッダー画像の縦幅
  'height' => 0,
  // ヘッダー画像の横幅を自由に切り取れるかどうか(trueもしくはfalse)
  'flex-width' => true,
  // ヘッダー画像の縦幅を自由に切り取れるかどうか(trueもしくはfalse)
  'flex-height' => true,
  // ヘッダーテキストを表示するかどうかを指定する機能の使うかどうか(trueもしくはfalse)
  'header-text' => false,
  // 動画ヘッダーに対応するかどうか(trueもしくはfalse)
  'video' => true,
  // adminへの画像ファイルのアップロードを許可するか(trueもしくはfalse)
  'uploads' => true,
  // ヘッダー画像をランダムにローテーションするかどうか(trueもしくはfalse)
  'random-default' => true,
  // テーマのheadタグ内に呼び出したいコードが書かれた関数を指定(関数名)
  'wp-head-callback' => 'wphead_cb',
  // カスタムヘッダーページのheadタグ内に呼び出したいコードが書かれた関数を指定(関数名)
  'admin-head-callback' => '',
  // カスタムヘッダーページのプレビュー部分に表示したいコードが書かれた関数を指定(関数名)
  'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $custom_header_args );

}
add_action('init', 'thema_init');

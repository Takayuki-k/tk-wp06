<?php
// 管理メニュー

function ogp_setting() {
  add_option('ogp'); // オプション追加
  add_action('admin_menu', 'option_menu_create');
  // 管理メニュー追加
  function option_menu_create() {
    add_theme_page('OGPセッティング', 'OGPセッティング', 'edit_themes', basename(__FILE__), 'option_page_create');
    // 外観メニューのサブメニューとして追加
  }
  function option_page_create() { // 設定ページ生成
    settings_fields( 'ttr_act' );
    do_settings_sections( 'ttr_act' );

    settings_fields( 'fb_app_id' );
    do_settings_sections( 'fb_app_id' );

    $saved = save_option();
    require TEMPLATEPATH.'/ogp/ogp_admin-menu.php';
  }
}

function save_option() { // オプション保存
  if( !is_null($_REQUEST['ttr_act']) ){
    $save = update_option('ttr_act', $_REQUEST['ttr_act']);
  };
  if( !is_null($_REQUEST['fb_app_id']) ){
    $save = update_option('fb_app_id', $_REQUEST['fb_app_id']);
  };
  return $save = null;
}
add_action('init', 'ogp_setting');

function genelate($label, $name ){
  echo $label;
  echo '<input type="text" name="'. $name .'" value="'. get_option($name) .'" ><br>';
  echo '::' . get_option($name) . '<br>';
}



/**
* OGPタグ
* OGPタグ
*・Twitterカード
*・Facebook
*/
function my_meta_ogp() {
  if (is_front_page() || is_home() || is_singular()) {

    if ( !has_post_thumbnail() ){
      $ogp_img = get_template_directory_uri() . '/img/large.png';
    } else {
      $thumb_id = get_post_thumbnail_id();
      $thumb_url = wp_get_attachment_image_src($thumb_id, 'post-thumbnail');
      $ogp_img = $thumb_url[0];
    }
    $ttr_act = get_option('ttr_act');
    $ttr_card = 'summary'; // summary_large_image || summary
    $fb_app_id = get_option('fb_app_id');

    global $post;
    $ogp_ttl = '';
    $ogp_descr = '';
    $ogp_url = '';
    $html = '';

    if (is_singular()) { // 記事＆固定ページ
      setup_postdata($post);
      $ogp_ttl = esc_attr($post->post_title);
      $ogp_descr = esc_attr(mb_substr(get_the_excerpt(), 0, 100));
      $ogp_url = esc_attr(get_permalink());
      wp_reset_postdata();
    } elseif (is_front_page() || is_home()) { // トップページ
      $ogp_ttl = esc_attr(get_bloginfo('name'));
      $ogp_descr = esc_attr(get_bloginfo('description'));
      $ogp_url = esc_attr(home_url());
    }

    // og:type
    $ogp_type = (is_front_page() || is_home()) ? 'website' : 'article';

    // 出力するOGPタグをまとめる
    $html .= '<meta property="og:title" content="' . $ogp_ttl . "\">\n";
    $html .= '<meta property="og:description" content="' . $ogp_descr . "\">\n";
    $html .= '<meta property="og:type" content="' . $ogp_type . "\">\n";
    $html .= '<meta property="og:url" content="' . $ogp_url . "\">\n";
    $html .= '<meta property="og:image" content="' . $ogp_img . "\">\n";
    $html .= '<meta property="og:site_name" content="' . $ogp_ttl . "\">\n";
    $html .= "<meta property=\"og:locale\" content=\"ja_JP\">\n";

    $html .= '<meta name="twitter:description" content="' . $ogp_descr . "\">\n";
    $html .= '<meta name="twitter:title" content="' . $ogp_ttl . "\">\n";
    $html .= '<meta name="twitter:url" content="' . $ogp_url . "\">\n";
    $html .= '<meta name="twitter:image" content="' . $ogp_img . "\">\n";
    $html .= '<meta name="twitter:card" content="' . $ttr_card . "\">\n";
    if ($ttr_act != "") {
      $html .= '<meta name="twitter:site" content="@' . $ttr_act . "\">\n";
    }
    if ($fb_app_id != "") {
      $html .= '<meta property="fb:app_id" content="' . $fb_app_id . "\">\n";
    }

    echo $html;

  }
}
add_action('wp_head', 'my_meta_ogp');

?>
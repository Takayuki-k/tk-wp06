<?php
function breadcrumbs(){
  global $post;
  $str ='';
  $pNum = 2;

  $str.= '<div id="breadcrumbs">';
  $str.= '<ul itemprop="Breadcrumb" itemscope itemtype="http://data-vocabulary.org/BreadcrumbList">';
  $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.home_url('/').'" class="home"><span itemprop="name">HOME</span></a><meta itemprop="position" content="1"></li>';

  //投稿ページ
  if(is_singular('post')){
    $categories = get_the_category($post->ID);
    $cat = $categories[0];

    if($cat->parent != 0){
      $ancestors = array_reverse(get_ancestors($cat->cat_ID, 'category'));
      foreach($ancestors as $ancestor){
        $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_category_link($ancestor).'"><span itemprop="name">'.get_cat_name($ancestor).'</span></a><meta itemprop="position" content="'.$pNum.'"></li>';
        $pNum++;
      }
    }
    $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_category_link($cat-> term_id). '"><span itemprop="name">'. $cat-> cat_name . '</span></a><meta itemprop="position" content="'.$pNum.'"></li>';
    $pNum++;
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.$post->post_title.'</span><meta itemprop="position" content="'.$pNum.'"></li>';
  }

  //カスタムポスト
  elseif(is_single() && !is_singular('post')){
    $cp_name = get_post_type_object(get_post_type())->label;
    $cp_url = home_url('/').get_post_type_object(get_post_type())->name;
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.$cp_url.'"><span itemprop="name">'.$cp_name.'</span></a><meta itemprop="position" content="2"></li>';
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.$post->post_title.'</span><meta itemprop="position" content="3"></li>';
  }

  /* 固定ページ */
  elseif(is_page()){
    $pNum = 2;
    if($post->post_parent != 0){
      $ancestors = array_reverse(get_post_ancestors($post->ID));
      foreach($ancestors as $ancestor){
        $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_permalink($ancestor).'"><span itemprop="name">'.get_the_title($ancestor).'</span></a><meta itemprop="position" content="'.$pNum.'"></li>';
        $pNum++;
      }
    }
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'. $post->post_title.'</span><meta itemprop="position" content="'.$pNum.'"></li>';
  }

  //カテゴリページ
  elseif(is_category()) {
    $cat = get_queried_object();
    $pNum = 2;
    if($cat->parent != 0){
      $ancestors = array_reverse(get_ancestors($cat->cat_ID, 'category'));
      foreach($ancestors as $ancestor){
        $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_category_link($ancestor) .'"><span itemprop="name">'.get_cat_name($ancestor).'</span></a><meta itemprop="position" content="'.$pNum.'"></li>';
      }
    }
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.$cat->name.'</span><meta itemprop="position" content="'.$pNum.'"></li>';
  }

  /* タグページ */
  elseif(is_tag()){
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'. single_tag_title( '' , false ). '</span><meta itemprop="position" content="2"></li>';
  }

  //アーカイブページ
  elseif(is_date()){

    if(get_query_var('day') != 0){
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_year_link(get_query_var('year')).'"><span itemprop="name">'.get_query_var('year').'年</span></a><meta itemprop="position" content="2"></li>';
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')).'"><span itemprop="name">'.get_query_var('monthnum').'月</span></a><meta itemprop="position" content="3"></li>';
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.get_query_var('day'). '</span>日<meta itemprop="position" content="4"></li>';
    } elseif(get_query_var('monthnum') != 0){
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'. get_year_link(get_query_var('year')).'"><span itemprop="name">'.get_query_var('year').'年</span></a><meta itemprop="position" content="2"></li>';
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.get_query_var('monthnum'). '</span>月<meta itemprop="position" content="3"></li>';
    } else {
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.get_query_var('year').'年</span><meta itemprop="position" content="2"></li>';
    }
  }

  //投稿者ページ
  elseif(is_author()){
    $str .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">投稿者 : '. get_the_author_meta('display_name', get_query_var('author')).'</span><meta itemprop="position" content="2"></li>';
  }

  //添付ファイルページ
  elseif(is_attachment()){
    $pNum = 2;
    if($post -> post_parent != 0 ){
      $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.get_permalink($post-> post_parent).'"><span itemprop="name">'.get_the_title($post->post_parent).'</span></a><meta itemprop="position" content="'.$pNum.'"></li>';
      $pNum++;
    }
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.$post->post_title.'</span><meta itemprop="position" content="'.$pNum.'"></li>';
  }

  //検索結果
  elseif(is_search()){
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">「'.get_search_query().'」で検索した結果</span><meta itemprop="position" content="2"></li>';
  }

  //404
  elseif(is_404()){
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">お探しの記事は見つかりませんでした。</span><meta itemprop="position" content="2"></li>';
  }

  //その他
  else{
    $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.wp_title('', false).'</span><meta itemprop="position" content="2"></li>';
  }

  $str.= '</ul>';
  $str.= '</div>';
  echo $str;
}
?>
<?php

/**
 * This KirbyText is for display the code of an file as a code block.
 *
 * Install
 * =======
 * Move this file to /site/tags/ and rename it code.php
 * 
 * @author: Thomas Fanninger <thomas@fanninger.at>
 * @version: 0.3
 */

// code tag
kirbytext::$tags['code'] = array(
  'attr' => array(
    'lang',
    'caption',
    'caption_top',
    'class'
  ),
  'html' => function($tag) {
    $code = '';
    $lang = $tag->attr('lang');
    $caption = $tag->attr('caption');
    $caption_top = $tag->attr('caption_top', true);

    $file     = $tag->file($tag->attr('code'));
    if($file){
      $code = $file->read();
    }

    $code = htmlspecialchars($code);
    $code = '<pre><code'.((!empty($lang))?' class="language-'.$lang.'"':'').'>'.$code.'</code></pre>';

    if(!empty($caption)){
      $figure = new Brick('figure');
      $figure->addClass($tag->attr('class'));
      if($caption_top)
        $figure->append('<figcaption>' . html($caption) . '</figcaption>');
      $figure->append($code);
      if(!$caption_top)
        $figure->append('<figcaption>' . html($caption) . '</figcaption>');
      return $figure;
    }else{
      return $code;
    }
  }
);
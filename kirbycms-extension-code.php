<?php

use at\fanninger\kirby\extension\webhelper\WebHelper;
use at\fanninger\kirby\extension\codeext\CodeExt;

require_once 'kirbycms-extension-code-lib.php';

kirbytext::$pre[] = function($kirbytext, $value) {
	$offset = 0;
	$key = 'code';
	while ( ($block = WebHelper::getblock($key, $value, $offset)) !== false ) {		
		$offset = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS];
		
		$file = ( array_key_exists('code', $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) )? $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]['code'] : false;
		$code = ( !empty($block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT]) )? $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT] : false;
		$lang = ( array_key_exists('lang', $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) )? $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]['lang'] : false;
		$caption = ( array_key_exists('caption', $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) )? $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]['caption'] : false;
		$caption_top = ( array_key_exists('caption_top', $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) )? $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]['caption_top'] : true;
		$caption_class = ( array_key_exists('caption_top', $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) )? $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]['caption_class'] : false;
		
		// Correction of the input
		if ( empty($file) )
			$file = false;
		else
			$file = $kirbytext->field->page->file ( $file );
		if ( empty($lang) )
			$lang = false;
		if ( empty($caption) )
			$caption = false;
		if ( empty($caption_top) || $caption_top !== true || $caption_top !== false )
			$caption_top =true;
		if ( empty($caption_class) )
			$caption_class = "code-figure";
		else
			$caption_class = "code-figure ".$caption_class;
		
		if ( $file !== false )
			$block_new = CodeExt::getCodeBlockFromFile($file, $lang, $caption, $caption_top, $caption_class);
		elseif ( $block[WebHelper::BLOCK_ARRAY_VALUE_TYPE] === WebHelper::BLOCK_TYPE_COMPLEX && $code !== false )
			$block_new = CodeExt::getCodeBlock($code, $lang, $caption, $caption_top, $caption_class);
	  else
	  	continue;
	  
		$start = $block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
		$length = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS]-$block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
	  
		$value = substr_replace($value, $block_new, $start, $length);
	}
	
	return $value;
};
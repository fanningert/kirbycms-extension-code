<?php

/**
 * This KirbyText is for display the code of an file as a code block.
 * 
 * @author: Thomas Fanninger <thomas@fanninger.at>
 */

// code tag
kirbytext::$tags ['code'] = array (
		'attr' => array (
				'lang',
				'caption',
				'caption_top',
				'caption_class' 
		),
		'html' => function ($tag) {
			$class = $tag->attr ( 'caption_class' );
			$lang = $tag->attr ( 'lang' );
			$caption = $tag->attr ( 'caption' );
			$caption_top = $tag->attr ( 'caption_top', true );
			
			$file = $tag->file ( $tag->attr ( 'code' ) );
			
			$html_code = \at\fanninger\kirby\extension\Code::getCodeBlockFromFile ( $file, $lang, $caption, $caption_top, $class );
			
			return $html_code;
		} 
);
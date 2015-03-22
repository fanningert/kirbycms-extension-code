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
				'class' 
		),
		'html' => function ($tag) {
			$class = $tag->attr ( 'class' );
			$lang = $tag->attr ( 'lang', '' );
			$caption = $tag->attr ( 'caption', '' );
			$caption_top = $tag->attr ( 'caption_top', true );
			
			$file = $tag->file ( $tag->attr ( 'code' ) );
			return Code::generateCodeBlockFromFile ( $file, $lang, $caption, $caption_top, $class );
		} 
);
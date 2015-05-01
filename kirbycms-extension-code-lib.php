<?php

namespace at\fanninger\kirby\extension\codeext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

class CodeExt {
	
	/**
	 *
	 * @param mixed $file
	 * @param string $lang
	 * @param string $caption
	 * @param string $caption_top
	 * @param string $caption_class
	 * @return string
	 */
	public static function getCodeBlockFromFile($file, $lang = false, $caption = false, $caption_top = true, $caption_class = false) {
		if ($file)
			$code = $file->read ();
		else
			$code = 'Unknown content file';
		return ( string ) self::getCodeBlock ( $code, $lang, $caption, $caption_top, $caption_class );
	}
	
	/**
	 *
	 * @param string $code
	 * @param string $lang
	 * @param string $caption
	 * @param string $caption_top
	 * @param string $caption_class
	 * @return string
	 */
	public static function getCodeBlock($code, $lang = false, $caption = false, $caption_top = true, $caption_class = false) {
		$code = WebHelper::convert ( $code );
		
		$attr = array();
		if ( $lang !== false )
			$attr['class'] = "language-" . $lang;
		$code_block = \Html::tag("code", $code, $attr);
		
		$attr = array();
		$pre_block = \Html::tag("pre", $code_block, $attr);
		
		//Figure
		return WebHelper::blockFigure($pre_block, $caption, $caption_top, $caption_class);
	}
	
}
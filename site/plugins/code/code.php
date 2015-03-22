<?php
class Code {
	
	/**
	 * 
	 * @param string $code
	 * @return string
	 */
	public static function convert($code) {
		$code = htmlentities ($code);
		
		return (string)$code;
	}
	
	/**
	 *
	 * @param mixed $file        	
	 * @param string $lang        	
	 * @param string $caption        	
	 * @param string $caption_top        	
	 * @return string
	 */
	public static function generateCodeBlockFromFile($file, $lang = '', $caption = '', $caption_top = false, $class = '') {
		if ($file) {
			$code = $file->read ();
		}
		
		return (string) self::generateCodeBlock ( $code, $lang, $caption, $caption_top, $class );
	}
	
	/**
	 *
	 * @param string $code        	
	 * @param string $lang        	
	 * @param string $caption        	
	 * @param string $caption_top        	
	 * @return Brick|string
	 */
	public static function generateCodeBlock($code, $lang = '', $caption = '', $caption_top = false, $class = '') {
		$code = self::convert ( $code );
		
		$html_code = new Brick( 'code' );
		if(! empty($lang))
			$html_code->addClass( "language-".$lang );
		$html_code->append($code);
		
		$html_pre = new Brick('pre');
		$html_pre->append($html_code);
		
		if (! empty ( $caption )) {
			$figure = new Brick ( 'figure' );
			if (! empty ( $class ))
				$figure->addClass ( $class );
			if ($caption_top)
				$figure->append ( '<figcaption>' . html ( $caption ) . '</figcaption>' );
			$figure->append ( $html_pre );
			if (! $caption_top)
				$figure->append ( '<figcaption>' . html ( $caption ) . '</figcaption>' );
			return (string) $figure;
		} else {
			return (string) $html_pre;
		}
	}
}
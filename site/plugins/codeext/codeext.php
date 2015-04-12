<?php
namespace at\fanninger\kirby\extension;

class CodeExt {
	
	/**
	 *
	 * @param string $code        	
	 * @return string
	 */
	public static function convert($code) {
		$code = htmlentities ( $code );
		
		return ( string ) $code;
	}
	
	/**
	 *
	 * @param mixed $file        	
	 * @param string $lang        	
	 * @param string $caption        	
	 * @param string $caption_top        	
	 * @return string
	 */
	public static function getCodeBlockFromFile($file, $lang, $caption, $caption_top = true, $class) {
		if ($file)
			$code = $file->read ();
		else 
			$code = 'Unknown content file';
		return ( string ) self::getCodeBlock ( $code, $lang, $caption, $caption_top, $class );
	}
	
	/**
	 *
	 * @param string $code        	
	 * @param string $lang        	
	 * @param string $caption        	
	 * @param string $caption_top   
	 * @param string $class     	
	 * @return Brick|string
	 */
	public static function getCodeBlock($code, $lang, $caption, $caption_top = true, $class) {
		$code = self::convert ( $code );
		
		$figure_caption = '';
		if (! empty ( $caption )) {
			$caption = (string) self::convert ( $caption );
			$figure_caption = new \Brick ( 'figcaption', $caption );
		}
		
		$html_code = new \Brick ( 'code', $code );
		if (! empty ( $lang ))
			$html_code->addClass ( "language-" . $lang );
		
		$html_pre = new \Brick ( 'pre', $html_code );
		
		if (! empty ( $caption )) {
			$figure = new \Brick ( 'figure' );
			if (! empty ( $class ))
				$figure->addClass ( $class );
			if ($caption_top === true && ! empty ( $figure_caption )) {
				$figure_caption->addClass ( 'caption-top' );
				$figure->append ( $figure_caption );
			}
			$figure->append ( $html_pre );
			if ($caption_top !== true && ! empty ( $figure_caption )) {
				$figure_caption->addClass ( 'caption-bottom' );
				$figure->append ( $figure_caption );
			}

			return (string) $figure->toString();
		} else {			
			return (string) $html_pre->toString();
		}
	}
}
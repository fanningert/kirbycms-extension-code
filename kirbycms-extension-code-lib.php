<?php

namespace at\fanninger\kirby\extension\codeext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

class CodeExt {
  
  public static $replaceContent = array();
  
  const CONFIG_LANG = 'kirby.extension.codeext.lang';
  const CONFIG_CAPTION_TOP = 'kirby.extension.code.ext.caption_top';
  const CONFIG_CAPTION_CLASS = 'kirby.extension.codeext.caption_class';
  const CONFIG_PARSE_CONTENT = 'kirby.extension.codeext.parse_content';
  
  const ATTR_FILE = 'code';
  const ATTR_LANG = 'lang';
  const ATTR_CAPTION = 'caption';
  const ATTR_CAPTION_TOP = 'caption_top';
  const ATTR_CAPTION_CLASS = 'caption_class';
  const ATTR_PARSE_CONTENT = 'parse_content';
  
  protected $page = null;
  protected $default = array();
  protected $para_mapping = array();
  protected $data = array();
  protected $content = "";
  
  public function __construct(\Page $page) {
    $this->page = $page;
    $this->loadDefaults();
  }
  
  protected function loadDefaults(){
    $this->default[self::ATTR_FILE] = false;
    $this->default[self::ATTR_LANG] = kirby()->option(self::CONFIG_LANG, false);
    $this->default[self::ATTR_CAPTION] = false;
    $this->default[self::ATTR_CAPTION_TOP] = kirby()->option(self::CONFIG_CAPTION_TOP, true);
    $this->default[self::ATTR_CAPTION_CLASS] = kirby()->option(self::CONFIG_CAPTION_CLASS, 'code-figure');
    $this->default[self::ATTR_PARSE_CONTENT] = kirby()->option(self::CONFIG_PARSE_CONTENT, false);
  }
  
  public function getDefaults(){
    return $this->default;
  }
  
  public function parseAndConvertTags($value, array $attr_template = null){
    return $this->parseAndConvertTag(self::ATTR_FILE,$value, $attr_template);
  }
  
  protected function parseAndConvertTag($tag, $value, array $attr_template = null){
    $offset = 0;
    while ( ($block = WebHelper::getblock($tag, $value, $offset)) !== false ) {
      $content = "";
      $offset = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS];
      $start = $block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
      $length = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS]-$block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
      $offset = $start + 1;
      
      $this->parse($tag, $block, $attr_template);
      if( $this->data[self::ATTR_PARSE_CONTENT] === true ){
        $content = $this->toHTML();
      } else {
        $content = "(".uniqid('code', true).")";
        CodeExt::$replaceContent[$content] = $this->toHTML();
      }
      
      $value = substr_replace($value, $content, $start, $length);
      $offset = $start + strlen($content);
    }
    
    return $value;
  }
  
  public function parse($tag, array $block, array $attr_template = null){
    if ( is_array($block) && array_key_exists(WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES, $block) )
      $this->data = $this->convertAndMergeAttributes( $tag, $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES], $attr_template );
    else 
      $this->data = $this->convertAndMergeAttributes( $tag, null, $attr_template );
    
    $this->content = $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT];
  }
  
  protected function convertAndMergeAttributes($tag, array $attr = null, array $attr_template = null){
    $attr_result = array();
    $attr_result = $this->getDefaults();

    if ( is_array($attr_template) ) {
      foreach ( $attr_template as $key => $value ) {
        if ( array_key_exists($key, $attr_result) )
          $attr_result[$key] = $value;
      }
    }
    
    if ( is_array( $attr ) ) {
      foreach($attr as $key => $value){
        if ( array_key_exists($key, $this->para_mapping) )
          $key = $this->para_mapping[$key];
        
        if ( array_key_exists($key, $attr_result) )
          $attr_result[$key] = $this->checkValue( $key, $value );
      }
    }
    
    return $attr_result;
  }
  
  protected function checkValue($key, $value){
    switch($key){
      case self::ATTR_PARSE_CONTENT:
      case self::ATTR_CAPTION_TOP:
        if ( is_bool($value) )
          return;
        if ( is_string($value) )
          $value = ( $value === "true" )? true : false;
        else
          $value = $this->default[self::ATTR_PARSE_CONTENT];
        break;
    }
    return $value;
  }
  
  protected function convertContent($value){
    $search_values = array("(", ")");
    $replace_values = array("&#28;", "&#29;");
    
    //$value = str_replace($search_values, $replace_values, $value);
    
    return $value;
  }
  
  public function toHTML(){
    if ( !empty($this->data[self::ATTR_FILE]) ){
      $source = $this->data[self::ATTR_FILE];
      $source = ( is_object( $source ) )? $source : $this->page->file ( $source );
      return self::getCodeBlockFromFile($source,
                                $this->data[self::ATTR_LANG],
                                $this->data[self::ATTR_CAPTION],
                                $this->data[self::ATTR_CAPTION_TOP],
                                $this->data[self::ATTR_CAPTION_CLASS]);
    } else {
      return self::getCodeBlock($this->content,
                                $this->data[self::ATTR_LANG],
                                $this->data[self::ATTR_CAPTION],
                                $this->data[self::ATTR_CAPTION_TOP],
                                $this->data[self::ATTR_CAPTION_CLASS]);
    }
  }
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
    if ($file && is_object($file))
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
    if ( $lang !== false ) {
      $attr['class'] = "language-" . $lang;
      $attr['data-lang'] = $lang;
    }
    $code_block = \Html::tag("code", $code, $attr);
    
    $attr = array();
    $attr['class'] = "highlight";
    $pre_block = \Html::tag("pre", $code_block, $attr);
    
    //Figure
    return WebHelper::blockFigure($pre_block, $caption, $caption_top, $caption_class);
  }
  
}
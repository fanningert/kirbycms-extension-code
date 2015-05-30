<?php

use at\fanninger\kirby\extension\webhelper\WebHelper;
use at\fanninger\kirby\extension\codeext\CodeExt;

require_once 'kirbycms-extension-code-lib.php';

$codeFunctionPre = function($kirbytext, $value) {
  $codeExt = new CodeExt($kirbytext->field->page);
  return $codeExt->parseAndConvertTags($value);
};

$codeFunctionPost = function($kirbytext, $value) {
  $search = array_keys(CodeExt::$replaceContent);
  $replace = array_values(CodeExt::$replaceContent);
  $value = str_replace($search, $replace, $value);
  
  // Clear the array
  unset(CodeExt::$replaceContent);
  CodeExt::$replaceContent = array();
};

array_unshift(kirbytext::$pre, $codeFunctionPre);
kirbytext::$post[999] = $codeFunctionPost;
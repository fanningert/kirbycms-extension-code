<?php

use at\fanninger\kirby\extension\webhelper\WebHelper;
use at\fanninger\kirby\extension\codeext\CodeExt;

require_once 'kirbycms-extension-code-lib.php';

kirbytext::$pre[] = function($kirbytext, $value) {
  $codeExt = new CodeExt($kirbytext->field->page);
  return $codeExt->parseAndConvertTags($value);
};
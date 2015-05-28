<?php

use at\fanninger\kirby\extension\webhelper\WebHelper;
use at\fanninger\kirby\extension\codeext\CodeExt;

require_once 'kirbycms-extension-code-lib.php';

kirbytext::$pre[] = function($kirbytext, $value) {
	$codeExt = new CodeExt();
	$codeExt->parseAndConvertTags($value);
	return $codeExt->toHTML();
};
<?php

use Illuminate\Support\HtmlString;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

if (! function_exists('clean')) {

  function clean(string $html): HtmlString
  {
    return new HtmlString(new HtmlSanitizer(
      new HtmlSanitizerConfig()
        ->allowSafeElements()
        ->allowAttribute('class', '*')
        ->allowAttribute('href', ['a'])
        ->allowAttribute('src', ['img'])
    )->sanitize($html));
  }
}
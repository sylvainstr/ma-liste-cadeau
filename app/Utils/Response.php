<?php

namespace App\Utils;

class Response
{
  public static function send($code, $reason = null)
  {
    $code = intval($code);

    if (version_compare(phpversion(), '5.4', '>') && is_null($reason)) {
      http_response_code($code);
    }
    else {
      header(trim("HTTP/1.0 $code $reason"));
    }
  }
}

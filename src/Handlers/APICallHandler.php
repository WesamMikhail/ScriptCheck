<?php
namespace Lorenum\ScriptCheck\Handlers;

use Lorenum\ScriptCheck\Error;

class APICallHandler implements HandlerInterface{

    const METHOD_GET = 1;
    const METHOD_POST = 2;

    protected $url;
    protected $method;

    function __construct($url, $method){
        $this->url = $url;
        $this->method = $method;
    }

    public function notify(Error $err) {
        if($this->method == self::METHOD_GET){
            file_get_contents($this->url . "?" . $err->toQueryString());
        }
        else if($this->method == self::METHOD_POST){
            $context  = stream_context_create(['http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => $err->toQueryString()]
            ]);

            file_get_contents($this->url, false, $context);
        }
    }
}
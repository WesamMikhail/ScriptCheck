<?php
namespace Lorenum\ScriptCheck\Handlers;

use Lorenum\ScriptCheck\Error;

Interface HandlerInterface{
    public function notify(Error $err);
}
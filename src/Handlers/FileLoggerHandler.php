<?php
namespace Lorenum\ScriptCheck\Handlers;

use Lorenum\ScriptCheck\Error;


class FileLoggerHandler implements HandlerInterface{

    /**
     * The file in which the errors will be logged
     *
     * @var String
     */
    protected $file;

    /**
     * @param $file String the file name including path that the log will be saved into
     */
    function __construct($file){
        $this->file = $file;
    }

    public function notify(Error $err) {
        file_put_contents($this->file, $err->toString(), FILE_APPEND);
    }
}
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
     * important that the path must be ABSOLUTE. Relative path might encounter issues under apache when scripts
     * terminate unexpectedly
     */
    function __construct($file){
        $this->file = $file;
    }

    public function notify(Error $err) {
        file_put_contents($this->file, $err->toString(), FILE_APPEND);
    }
}
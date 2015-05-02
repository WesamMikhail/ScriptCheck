<?php
namespace Lorenum\ScriptCheck;

use Exception;

use Lorenum\ScriptCheck\Error;
use Lorenum\ScriptCheck\Handlers\HandlerInterface;

class ScriptCheck{
    /**
     * @var HandlerInterface[] List of observers/handlers
     */
    protected $handlers;

    /**
     * Add a handler
     * @param HandlerInterface $handler
     */
    public function addHandler(HandlerInterface $handler){
        $this->handlers[] = $handler;
    }

    protected function notifyAllHandlers(Error $data){
        foreach($this->handlers as $handler){
            $handler->notify($data);
        }
    }

    public function register(){
        set_error_handler(function($errno, $errstr, $errfile, $errline){
            $error = new Error();
            $error->setAll($errno, $errstr, $errfile, $errline, date('Y-m-d H:i:s'));

            $this->notifyAllHandlers($error);
        });
        set_exception_handler(function(Exception $e){
            $error = new Error();
            $error->setAll($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), date('Y-m-d H:i:s'));

            $this->notifyAllHandlers($error);
        });
    }
}
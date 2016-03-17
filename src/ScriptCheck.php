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

    public function __construct(){
        //Turn off error reporting in order to silently fail while handlers notify all listening objects
        error_reporting(0);
        @ini_set('display_errors', 0);
    }

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
        $instance = $this;

        set_error_handler(function($errno, $errstr, $errfile, $errline) use ($instance){
            $error = new Error();
            $error->setAll($errno, $errstr, $errfile, $errline, date('Y-m-d H:i:s'));

            $instance->notifyAllHandlers($error);
        });

        set_exception_handler(function(Exception $e) use ($instance){
            $error = new Error();
            $error->setAll($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), date('Y-m-d H:i:s'));

            $instance->notifyAllHandlers($error);
        });

        register_shutdown_function(function() use ($instance){
            $errorInfo = error_get_last();

            if($errorInfo !== null) {
                $error = new Error();
                $error->setAll($errorInfo["type"], $errorInfo["message"], $errorInfo["file"], $errorInfo["line"], date('Y-m-d H:i:s'));
                $instance->notifyAllHandlers($error);
            }
        });
    }
}
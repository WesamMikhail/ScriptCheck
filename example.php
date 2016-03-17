<?php
require_once "vendor/autoload.php";

use Lorenum\ScriptCheck\ScriptCheck;
use Lorenum\ScriptCheck\Handlers\EmailHandler;

$sc = new ScriptCheck();
$sc->addHandler(new \Lorenum\ScriptCheck\Handlers\FileLoggerHandler("log.log"));
$sc->addHandler(new EmailHandler("myemail@provider.com", "your script got fucked!")); #the error will also be emailed to you
$sc->register();


throw new Exception("Test Exception");
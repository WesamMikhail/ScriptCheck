<?php
require 'vendor/autoload.php';

use Lorenum\ScriptCheck\ScriptCheck;
use Lorenum\ScriptCheck\Handlers\FileLoggerHandler;
use Lorenum\ScriptCheck\Handlers\SQLDBHandler;
use Lorenum\ScriptCheck\Handlers\EmailHandler;
use Lorenum\ScriptCheck\Handlers\APICallHandler;

$sc = new ScriptCheck();
$sc->addHandler(new FileLoggerHandler("test.log"));
//$sc->addHandler(new SQLDBHandler('mysql:host=localhost;dbname=application', "root", ""));
//$sc->addHandler(new EmailHandler("MYEMAIL@SOMEEMAILPROVIDER.COM"));
//$sc->addHandler(new APICallHandler("http://ENDPOINT.COM/YOURURI", APICallHandler::METHOD_POST));
$sc->register();


//Your application code that might trigger an Exception or an Error goes below here!
throw new Exception("Test Exception");
//trigger_error("Test Error!", E_USER_NOTICE);

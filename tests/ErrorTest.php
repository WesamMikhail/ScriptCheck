<?php

use Lorenum\ScriptCheck\Error;

class ErrorTest extends PHPUnit_Framework_TestCase{
    /**
     * @var Error
     */
    private $errObj;

    public function setUp(){
        $this->errObj = new Error();
    }

    public function testToQueryString(){
        $date = "2015-05-01 11:39:53";
        $this->errObj->setAll(255, "Invalid Argument Something Something", "C:\\testfolder\\file.php", 20, $date);
        $expected = "errno=255&error=Invalid+Argument+Something+Something&file=C%3A%5Ctestfolder%5Cfile.php&line=20&time=2015-05-01+11%3A39%3A53";
        $this->assertEquals($expected, $this->errObj->toQueryString());

        $this->errObj->setAll(0, "Invalid Argument Something Something", "C:\\Users\\DemonsHalo\\Desktop\\WAMP Workspace\\Script-Check", 44, $date);
        $expected = "errno=0&error=Invalid+Argument+Something+Something&file=C%3A%5CUsers%5CDemonsHalo%5CDesktop%5CWAMP+Workspace%5CScript-Check&line=44&time=2015-05-01+11%3A39%3A53";
        $this->assertEquals($expected, $this->errObj->toQueryString());
    }

    public function testToString(){
        $this->errObj->setAll(255, "Invalid Argument Something Something", "C:\\testfolder\\file.php", 20, "2015-05-01 11:39:53");
        $expected = "2015-05-01 11:39:53 ==> 	 Error #255 	 Invalid Argument Something Something 	 File: C:\\testfolder\\file.php 	 line 20" . PHP_EOL;
        $this->assertEquals($expected, $this->errObj->toString());
    }
}
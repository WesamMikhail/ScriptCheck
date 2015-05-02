<?php

use Lorenum\ScriptCheck\Handlers\FileLoggerHandler;

class FileLoggerHandlerTest extends PHPUnit_Framework_TestCase{

    /**
     * @var FileLoggerHandler
     */
    private $handler;

    /**
     * @var Lorenum\ScriptCheck\Error
     */
    private $errStub;

    public function setUp(){
        $this->errStub = $this->getMockBuilder('Lorenum\ScriptCheck\Error')->getMock();
        $this->errStub->method('getErrorNo')->willReturn('255');
        $this->errStub->method('getError')->willReturn('Invalid Argument Something Something');
        $this->errStub->method('getFile')->willReturn('C:\\testfolder\\file.php');
        $this->errStub->method('getFileLine')->willReturn('1215');
        $this->errStub->method('getTime')->willReturn("2015-05-01 11:39:53");
        $this->errStub->method('toString')->willReturn("2015-05-01 11:39:53 ==> 	 Error #255 	 Invalid Argument Something Something 	 File: C:\\testfolder\\file.php 	 line 20" . PHP_EOL);


        if(file_exists("../../tests/test_log.log"))
            unlink("../../tests/test_log.log");

        $this->handler = new FileLoggerHandler("../../tests/test_log.log");
    }

    public function tearDown(){
        unlink("../../tests/test_log.log");
    }

    public function testLog(){
        $this->handler->notify($this->errStub);
        $this->assertFileExists("../../tests/test_log.log");

        $content = file_get_contents("../../tests/test_log.log");
        $expected = "2015-05-01 11:39:53 ==> 	 Error #255 	 Invalid Argument Something Something 	 File: C:\\testfolder\\file.php 	 line 20" . PHP_EOL;
        $this->assertEquals($expected, $content);

    }
}
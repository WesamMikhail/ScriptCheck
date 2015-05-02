<?php

use Lorenum\ScriptCheck\Handlers\SQLDBHandler;

class SQLDBHandlerTest extends PHPUnit_Framework_TestCase{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var SQLDBHandler
     */
    private $handler;

    /**
     * @var Lorenum\ScriptCheck\Error
     */
    private $errStub;

    public function setUp(){
        $this->errStub = $this->getMockBuilder('Lorenum\ScriptCheck\Error')->getMock();
        $this->errStub->method('getErrorNo')->willReturn('255');
        $this->errStub->method('getError')->willReturn('SomeError');
        $this->errStub->method('getFile')->willReturn('C:\\testfolder\\file.php');
        $this->errStub->method('getFileLine')->willReturn('1215');
        $this->errStub->method('getTime')->willReturn("2015-05-01 11:39:53");

        $this->pdo = new PDO('mysql:host=localhost;dbname=application', "root", "");

        $sql = "CREATE TABLE IF NOT EXISTS `test_logs` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `errorNo` varchar(255) NOT NULL,
                  `error` text NOT NULL,
                  `file` text NOT NULL,
                  `line` varchar(20) NOT NULL,
                  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;";

        $this->pdo->exec($sql);
        $this->pdo->exec("TRUNCATE TABLE test_logs");

        $this->handler = new SQLDBHandler('mysql:host=localhost;dbname=application', "root", "");
        $this->handler->setTableName("test_logs");
    }

    public function tearDown(){
        $this->pdo->exec("DROP TABLE test_logs");
    }


    public function testSuccessfulInsert(){
        $this->handler->notify($this->errStub);

        $stm = $this->pdo->prepare("SELECT errorNo, error, file, line, `timestamp` FROM test_logs");
        $stm->execute();

        $this->assertEquals(1, $stm->rowCount());
        $this->assertEquals(["errorNo" => '255', "error" => "SomeError", "file" => "C:\\testfolder\\file.php", "line" => '1215', "timestamp" => "2015-05-01 11:39:53"], $stm->fetch(PDO::FETCH_ASSOC));
    }
}


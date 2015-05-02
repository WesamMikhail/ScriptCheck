<?php
namespace Lorenum\ScriptCheck\Handlers;

use PDO;
use Lorenum\ScriptCheck\Error;

/**
 * Class DBHandler
 *
 * SQL table should look something along these lines:
 *
    CREATE TABLE IF NOT EXISTS `logs` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `errorNo` varchar(255) NOT NULL,
    `error` text NOT NULL,
    `file` text NOT NULL,
    `line` varchar(20) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
 *
 * @package ScriptCheck\Handlers
 */
class SQLDBHandler extends PDO implements HandlerInterface {

    /**
     * @var String table the log should be inserted into
     */
    protected $table = 'logs';

    public function setTableName($table) {
        $this->table = $table;
    }

    public function notify(Error $err) {
        $stm = $this->prepare("INSERT INTO " . $this->table . " (errorNo, error, file, line, timestamp) VALUES (:errno, :err, :file, :line, :timestamp)");
        $stm->execute([
            ":errno" => $err->getErrorNo(),
            ":err" => $err->getError(),
            ":file" => $err->getFile(),
            ":line" => $err->getFileLine(),
            ":timestamp" => $err->getTime()
        ]);
    }
}
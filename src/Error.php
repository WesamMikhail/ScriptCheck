<?php
namespace Lorenum\ScriptCheck;

class Error{
    protected $errorNo;
    protected $error;
    protected $file;
    protected $fileLine;
    protected $time;

    /**
     * @param mixed $time
     */
    public function setTime($time) {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * @param mixed $error
     */
    public function setError($error) {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getError() {
        return $this->error;
    }

    /**
     * @param mixed $errorNo
     */
    public function setErrorNo($errorNo) {
        $this->errorNo = $errorNo;
    }

    /**
     * @return mixed
     */
    public function getErrorNo() {
        return $this->errorNo;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param mixed $fileLine
     */
    public function setFileLine($fileLine) {
        $this->fileLine = $fileLine;
    }

    /**
     * @return mixed
     */
    public function getFileLine() {
        return $this->fileLine;
    }

    /**
     * @param $errno
     * @param $err
     * @param $file
     * @param $line
     * @param $time
     */
    public function setAll($errno, $err, $file, $line, $time){
        $this->setErrorNo($errno);
        $this->setError($err);
        $this->setFile($file);
        $this->setFileLine($line);
        $this->setTime($time);
    }

    public function toQueryString(){
        return http_build_query(["errno" => $this->getErrorNo(), "error" => $this->getError(), "file" => $this->getFile(), "line" => $this->getFileLine(), "time" => $this->getTime()]);
    }

    public function toString(){
        return "{$this->getTime()} ==> \t Error #{$this->getErrorNo()} \t {$this->getError()} \t File: {$this->getFile()} \t line {$this->getFileLine()}" . PHP_EOL;
    }

}
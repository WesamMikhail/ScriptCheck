<?php
namespace Lorenum\ScriptCheck\Handlers;

use Lorenum\ScriptCheck\Error;

class EmailHandler implements HandlerInterface{

    /**
     * @var String the email to be notified
     */
    protected $email;

    /**
     * @var String the subject/title of the email
     */
    protected $subject;

    /**
     * @param $email String your email
     * @param String|null $subject The email subject/title
     */
    function __construct($email, $subject = null){
        $this->email;
        $this->subject = $subject;
    }

    public function notify(Error $err) {
        $subject = $this->subject;
        if($subject === null)
            $subject = "Error In Your Script";

        mail($this->email, $subject, $err->toString());
    }
}
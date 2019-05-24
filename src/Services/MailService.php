<?php
namespace EenmaalAndermaal\Services;

use EenmaalAndermaal\App;

class MailService {

    private $sender;

    private $vars = [];

    private $template;

    public function __construct($template)
    {
        $this->sender = App::getApp()->getConfig()->get("website.mail.sender");
        $this->template = BASEPATH . "views/mail/" . $template . ".phtml";
    }

    public function addVar($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function getVar($key) {
        return isset($this->vars[$key]) ? $this->vars[$key] : false;
    }

    private function renderMessage()
    {
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $this->template;
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public function sendMail($emailAdress, $subject)
    {
        $message = $this->renderMessage();
        $header = 'From: ' . $this->sender . "\r\n";
        $header .= "MIME-Version: 1.0" . "\r\n";
        $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        if (!mail($emailAdress, $subject, $message, $header)) {
            //LOG ERROR PLEASE; Email not sent successfully
            return false;
        }
        return true;
    }

    public function __toString()
    {
        return $this->renderMessage();
    }
}
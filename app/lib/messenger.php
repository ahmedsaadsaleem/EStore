<?php

namespace PHPMVC\Lib;

class Messenger
{

    const APP_MESSAGE_SUCCESS   = 1;
    const APP_MESSAGE_ERROR     = 2;
    const APP_MESSAGE_WARNING   = 3;
    const APP_MESSAGE_INFO      = 4;

    private static $_instance;

    private $_session;

    private $_messages;

    private function __construct($session)
    {
        $this->_session = $session;
    }

    private function __clone(): void {}

    public static function getInstance(SessionManager $session): mixed
    {
        if(self::$_instance === null){
            self::$_instance = new self($session);
        }

        return self::$_instance;
    }

    public function add($message, $type = self::APP_MESSAGE_SUCCESS): void
    {
        if(!$this->messagesExists()){
            $this->_session->messages = [];
        }
        $mesgs = $this->_session->messages;
        $mesgs[] = [$message, $type];
        $this->_session->messages = $mesgs;
    }

    public function getMessages(): mixed
    {
        if($this->messagesExists()){
            $this->_messages = $this->_session->messages;
            unset($this->_session->messages);
            return $this->_messages;
        }
        return [];
    }

    private function messagesExists(): bool
    {
        return isset($this->_session->messages);
    }
}
<?php
namespace PHPMVC\Lib;

class SessionManager extends \SessionHandler
{
    private $sessionName = 'ESTORESESS';
    private $maxSessionLifetime = 0;
    private $sessionSSL = false;
    private $sessionHTTPOnly = true;
    private $sessionPath = '/';
    private $sessionDomain = '.mvcapp.com';
    private $sessionSavePath = SESSION_SAVE_PATH;
    
    private $sessionCiphrAlgo = 'AES-128-ECB';
    private $sessionCipherKey = 'M3JG0W3L0WAZ3GR3L';

    private $ttl = 1;
    
    public function __construct() 
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');
        
        session_name($this->sessionName);
        session_save_path($this->sessionSavePath);
        
        session_set_cookie_params(
                $this->maxSessionLifetime, $this->sessionPath,
                $this->sessionDomain, $this->sessionSSL,
                $this->sessionHTTPOnly,
                );

        // session_set_save_handler($this, true);
    }


    public function __set($key, $value): void
    {
        if(is_object($value)){
            $_SESSION[$key] = serialize($value);
        } else {
            $_SESSION[$key] = $value;
        }

    }

    public function __get($key): mixed
    {
        if(isset($_SESSION[$key])){
            if(is_string($_SESSION[$key])){
                $data = @unserialize($_SESSION[$key]);
            } else {
                $data = false;
            }
            
            if($data === false){
                return $_SESSION[$key];
            } else {
                return $data;
            }
        } else {
            trigger_error('No session key ' . $key . 'exists', E_USER_NOTICE);
        }
    }

    public function __isset($key): bool
    {
        return isset($_SESSION[$key]) ? true : false;
    }
    
    public function __unset($key)
    {
        unset($_SESSION[$key]);
    }

    public function read($id): string|false
    {
        return openssl_decrypt(parent::read($id), $this->sessionCiphrAlgo, $this->sessionCipherKey);
    }

    public  function write($id, $data): bool
    {
        return parent::write($id, openssl_encrypt($data, $this->sessionCiphrAlgo, $this->sessionCipherKey));
    }

    public function start(): void
    {
        if('' === session_id())  
        {
            if(session_start())
            {
                $this->setSessionStartTime();
                $this->checkSessionValidity();
            }
        }
    }

    private function setSessionStartTime(): bool
    {
        if(!isset($this->sessionStartTime))
        {
            $this->sessionStartTime = time();
        }
        return true;
    }

    private function checkSessionValidity(): bool
    {
        if((time() - $this->sessionStartTime) > ($this->ttl * 60))
        {
            $this->renewSession();
            $this->generateFingerPrint();
        }
        return true;
    }

    private function renewSession(): bool
    {
        $this->sessionStartTime = time();
        return session_regenerate_id(true);
    }


    private function generateFingerPrint(): void
    {
        $userAgenId = $_SERVER['HTTP_USER_AGENT'];
        $this->cipherKey = openssl_random_pseudo_bytes(16);
        $sessionId = session_id();
        $this->fingerPrint = md5($userAgenId . $this->cipherKey . $sessionId);
    }

    public function isValidFingerPrint(): bool
    {
        if(!isset($this->fingerPrint))
            $this->generateFingerPrint();

        $fingerPrint = md5($_SERVER['HTTP_USER_AGENT'] . $this->cipherKey . session_id());

        if($fingerPrint === $this->fingerPrint)
            return true;
        
        return false;
    }

    public function kill(): void
    {
        session_unset();
        setcookie(
            $this->sessionName,'',time() - 100, 
            $this->sessionPath, $this->sessionDomain, 
            $this->sessionSSL, $this->sessionHTTPOnly
        );

        session_destroy();
    }
}

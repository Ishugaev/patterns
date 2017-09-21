<?php

class Login implements \SplSubject
{
    const USER_UNKNOWN = 1;
    const USER_WRONG_PASS = 2;
    const USER_ACCESS = 3;

    private $status = [];

    private $storage;

    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }

    public function handleLogin(string $username, string $password, string $ip)
    {
        switch (rand(1, 3)) {
            case self::USER_UNKNOWN:
                $this->setStatus(self::USER_UNKNOWN, $username, $ip);
                break;
            case self::USER_WRONG_PASS:
                $this->setStatus(self::USER_WRONG_PASS, $username, $ip);
                break;
            case self::USER_ACCESS:
                $this->setStatus(self::USER_UNKNOWN, $username, $ip);
                break;
        }

        $this->notify();
    }

    private function setStatus(int $statusId, string $username, string $ip)
    {
        $this->status = [$statusId, $username, $ip];
    }

    public function getStatus(): array
    {
        return $this->status;
    }

    public function attach(\SplObserver $observer)
    {
        $this->storage->attach($observer);
    }

    public function detach(\SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    public function notify()
    {
        foreach($this->storage as $observer) {
            $observer->update($this);
        }
    }
}

abstract class LoginObserver implements \SplObserver
{
    private $login;

    public function __construct(Login $login)
    {
        $this->login = $login;
        $this->login->attach($this);
    }

    public function update(SplSubject $subject)
    {
        if ($subject === $this->login){
            $this->doUpdate($subject);
        }
    }

    abstract function doUpdate(Login $login);
}


class SecurityMonitor extends LoginObserver
{
    public function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        if ($status[0] === Login::USER_UNKNOWN) {
            print __CLASS__ . " sending mail to sys-admins \n";
        }
    }
}


$login = new Login();
$securityMonitor = new SecurityMonitor($login);
$login->handleLogin('Vasya', 'xxxx', '127.0.0.1');

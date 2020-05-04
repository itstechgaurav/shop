<?php

abstract class notificationAbstraction {
    abstract function addTosessions($notiObj);
    abstract function getFromSessions();
    private $notifications;
}

class NotificationObject {
    public $type ='';
    public $content ='';
    public $extra = array();
    public function __construct($type, $content, $extra) {
            $this->type = $type;
            $this->content = $content;
            $this->extra = $extra;
    }
}

class Notification extends notificationAbstraction
{
    private $notifications = array();

    public function __construct() {
        if(isset($_SESSION['notifications'])) {
            $this->notifications = $_SESSION['notifications'];
        } else {
            $_SESSION['notifications'] = array();
        }
    }
    function addTosessions($notiObj)
    {
        // TODO: Implement addTosession() method.
        array_push($this->notifications, $notiObj);
        array_push($_SESSION['notifications'], $notiObj);

    }

    function getFromSessions()
    {
        // TODO: Implement getFromSessions() method.
        $noti = $_SESSION['notifications'];
        $_SESSION['notifications'] = array();
        return $noti;
    }

    public function get() {
        return $this->getFromSessions();
    }

    public function set($type, $content, $extra = []) {
        $this->addTosessions(new NotificationObject($type, $content, $extra));
    }
}
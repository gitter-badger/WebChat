<?php
namespace Server;


use Handling\ServerHandler;
use Client\Client;

class ChatServer extends Server
{
    protected $port = 8888;
    protected $ip = '0.0.0.0';
    private $_server_handler = null;

    private $clients = array();

    public function __construct($ip = '', $port = '')
    {
        parent::__construct($ip, $port);
        $this->_server_handler = new ServerHandler();
    }

    public function onOpen($server, $request)
    {

        $fd = $request->fd;
        $client = new Client($fd, $server);
        if (!$this->addClient($fd, $client)) {
            $server->close($fd, TRUE);
            $this->setClient($fd, $client);
        }

    }

    public function onMessage($server, $frame) {
        $fd = $frame->fd;
        $this->_server_handler->hold($this->getClient($fd), $frame);
    }

    public function getClient($fd) {
        if (isset($this->clients[$fd]))
            return $this->clients[$fd];
        return null;
    }

    public function onClose($server, $fd)
    {
        unset($this->clients[$fd]);
    }

    public function addClient($fd, $client) {
        if (isset($this->clients[$fd])) {
            return FALSE;
        } else {
            $this->setClient($fd, $client);
            return TRUE;
        }
    }

    public function setClient($fd, $client) {
        $this->clients[$fd] = $client;
    }
}
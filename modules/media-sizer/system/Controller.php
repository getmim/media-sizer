<?php

namespace MediaSizer;

class Controller extends \Mim\Controller
    implements \Mim\Iface\GateController
{
    public function show404(): void{
        $this->res->setStatus(404);
        $this->res->send();
    }

    public function show404Action(): void{
        $this->show404();
    }

    public function show500(object $error): void{
        $this->res->setStatus(500);
        $this->res->send();
    }

    public function show500Action(): void{
        $this->show500(\Mim\Library\Logger::$last_error);
    }
}
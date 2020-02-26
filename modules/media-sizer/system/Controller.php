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

        if(is_dev()){
            $tx = $error->text;
            $tx.= '<br>';
            $tx.= 'File: ' . $error->file . ' (' . $error->line . ')';
            if(isset($error->trace)){
                $tx.= '<ul>';
                foreach($error->trace as $trace){
                    if(!isset($trace['file']))
                        continue;
                    $tx.= '<li>' . $trace['file'] . '(' . $trace['line'] . ')' . '</li>';
                }
                $tx.= '</ul>';
            }

            $this->res->addContent($tx);
        }
        
        $this->res->send();
    }

    public function show500Action(): void{
        $this->show500(\Mim\Library\Logger::$last_error);
    }
}
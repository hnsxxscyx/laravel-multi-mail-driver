<?php

namespace HNSXXSCYX\MultipleMailerDriver;

use Swift_Mailer;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Manager;
use Illuminate\Mail\Mailer;

class MailManager extends Manager {
    
    public function mailer($name = null)
    {
        return $this->driver($name);
    }

    public function setTransportManager(TransportManager $manager)
    {
        $this->transportManager = $manager;

        return $this;
    }

    protected function createDriver($driver)
    {
        return $this->resolve($driver);
    }

    protected function createSwiftMailer($driver)
    {
        return new Swift_Mailer($this->transportManager->driver($driver));
    }

    protected function resolve($name)
    {
        $mailer = new Mailer(
            $this->app['view'],
            $this->createSwiftMailer($name),
            $this->app['events']
        );

        if ($this->app->bound('queue')) {
            $mailer->setQueue($this->app['queue']);
        }
        
        return $mailer;
    }

    public function getDefaultDriver()
    {
        $driverName = $this->app['config']['mail.driver'] ??
            $this->app['config']['mail.default'];
            
        return $driverName;
    }

}
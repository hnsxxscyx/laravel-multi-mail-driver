<?php

namespace Hnsxxscyx\MultipleMailerDriver;

use Swift_Mailer;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Manager;
use Illuminate\Mail\Mailer;

/**
 * @mixin \Illuminate\Mail\Mailer
 */
class MailManager extends Manager {
    
    /**
     * Get a mailer instance by name.
     *
     * @param  string|null  $name
     * @return \Illuminate\Mail\Mailer
     */
    public function mailer($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Set transport manager.
     *
     * @param  \Illuminate\Mail\TransportManager  $manager
     * @return \Illuminate\Mail\TransportManager
     */
    public function setTransportManager(TransportManager $manager)
    {
        $this->transportManager = $manager;

        return $this;
    }

    /**
     * Create new mailer.
     *
     * @param string $driver
     * @return Illuminate\Mail\Mailer
     */
    protected function createDriver($driver)
    {
        return $this->resolve($driver);
    }

    /**
     * Create swift mailer instance.
     *
     * @param string $driver
     * @return Swift_Mailer
     */
    protected function createSwiftMailer($driver)
    {
        return new Swift_Mailer($this->transportManager->driver($driver));
    }

    /**
     * Create new mailer.
     *
     * @param string $name
     * @return Illuminate\Mail\Mailer
     */
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

    /**
     * Get default driver name.
     *
     * @return string $driverName
     */
    public function getDefaultDriver()
    {
        $driverName = $this->app['config']['mail.driver'] ??
            $this->app['config']['mail.default'];
            
        return $driverName;
    }

}
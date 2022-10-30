<?php

// just for example, don't register in config

namespace Hnsxxscyx\MultipleMailerDriver;

use Illuminate\Mail\MailServiceProvider as BaseMailServiceProvider;

class MailServiceProvider extends BaseMailServiceProvider
{
    /**
     * Register the Illuminate mailer instance.
     *
     * @return void
     */
    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', function ($app) {
            return new MailManager($app);
        });

        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
    }
}
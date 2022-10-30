# Laravel-multi-mail-driver
The package make Laravel can use multiple mail driver and sending mail via specific mailer.

# Support
Support Laravel 5.* - Laravel 6.x.
Laravel ^7 has officially implemented this behavior.

# Usage
Same as laravel ^7.x.
Need use package namespace.

```php
use Hnsxxscyx\MultipleMailerDriver\Facades\Mail;

Mail::mailer('mailgun')
    ->to($request->user())
    ->send(new OrderShipped($order));
```

## Install
```
composer install hnsxxscyx/laravel-multi-mail-driver;
```

## Config
Register in AppServiceProvider:
``` php
use Hnsxxscyx\MultipleMailerDriver\MailManager;

public function register()
{
    $this->app->singleton('mail.manager', function ($app) {
        return (new MailManager($app))->setTransportManager($app['swift.transport']);
    });

    $this->app->bind('mailer', function ($app) {
        return $app->make('mail.manager')->mailer('mailgun');
    });
}
```

Change aliases Mail in config/app.php:
``` php
// 'Mail' => Illuminate\Support\Facades\Mail::class,
'Mail' => Hnsxxscyx\MultipleMailerDriver\Facades\Mail;::class,
```

## TODO
- [ ] support notification
- [ ] support multiple smtp service



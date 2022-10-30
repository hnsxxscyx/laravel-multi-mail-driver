# Laravel-multi-mail-driver
使Laravel 支持多个mail driver， 并在使用时优雅的切换。

# Support
支持Laravel 5.* - Laravel 6.x, Laravel 7 开始官方支持了多driver 操作。

# Usage
与Laravel 7 及以上版本一致，使用mailer 方法设定此次mail 所使用的driver。
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
在AppServiceProvider 中 register:
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

在config/app.php 中， 更改aliases Mail:
``` php
// 'Mail' => Illuminate\Support\Facades\Mail::class,
'Mail' => Hnsxxscyx\MultipleMailerDriver\Facades\Mail;::class,
```

## TODO
- [ ] support notification
- [ ] support multiple smtp service



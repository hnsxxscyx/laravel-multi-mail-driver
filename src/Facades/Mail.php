<?php

namespace Hnsxxscyx\MultipleMailerDriver\Facades;

use Illuminate\Support\Facades\Facade;

class Mail extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mail.manager';
    }
}
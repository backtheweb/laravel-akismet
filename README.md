### Backtheweb Akismet

## Install

Add the providers on config/app.php file

    Backtheweb\Akismet\AkismetServiceProvider::class

And the facade alias
    
    'Akismet' =>  Backtheweb\Akismet\Facade::class

Create a config file

    php artisan vendor:publish --provider="Backtheweb\Akismet\ServiceProvider" --tag="config"
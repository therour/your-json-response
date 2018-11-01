# YJResponse - Your Json Response

## INSTALLATION
via Composer
```
composer require therour/your-json-response
```
*For Laravel 5.4 and below* Add Service Provider to `config/app.php` of your laravel project
```php
'providers' => [
    ...
    Therour\YourJsonResponse\ServiceProvider::class,
] 
```

## CONFIGURATION
publish configuration file
```
php artisan vendor:publish --provider=Therour\YourJsonResponse\ServiceProvider
```
the configuration file is located at your laravel's config directory by name `yjresponse.php`

## USAGE

this package is bundled with named skeleton `ok`, you can edit the skeleton in config `yjresponse.php`
```php
return response()->ok($data, $message = 'success', $code = 200);
// or
return response()->yourNamedSkeleton($data, $message = 'success', $code = 200);
```

### CREATING SKELETON
open configuration file `yjresponse.php`

use `code`, `message`, `data`, `type`, and `meta_page` as value of skeleton to place it

EG: 
```php

'skeleton' => [
    ...
    // 'created' is the name of skeleton, and its value is the skeleton
    'created' => [
        'status' => [
            'code',
            'message'
        ],
        'result' => 'data'
    ]
],
```
at the same file, also define the default value
```php
'defaults' => [
    ...
    'created' => [
        'code' => 201,
        'message' => 'Succesfully create the object'
    ]
]
```

Use your custom skeleton
```php
return response()->created($product);
```
*result*
```json
{
    "status": {
        "code": 201,
        "message": "Succesfully create the object"
    },
    "result": {
        "name": "Product X",
        "price": 6000,
        "weight": 500
    }
}```


# Vanilla

## Installation
```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar require noidhoon/vanilla dev-master
```

## Getting started
```php
use Vanilla\Vanilla;

require_once __DIR__ . '/../vendor/autoload.php';

$application = new Vanilla();
$application -> get('/', function () use ( $application ) {

    print 'Hello World';
});

$application -> run();
```

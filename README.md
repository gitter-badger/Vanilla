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

## Variables
```php
$application -> vanilla_variables -> set('key', 'value');
$application -> vanilla_variables -> set('array', ['key' => 'value']);
$application -> vanilla_variables -> set('object', new Object() );

$application -> vanilla_variables -> get('key');
$application -> vanilla_variables -> delete('key');
```
Shortcuts
```php
$application -> vars('key', 'value');
$application -> vars('key');
```

## Sessions
```php
$application -> vanilla_session -> write('key', 'value');
$application -> vanilla_session -> read('key');
$application -> vanilla_session -> delete('key');
$application -> vanilla_session -> destroy();
```
Shortcuts
```php
$application -> session('key', 'value');
$application -> session('key');
```

# Vanilla

[![Join the chat at https://gitter.im/noidhoon/Vanilla](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/noidhoon/Vanilla?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

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

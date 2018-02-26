<p align="center">
    <h1 align="center">Yii2 URL Shortener</h1>
    <br>
</p>

_Основано на [Yii 2](http://www.yiiframework.com/) Basic Project Template._

Пользователю предоставляется поле для ввода URL, по нажатию кнопки «Уменьшить» пользователю предоставляется короткая ссылка с текущим доменом сайта.

При переходе по уменьшенной ссылке юзер будет перенаправлен на исходную страницу.

Пользователь имеет возможность:
* создать свою короткую ссылку;
* возможность создавать ссылки с ограниченным сроком жизни.

Пользователь, создающий ссылку также получает ссылку на статистику переходов:
* дата и время перехода;
* гео-информацию (страна, город);
* наименование и версия браузера и ОС.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      migrations/         contains migrations classes
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.1.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
php composer.phar create-project --prefer-dist --stability=dev yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~


Конфигурация
------------

### База даных

Создать базу данных и внести необходимые изменения в файл `config/db.php`, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2-url-shortener',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

Применить миграции, выполнив команду:

```
php yii migrate
```


Тестирование
------------

Перед запуском тестов необходимо создать тестовую БД и указать её в настройках файла `config/test_db.php`, например:
```php
$db['dsn'] = 'mysql:host=localhost;dbname=yii2-url-shortener_test';
```


Тесты запускаются командой

```
vendor/bin/codecept run
```

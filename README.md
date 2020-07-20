<<<<<<< HEAD
<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.com/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.com/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
api
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    modules/             contains modules for REST API  
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/      
admin
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
application
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
=======
# Тестовое задание от klever-lab
    1. Клонировать проект
        clone https://github.com/rapniger/klever-lab
    2. Выполнить команду в командной строки
        composer update        
    3. Выполнить настройку соединения с БД
        /common/config/main.php в разделе 'db' => []
    4. Из командной строки в корне приложения выполнить миграцию:
        a. php yii migrate
        b. нажать на кнопку Y
    5. Настройка виртуального хоста:
        domen.my - основное веб-приложение Путь приложения - /application/web/
        admin.domen.my - администраторское веб-приложение Путь приложения - /admin/web/
        api.domen.my - REST API веб-приложение Путь приложения - /api/web/
        Подробная информация о настройки веб-сервера содержится в документации по ссылке https://www.yiiframework.com/doc/guide/2.0/ru/start-installation#configuring-web-servers
    6. Зарегистрироваться в системе по ссылке:
        domen.my/register.html
    7. Для доступа админки авторизоваться в системе по ссылке:
        domen.my/signup.html
    8. База данных пустая, их нужно заполнять в админке после регистрации и авторизации
## Сайт разработан в веб-окружении OpenServer
>>>>>>> 70813699306ff3822881310490bbfe3d2aae1a12

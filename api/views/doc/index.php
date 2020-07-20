<?php

/* @var $this yii\web\View */

$this->title = 'Главная';
?>
<div class="col-12" style="margin-top: 40px">
    <h3 class="text-center">
        Документация
    </h3>
    <ul class="list-unstyled" style="margin-top: 40px">
        <li>
            1. Клонировать проект
            <ol style="margin: 20px 0px">
                <b>https://github.com/rapniger/klever-lab</b>
            </ol>
        </li>
        <li>
            2. Выполнить настройку соединения с БД
            <ol style="margin: 20px 0px">
                <b>/common/config/main.php</b> в разделе 'db' => []
            </ol>
        </li>
        <li>
            3. Из командной строки в корне приложения выполнить  миграцию:
            <ol style="margin: 20px 0px">
                a. <b>php yii migrate</b>
            </ol>
            <ol style="margin: 20px 0px">
                b. нажать на кнопку <b>Y</b>
            </ol>
        </li>
        <li>
            4. Настройка виртуального хоста:
            <ol style="margin: 20px 0px">
                <b>domen.my</b> - основное веб-приложение
                Путь приложения - /application/web/
            </ol>
            <ol style="margin: 20px 0px">
                <b>admin.domen.my</b> - администраторское веб-приложение
                Путь приложения - /admin/web/
            </ol>
            <ol style="margin: 20px 0px">
                <b>api.domen.my</b> - REST API веб-приложение
                Путь приложения - /api/web/
            </ol>
            <ol class="border" style="margin: 20px 0px">
                <i>
                    Подробная информация о настройки веб-сервера содержится в документации по <a href="https://www.yiiframework.com/doc/guide/2.0/ru/start-installation#configuring-web-servers">ссылке</a>
                </i>
            </ol>
        </li>
        <li>
            5. Зарегистрироваться в системе по ссылке:
            <ol style="margin: 20px 0px">
                <b>domen.my/register.html</b>
            </ol>
        </li>
        <li>
            6. Для доступа админки авторизоваться в системе по ссылке:
            <ol style="margin: 20px 0px">
                <b>domen.my/signup.html</b>
            </ol>
        </li>
        <li>
            7. База данных пустая, их нужно заполнять в админке:
        </li>
    </ul>
</div>

В рамках тестового задания необходимо реализовать сократитель ссылок:

    1. Посетитель сайта вводит любой оригинальный URL-адрес в поле ввода, как http://domain/любой/путь/и т. д.;
    2. Нажимает кнопку submit;
    3. Страница делает ajax-запрос на сервер и получает уникальный короткий URL-адрес;
    4. Короткий URL-адрес отображается на странице как http://yourdomain/abCdE (не используйте внешние Интерфейсы как goo.gl и т. д.);
    5. Посетитель может скопировать короткий URL-адрес и повторить процесс с другой ссылкой

    Короткий URL должен уникальным, при переходе на него перенаправлять на оригинальную ссылку и быть актуальным навсегда, неважно, сколько раз он был использован.

    Требования:

    1. Использовать PHP и MySQL (если требуется);
    2. Не использовать никаких фрэймворков.

    Ожидаемый результат:

    1. Исходный код;
    2. Системные требования и инструкции по установке на нашем сервере.

Requirements:

    1. php 7.1.9

    2. mysql:

        - table `links` in DATABASE with structure:

            CREATE TABLE `links` (
            `id` int(11) NOT NULL,
            `long_link` text,
            `short_link` text
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

        - SERVER, PORT, DATABASE, USER, PASSWORD in router.php

    3. src/client.html must be in the same directory like router.php
    
Run:

    - run php dev web-server: /path/to/php -S localhost:80 src/router.php

    OR

    - configure apache/nginx to redirect all requests to router.php
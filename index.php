<?php

require dirname(__DIR__) . '/app/autoload.php';
require_once '/app/vendor/autoload.php';

/**
 * 1.Допустим у нас есть список товаров, которые покупали наши клиенты.
 * Нам надо создать на основе этого списка, базу данных на MySQL.
 * Нам важно знать имена клиентов и товаров в базе, ничего лишнего хранить в базе не нужно.
 * Создайте структуру базы и запишите в нее демо данные, сделайте выборку из базы так,
 * чтобы вывести список клиентов, которые купили 3 или более разных товаров.
 *
 * 2. Необходимо реализовать сервис по сокращения ссылок. Сервис состоит из одной страницы и формы ввода.
 * Поле для ввода ссылки и кнопка. Результатом будет сокращенная ссылка по переходу по ссылке должно быть
 * перенаправление на исходный адрес. Токен короткой ссылки должен быть рандомным, уникальным состоящий из цифр
 * и букв (разного регистра) длиной 6 символов.
 */

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $dbConnect = new DbConnection();
    $dbh = $dbConnect->con;

    $uri = explode('/', $_SERVER['REQUEST_URI']);

    if ($uri[1] == 'short_link') {
        $link = new Link($dbConnect);
        $full_link = $link->getFullLink($uri[2]);
        header('Location: ' . $full_link);
        die();
    }

    switch ($_GET['task']) {
        case 1:
            $sth = $dbh->prepare("DESCRIBE `users`");
            //Проверка созданы ли все нужные таблицы
            try {
                $sth->execute();
            } catch (PDOException $exception) {
                $fixtureService = new StartInitializationsDb($dbConnect);
                $fixtureService->createTables();
                $fixtureService->initTables(100, 200, 50);
            }

            $worker = new DbWorker($dbConnect);
            $result = $worker->getClientsBuyThreeDifferentProduct();

            foreach ($result as $username) {
                echo $username['full_name'] . "<br>";
            }

            break;
        case 2:
            $sth = $dbh->prepare("DESCRIBE `links`");
            try {
                $sth->execute();
            } catch (PDOException $exception) {
                StartInitDbLinks::createLinksTable($dbConnect);
            }
            $html_string = file_get_contents('/app/form.html');
            echo $html_string;
            break;
    }
}
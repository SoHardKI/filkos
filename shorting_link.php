<?php

require dirname(__DIR__) . '/app/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['link']) && strlen($_POST['link'])) {

    if (filter_var($_POST['link'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) == false) {
        echo 'Input string - not link!';
        die();
    }

    $link = $_POST['link'];
    $dbConnect = new DbConnection();
    $dbh = $dbConnect->con;
    $sth = $dbh->prepare("insert into links (full_url,short_url)
                                    values (?,?);");
    $token = StringWorker::generateRandomString();

    $sth->execute([$link, $token]);
    echo $token;

} else {
    echo 'ERROR!';
}



<?php


class StartInitDbLinks
{
    /**
     * @param DbConnection $connection
     */
    public static function createLinksTable(DbConnection $connection)
    {
        $dbh = $connection->con;
        $userSth = $dbh->prepare("CREATE TABLE `links` ( `id` INT NOT NULL AUTO_INCREMENT ,
        `full_url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        `short_url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, PRIMARY KEY (`id`));");
        $userSth->execute();
    }
}
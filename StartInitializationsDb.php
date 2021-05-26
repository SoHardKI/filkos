<?php


class StartInitializationsDb
{
    private DbConnection $connection;

    /**
     * StartInitializationsDb constructor.
     * @param DbConnection $connection
     */
    public function __construct(DbConnection $connection)
    {
        $this->connection = $connection;
    }

    public function createTables()
    {
        $dbh = $this->connection->con;
        $userSth = $dbh->prepare("CREATE TABLE `users` ( `id` INT NOT NULL AUTO_INCREMENT ,
        `full_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`));");
        $userSth->execute();

        $productSth = $dbh->prepare("CREATE TABLE `products` ( `id` INT NOT NULL AUTO_INCREMENT , `name`
        VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`));");
        $productSth->execute();

        $orderSth = $dbh->prepare("CREATE TABLE `orders` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id`
        INT NOT NULL , `product_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        $orderSth->execute();
    }

    /**
     * @param int $usersCount
     * @param int $productsCount
     * @param int $ordersCount
     */
    public function initTables(int $usersCount = 100, int $productsCount = 200, int $ordersCount = 50)
    {
        $faker = Faker\Factory::create();
        $dbh = $this->connection->con;

        for ($i = 0; $i < $usersCount; ++$i) {
            $userSth = $dbh->prepare("insert into users (full_name)
                                    values (?);");
            $userSth->execute([$faker->firstName . ' ' . $faker->lastName]);
        }

        for ($j = 0; $j < $productsCount; ++$j) {
            $productSth = $dbh->prepare("insert into products (name)
                                    values (?);");
            $productSth->execute([$faker->word]);
        }

        $sth = $dbh->prepare("SELECT id from users");
        $sth->execute();
        $userIds = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sth = $dbh->prepare("SELECT id from products");
        $sth->execute();
        $productIds = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($k = 0; $k < $ordersCount; ++$k) {
            $orderSth = $dbh->prepare("insert into orders (user_id, product_id)
                                    values (?,?);");
            $orderSth->execute([array_rand($userIds), array_rand($productIds)]);
        }
    }
}
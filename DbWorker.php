<?php


class DbWorker
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

    /**
     * @return mixed
     */
    public function getClientsBuyThreeDifferentProduct()
    {
        $dbh = $this->connection->con;
        $sth = $dbh->prepare("SELECT u.full_name FROM orders o left join users u on o.user_id = u.id group by 
                                                                                o.user_id having count(*) >= 3");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
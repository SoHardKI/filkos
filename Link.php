<?php


class Link
{
    private DbConnection $connection;

    /**
     * Link constructor.
     * @param DbConnection $connection
     */
    public function __construct(DbConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getFullLink(string $token)
    {
        $dbh = $this->connection->con;
        $sth = $dbh->prepare("select full_url from links where short_url = ? limit 1");
        $sth->execute([$token]);

        return $sth->fetchColumn(0);
    }
}
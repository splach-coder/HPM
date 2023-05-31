<?php

require_once '../config/db.php';

class handleQuery
{

    private $conn;

    public function __construct()
    {
        $db = new db();
        $this->conn = $db->getConnection();;
    }

    public function selectQuery($req, $params = [])
    {
        $requetePreparee = $this->conn->prepare($req);
        $requetePreparee->execute($params);

        return $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execQuery($req, $params = [])
    {
        $requetePreparee = $this->conn->prepare($req);
        $requetePreparee->execute($params);

        return $requetePreparee->rowCount();
    }
}

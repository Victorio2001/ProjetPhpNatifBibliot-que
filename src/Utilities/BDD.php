<?php

namespace MonApp\Utilities;

class BDD
{
    private ?\PDO $connect = null;
    public static array $infoBdd = [];
    private static ?BDD $bdd = null;

    /**
     * @param $connect
     * @param array $infobdd
     * @param $bdd
     */

    private function __construct()
    {
        $host = self::$infoBdd['host'];
        $dbname = self::$infoBdd['dbname'];
        $dsn = "pgsql:host=$host;dbname=$dbname;port=" . self::$infoBdd['port'];
        $this->connect = new \PDO($dsn, self::$infoBdd['user'], self::$infoBdd['pass']);
    }

    public function getConnect(): ?\PDO
    {
        return $this->connect;
    }


    public static function getBdd(): ?BDD
    {
        if(self::$bdd === null){
            self::$bdd = new BDD();
        }
        return self::$bdd;
    }


}
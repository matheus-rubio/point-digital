<?php

namespace App\Classes;

use PDO;

class Conexao
{

    private static $pdo;

    private function __construct()
    {
    }

    public static function connect()
    {
        try {
            self::$pdo = new PDO(
                "pgsql:host=localhost;dbname=postgres;options='--client_encoding=UTF8'",
                'postgres',
                'password'
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return 'ERROR' . $e->getMessage();
        }
        return self::$pdo;
    }
}

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
class dbCon{

    private static $dsn = 'mysql:host=sql2.njit.edu;dbname=kn262';
    private static $user = "kn262";
    private static $password = "NvlYN5s5";
    protected static $db;

    private function __construct()
    {
        try{
            self::$db = new PDO( self::$dsn,
                self::$user,
                self::$password);
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "Connected successfully <br>";
        }
        catch (PDOException $e){
            echo "Connection Error: " . $e->getMessage();
        }

    }
    public static function getConnection() {

        //Guarantees single instance, if no connection object exists then create one.
        if (!self::$db) {
            //new connection object.
            new dbCon();
        }

        //return connection.
        return self::$db;
    }
}



class DataFetch{
    public static function getTableData() {
        $db = dbCon::getConnection();
        $query = 'SELECT * FROM accounts WHERE id <6';
        $stmt = $db->prepare($query);
        $stmt -> execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $rowcount = $stmt->fetchAll();
        echo "Rowcount is ".count($rowcount)."<br>";

        echo "<table style='border: solid 1px black;'>";
        foreach ($rowcount as $record){
            echo "<tr>";
            foreach( $record as $col){
                echo "<td style='width:150px;border:1px solid black;'>".$col."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

}

$program = DataFetch::getTableData();


<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

echo "<table style='border: solid 1px black;'>";


class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 


$servername = "sql2.njit.edu";
$username = "kn262";
$password = "NvlYN5s5";

try {
    $conn = new PDO("mysql:host=$servername;dbname=kn262", $username, $password);
        // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";
    
    $stmt = $conn->prepare("select * from accounts where id <6;");
    $stmt -> execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
      
      $rowcount = $stmt->fetchAll();
      echo "Rowcount is ".count($rowcount)."<br>";

      foreach(new TableRows(new RecursiveArrayIterator($rowcount)) as $k=>$v) 
      { 
        echo $v;

      }
    }  
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage(). "<br>";
     }

$conn = null;
echo "</table>";

?>

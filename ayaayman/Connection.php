
<?php
class Connection{
    protected $dbType, $dbName, $host, $connection, $userName, $userPassword;

    function __construct($dbType, $dbName, $host, $userName, $userPassword)
    {
        $this->dbType = $dbType;
        $this->dbName = $dbName;
        $this->host = $host;
        $this->userName = $userName;
        $this->userPassword = $userPassword;
        $this->connection = new PDO("$this->dbType:host=$this->host;dbname=$this->dbName", $this->userName, $this->userPassword);
    }
    // public function query($sql){
    //     return $this->connection->query($sql);
    // }
    function connection(){
        return $this->connection;
    }
    
}
$database = new Connection (dbType:'mysql',host:"localhost:3307",dbName:"cafeteria",userName:"root",userPassword:"");
$db = $database->connection();
// var_dump($database);
?>
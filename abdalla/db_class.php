<?php
//  
class db{

    private $host="localhost:3307";
    private $dbname="cafeteria";
    private $user="root";
    private $pass="";
    private $connection=null;


    function __construct(){
        $this->connection=new pdo("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->pass);
    
    }
    // function get_connection(){
    //     return $this->connection;
    // }

    function get_all_data($table_name){
      return  $this->connection->query("select * from $table_name");
    }

    function get_users($table_name,$condition){
      return  $this->connection->query("select * from $table_name where $condition");
    }
    // function get_totalPrice($table_name,$condition){
    //   return  $this->connection->query("select total_price from $table_name where $condition");
    // }
    function get_data($table_name,$condition){
        return  $this->connection->query("select * from $table_name where $condition");
    }

    // function delete_data( $table_name,$condition): void{
    //     $this->connection->query("delete from  $table_name where $condition");
    // }

    function insert($table_name,$col,$values){
        $this->connection->query("insert into $table_name ($col) 
        values($values)");
    }

    // function updateQuantity($table_name,$update,$condition){
    //     $this->connection->query("update $table_name set $update
    //     where $condition");
    // }

}
?>
<?php
session_start();
try{
    $db = new PDO("mysql:host=localhost;dbname=games_forum","root","");
}
catch (\PDOException $e){
    throw new \PDOException($e->getMessage(), $e->getCode());
}
?>
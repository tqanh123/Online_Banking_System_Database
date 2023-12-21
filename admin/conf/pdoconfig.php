<?php
$DB_host = "127.0.0.1:3307";
$DB_user = "root";
$DB_pass = "1234";
$DB_name = "online_banking";
try
{
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 $e->getMessage();
}

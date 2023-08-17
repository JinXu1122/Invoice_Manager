<?php 

$dsn = 'mysql:host=localhost;dbname=invoice_manager';
$username = 'jin';
$password = '1234qwer';

try {
  $db = new PDO($dsn, $username, $password);
}catch (PDOException $e) {
  $error = $e->getMessage();
  echo $error;
  exit();
}

$sql = 'SELECT * FROM statuses';
$result = $db->query($sql);
$statuses = $result->fetchAll(PDO::FETCH_COLUMN,1);

$sql = "SELECT number, amount, status, client, email FROM invoices
       JOIN statuses ON invoices.status_id = statuses.id";
$result = $db->query($sql);
$invoices = $result->fetchAll();

/* var_dump($statuses);
var_dump($invoices);    
exit(); */

 

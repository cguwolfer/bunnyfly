<?php 
require_once "../../php_library/db_connection.php";

$user_passwd=$_POST["password"];
$user_email=$_POST["email"];



try {
  $account = DB::queryFirstRow("SELECT * FROM account WHERE email=%s AND password=%s", $user_email,$user_passwd);
  print json_encode($account);
  exit();

} catch(MeekroDBException $e) {
  echo "Error: " . $e->getMessage() . "<br>\n"; 
  echo "SQL Query: " . $e->getQuery() . "<br>\n";
}

?>

<?php 
require_once "../../php_library/db_connection.php";

$user_email=$_REQUEST["email"];


try {
  $isMailExist = DB::queryFirstField("SELECT COUNT( email ) FROM account WHERE email = %s", $user_email);
  if( $isMailExist>0){
    echo 'exist';
  }else{
    echo 'NonExist';
  }

} catch(MeekroDBException $e) {
  echo "Error: " . $e->getMessage() . "<br>\n"; 
  echo "SQL Query: " . $e->getQuery() . "<br>\n";
}
?>
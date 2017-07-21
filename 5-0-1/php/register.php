<?php 
require_once "../../php_library/db_connection.php";

$user_name=$_POST["name"];
$user_passwd=$_POST["password"];
$user_email=$_POST["email"];



try {
  DB::insert('account', array(
    'nickName' => $user_name,
    'password' => $user_passwd,
    'email' => $user_email 
  ));


//成功後跳轉到別頁面
$member_system="../../5-0-2/member.html";
header("Refresh: 0; url=".$member_system);

} catch(MeekroDBException $e) {
  echo "Error: " . $e->getMessage() . "<br>\n"; 
  echo "SQL Query: " . $e->getQuery() . "<br>\n";
}
?>

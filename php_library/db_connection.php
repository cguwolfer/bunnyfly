<?php 
require_once "meekrodb.2.3.class.php";

DB::$user = 'root';
DB::$password = 'mysql';
DB::$dbName = 'bunny';
DB::$host = '127.0.0.1'; //defaults to localhost if omitted
DB::$port = '3306'; // defaults to 3306 if omitted\
DB::$encoding = 'utf8';
DB::$error_handler = false; // since we're catching errors, don't need error handler
DB::$throw_exception_on_error = true;
?>

<?php
	
	/*
	require_once "meekrodb.2.3.class.php";
	
	DB::$user = 'root';
	DB::$password = 'mysql';
	DB::$dbName = 'bunny2';
	DB::$encoding = 'utf8';
	
	$login_account=$_POST["user_account"];
	$login_passwd=$_POST["user_password"];
	
	$member_system="member_system.html";
	$index_html="index.html";
	
	// echo $login_account;
	// echo $login_passwd;
	
	$results = DB::query("SELECT * FROM another WHERE user_account = %s", $login_account);
	foreach ($results as $row) {
		
		if( $row['user_account'] == $login_account ){
			
			if( $row['user_password'] == $login_passwd ){
				
				//success
				
				//session
				session_start();
				$_SESSION["user_account"]=$login_account;
				$_SESSION["user_password"]=$login_passwd;
				
				header("location:".$member_system);
				
				exit();
			}
		}
	}
	
	//fail
	header("location:".$index_html."?"."login_error=登入錯誤");
	// echo $login_account;
	// echo $login_passwd;
	// echo "user_name: " . $row['user_name'] . "<br>";
	// echo "user_account: " . $row['user_account'] . "<br>";
	// echo "user_password: " . $row['user_password'] . "<br>";
	// echo "user_email: " . $row['user_email'] . "<br>";
	// echo "user_address: " . $row['user_address'] . "<br>";
	// echo "-------------<br>";
	*/
	
	// phpinfo();
	
	//PURPOSE: get productName country catalog price brand waitingDays productInfo
	
	print("TEST<br>");
	
	$br="<br>";
	$dir    = './products';
	// $files1 = scandir($dir);
	// $files2 = scandir($dir, 1);

	// print_r($files1);
	// print("<br>");
	// print_r($files2);
	// print("<br>");
	
	global $dir_get;
	$dir_get = false;
	
	iter_dir($dir);
	
	function iter_dir( $dir ){
		
		if ($handle = opendir($dir)) {

			while (false !== ($entry = readdir($handle))) {

				if ($entry != "." && $entry != "..") {
					
					$new_path = $dir."/". $entry;
					
					if( is_dir( $new_path) ){	//is dir
						
						parseDir( $entry );
						
						iter_dir( $new_path );
					}
					else{	//is file
						
						// echo $new_path."<br>";
						
						if( strstr( $new_path, "txt") ){
							
							if( false !== ($result = file($new_path) ) ){
								
								foreach ($result as $key=>$value) {
									
									// echo $value."<br>";
									
									//get NT$
									if( strstr( $value, "NT$" ) ){
										
										// echo $value."<br>";
										// $str = 'In My Cart : 11 12 items';
										preg_match_all('!\d+!', $value, $matches);
										// print($matches[0][0]);
										
										$price = intval($matches[0][0]);
										printf("Price:%d"."<br>", intval($matches[0][0]) );
										
										break;
									}
									// if( strpos( $value ,"商品品牌") ){
										// echo $value."<br>";
										// strtok($value, ":");
										// $brand = strtok(":");
										// printf("Brand=%s"."<br>", $brand );
									// }
								}
								
								if( is_int($price) ){
									
									// echo("IS_INT"."<br>");
									
									// echo($result[$key+1]);
									
									$target = $result[$key+1];
									
									strtok($target, ":");
									$brand = strtok(":");
									printf("Brand=%s"."<br>", $brand );
								}
								
							}
						}
						
					}
				}
			}

			closedir($handle);
		}
	}
	
	function parseDir( $path ){
		
		$country = strtok($path, "_");
		$catalog = strtok("_");
		$seller = strtok("_");
		$p_name = strtok("_");
		
		echo( $country."<br>" );
		echo( $catalog."<br>" );
		echo( $seller."<br>" );
		echo( $p_name."<br>" );
		
		$dir_get = true;
	}
	
?>
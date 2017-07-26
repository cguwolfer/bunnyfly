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
	require_once "../php_library/db_connection.php";
	
	print("TEST<br>");
	
	$br="<br>";
	$dir    = './products';
	// $files1 = scandir($dir);
	// $files2 = scandir($dir, 1);

	// print_r($files1);
	// print("<br>");
	// print_r($files2);
	// print("<br>");
	
	// global $dir_get;
	// $dir_get = false;
	
	global $p_obj;
	$p_obj = null;
	
	global $seller_id;
	$seller_id = 1;
	
	iter_dir($dir);
	
	class productObj{
		
		public $seller_userID;
		public $productName;
		public $country;
		public $catalog;
		public $price;
		public $RemainingQuantity;
		public $brand;
		public $waitingDays;
		public $productInfo;
		public $picture;
		public $picture2;
		
		function saveToDataBase(){
			
			try {
				DB::insert('product', 
					array(
						'seller_userID' => $this->seller_userID,
						'productName' => $this->productName,
						'country' => $this->country,
						'catalog' => $this->catalog,
						'price' => $this->price,
						'RemainingQuantity' => $this->RemainingQuantity,
						'brand' => $this->brand,
						'waitingDays' => $this->waitingDays,
						'productInfo' => $this->productInfo,
						'Description' => "No time to handle these shits...",
						'picture' => $this->picture,
						'picture2' => $this->picture2
					)
				);
				
				return true;
			}
			catch(MeekroDBException $e) {
				echo "Error: " . $e->getMessage() . "<br>\n"; 
				echo "SQL Query: " . $e->getQuery() . "<br>\n";
				return false;
			}
		}
		
		function checkAndSave(){
			
			//check NOT NULL columns
			do{
				if( $seller_userID == null ) break;
				if( $country == null ) break;
				if( $catalog == null ) break;
				if( $price == null ) break;
				if( $RemainingQuantity == null ) break;
				
				//save to db
				if( !saveToDataBase() ){
					
					echo("checkAndSave fail!"."<br>");
				}
				
			}while(false);
			
			$this->resetMe();
		}
		
		function resetMe(){
			
			$this->seller_userID = null;
			$this->productName = null;
			$this->country = null;
			$this->catalog = null;
			$this->price = null;
			$this->RemainingQuantity = null;
			$this->brand = null;
			$this->waitingDays = null;
			$this->productInfo = null;
			$this->picture = null;
			$this->picture2 = null;
		}
		
		function __construct(){
			
			$this->resetMe();
		}
	}
	
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
						
						//jpg file
						if( strstr( $new_path, "jpg") ){
							
							// $p_obj->
						}
						
						//txt file
						if( strstr( $new_path, "txt") ){
							
							echo($new_path."<br>");
							
							if( false !== ($result = file($new_path) ) ){
								
								$price = null;
								
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
		
		$p_obj = new productObj();
		
		if( strlen($country) > 0 ){
			
			$country_num = compare_country( $country );
			
			$p_obj->country = $country_num;
		}
		
		if( strlen($catalog) > 0 ){
			
			$cata_num = compare_catalog( $catalog );
			
			$p_obj->catalog = $cata_num;
		}
		
		if( strlen($seller) > 0 ){
			
			$p_obj->seller_userID = $seller_id++;
		}
		
		if( strlen($productName) > 0 ){
			
			$p_obj->productName = $productName;
		}
		
		$p_obj->RemainingQuantity = 15;
		// echo( $country."<br>" );
		// echo( $catalog."<br>" );
		// echo( $seller."<br>" );
		// echo( $p_name."<br>" );
		
		// $dir_get = true;
	}
	
	function compare_country( $country ){
		
		if( strstr( $catalog, "日本" ) ){
			
			return 1;
		}
		else if( strstr( $catalog, "韓國" ) ){
			
			return 2;
		}
		else if( strstr( $catalog, "泰國" ) ){
			
			return 3;
		}
		else if( strstr( $catalog, "香港" ) ){
			
			return 4;
		}
		else if( strstr( $catalog, "法國" ) ){
			
			return 5;
		}
		else if( strstr( $catalog, "美國" ) ){
			
			return 6;
		}
		else if( strstr( $catalog, "英國" ) ){
			
			return 7;
		}
		else if( strstr( $catalog, "西班牙" ) ){
			
			return 8;
		}
		else {
			
			return 9;
		}
		
	}
	
	function compare_catalog( $catalog ){
		
		if( strstr( $catalog, "名牌精品" ) ){
			
			return 1;
		}
		else if( strstr( $catalog, "流行服飾" ) ){
			
			return 2;
		}
		else if( strstr( $catalog, "美妝保養" ) ){
			
			return 3;
		}
		else if( strstr( $catalog, "運動休閒" ) ){
			
			return 4;
		}
		else if( strstr( $catalog, "居家生活" ) ){
			
			return 5;
		}
		else if( strstr( $catalog, "異國美食" ) ){
			
			return 6;
		}
		else if( strstr( $catalog, "3C家電" ) || strstr( $catalog, "家電" ) ){
			
			return 7;
		}
		else if( strstr( $catalog, "寵物用品" ) ){
			
			return 8;
		}
		else if( strstr( $catalog, "媽咪寶貝" ) ){
			
			return 9;
		}
		else {
			
			return 10;
		}
		
	}
	
?>
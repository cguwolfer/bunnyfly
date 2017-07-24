
/*
請自行建立DB Name
*/

CREATE TABLE account(
	userID INT AUTO_INCREMENT NOT NULL,
	password CHAR(15) NOT NULL,
	nickName CHAR(40) NOT NULL,
	email CHAR(30) NOT NULL,
	userPicture MEDIUMBLOB NULL,
	mallPicture MEDIUMBLOB NULL,
	mallDescription VARCHAR(300) NULL,
	address VARCHAR(50) NULL,
	countrys SET('1','2','3','4','5','6','7','8','9') NULL,
	payments SET('1','2') NULL,
	deliverys SET('1','2') NULL,
	PRIMARY KEY (userID)
);


CREATE TABLE product(
	productID INT AUTO_INCREMENT NOT NULL,
	seller_userID INT NOT NULL,
	productName CHAR(40) NULL,
	country ENUM('1','2','3','4','5','6','7','8','9') NOT NULL,
	catalog ENUM('1','2','3','4','5','6','7','8','9','10') NOT NULL,
	price NUMERIC(10, 2) NOT NULL,
	RemainingQuantity TINYINT NOT NULL,
	brand CHAR(30) NULL,
	waitingDays CHAR(30) NULL,
	productInfo TEXT NULL,
	Description TEXT NULL,
	picture MEDIUMBLOB NULL,
	PRIMARY KEY (productID)
);


CREATE TABLE orders(
	orderID INT AUTO_INCREMENT NOT NULL,
	buyer_userID INT NOT NULL,
	seller_userID INT NOT NULL,
	productID INT NOT NULL,
	appointingDate DATETIME NOT NULL,
	payment ENUM('1','2') NOT NULL,
	delivery ENUM('1','2') NOT NULL,
	quantity TINYINT NOT NULL,
	state TINYINT DEFAULT 0 NOT NULL,			/*--0:買家送出代購單 1:買家確認代購 2:買家回絕代購*/
	Evaluation TINYINT DEFAULT 0 NOT NULL,		/*0:未評價，評價等級：1-5*/
	PRIMARY KEY (orderID)
);

/*
國別(country)：
	1 日本
	2 韓國
	3 泰國
	4 香港
	5 法國
	6 美國
	7 英國
	8 西班牙
	9 其他
	
產品類別(catalog)：
	1 名牌精品
	2 流行服飾
	3 美妝保養
	4 運動休閒
	5 居家生活
	6 異國美食
	7 3C家電
	8 寵物用品
	9 媽咪寶貝
	10 其他	
	
付款方式(payment)：
	1 轉帳匯款
	2 貨到付款

寄送方式(delivery)：
	1 轉帳匯款
	2 貨到付款
*/

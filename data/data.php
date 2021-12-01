<?php
$DB_create = <<< SQL
CREATE DATABASE IF NOT EXISTS REQUESTION DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
grant all on REQUESTION.* to 'staff'@'localhost' identified by 'password';
USE REQUESTION;
SQL;

$TB_create = <<< SQL
CREATE TABLE IF NOT EXISTS ACCOUNT(
	AC_ID int auto_increment PRIMARY KEY, 
	AC_NAME varchar(15) NOT NULL unique, 
	AC_PASS varchar(100) NOT NULL,
	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	self_introduction TEXT,
	user_icon varchar(100) 
);

CREATE TABLE IF NOT EXISTS follow(
	self_id INT NOT NULL,
	partner_id INT NOT NULL,
	PRIMARY KEY(self_id, partner_id),
	FOREIGN KEY (self_id) REFERENCES account(ac_id) ON DELETE CASCADE,
	FOREIGN KEY (partner_id) REFERENCES account(ac_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS chat(
	id int AUTO_INCREMENT PRIMARY KEY,
	chat text NOT NULL,
	self_id int NOT NULL,
	partner_id int NOT NULL,
	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (self_id) REFERENCES follow(self_id) ON DELETE CASCADE,
	FOREIGN KEY (partner_id) REFERENCES follow(partner_id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS QUESTION(
	QUE_ID int auto_increment PRIMARY KEY,
	AC_ID int NOT NULL,
	QUE varchar(500) NOT NULL,
	CAT_ID int NOT NULL,
	SPEED int NOT NULL,
	QUE_TIME varchar(20) NOT NULL,
	FOREIGN KEY(AC_ID) REFERENCES ACCOUNT(AC_ID)
);

CREATE TABLE IF NOT EXISTS ANSWER(
	ANS_ID int auto_increment PRIMARY KEY,
	QUE_ID int NOT NULL,
	AC_ID int NOT NULL,
	ANS varchar(500) NOT NULL,
	RATE int NOT NULL,
	ANS_TIME varchar(20) NOT NULL,
	FOREIGN KEY(QUE_ID) REFERENCES QUESTION(QUE_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS QUEIMG(
	QUEIMG_ID int auto_increment PRIMARY KEY,
	QUE_ID int NOT NULL,
	QUEIMG_PASS varchar(50) NOT NULL,
	FOREIGN KEY(QUE_ID) REFERENCES QUESTION(QUE_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ANSIMG(
	ANSIMG_ID int auto_increment PRIMARY KEY,
	ANS_ID int NOT NULL,
	ANSIMG_PASS varchar(50) NOT NULL,
	FOREIGN KEY(ANS_ID) REFERENCES ANSWER(ANS_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS RESPONSE(
	RES_ID int auto_increment PRIMARY KEY,
	ANS_ID int NOT NULL,
	AC_ID int NOT NULL,
	RES varchar(300) NOT NULL,
	RES_TIME varchar(20) NOT NULL,
	FOREIGN KEY(ANS_ID) REFERENCES ANSWER(ANS_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CATEGORY(
	CAT_ID int auto_increment PRIMARY KEY,
	CAT varchar (8) NOT NULL
);

CREATE TABLE IF NOT EXISTS BMQUE(
	BMQUE_ID int auto_increment primary key,
	AC_ID int not null,
	QUE_ID int not null,
	foreign key(QUE_ID) references QUESTION(QUE_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS BMCATEGORY(
	AC_ID int not null,
	CAT_ID int not null,
	PRIMARY KEY(AC_ID, CAT_ID),
	foreign key(AC_ID) references ACCOUNT(AC_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS TAG(
	TAG_ID int auto_increment PRIMARY KEY,
	QUE_ID int NOT NULL,
	TAG varchar(8) NOT NULL,
	FOREIGN KEY(QUE_ID) REFERENCES QUESTION(QUE_ID) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS chat_notification(
	id int auto_increment PRIMARY KEY,
	self_id int NOT NULL,
	partner_id int NOT NULL,
	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (self_id) REFERENCES follow(self_id) ON DELETE CASCADE,
	FOREIGN KEY (partner_id) REFERENCES follow(partner_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ANSWER_notification(
	id int auto_increment PRIMARY KEY,
	AC_ID int NOT NULL,
	ANS_ID int NOT NULL,
	is_read  bit,
	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (AC_ID) REFERENCES ACCOUNT(AC_ID) ON DELETE CASCADE,
	FOREIGN KEY (ANS_ID) REFERENCES ANSWER(ANS_ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS RESPONSE_notification(
	id int auto_increment PRIMARY KEY,
	AC_ID int NOT NULL,
	RES_ID int NOT NULL,
	is_read  bit,
	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (AC_ID) REFERENCES ACCOUNT(AC_ID) ON DELETE CASCADE,
	FOREIGN KEY (RES_ID) REFERENCES RESPONSE(RES_ID) ON DELETE CASCADE
)



SQL;
try {
    // DB接続
    $pdo = new PDO(
        // ホスト名
        'mysql:host=localhost;',
        // ユーザー名
        'staff',
        // パスワード
        'password',
        // レコード列名をキーとして取得させる
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
 
    // SQL文をセット
    $DB_create = $pdo->prepare($DB_create);
    $DB_create->execute();
 
} catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
     
} finally {
    // DB接続を閉じる
    $pdo = null;
}
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
$TB_create = $pdo -> prepare($TB_create);
$TB_create->execute();
?>
drop database if exists REQUESTION;
create database REQUESTION default character set utf8 collate utf8_general_ci;
grant all on REQUESTION.* to 'staff'@'localhost' identified by 'password';
use REQUESTION;

create table ACCOUNT(
	AC_ID int auto_increment primary key, 
	AC_NAME varchar(15) not null unique, 
	AC_PASS varchar(100) not null,

	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	self_introduction TEXT,
	user_icon varchar(100) 
);

CREATE TABLE follow(
	self_id INT NOT NULL,
	partner_id INT NOT NULL,
	PRIMARY KEY(self_id,partner_id),
	FOREIGN KEY (self_id) REFERENCES account(ac_id) ON DELETE CASCADE,
	FOREIGN KEY (partner_id) REFERENCES account(ac_id) ON DELETE CASCADE
);

create table QUESTION(
	QUE_ID int auto_increment primary key,
	AC_ID int not null,
	QUE varchar(500) not null,
	CAT_ID int not null,
	SPEED int not null,
	QUE_TIME varchar(20) not null,
	foreign key(AC_ID) references ACCOUNT(AC_ID)
);

create table ANSWER(
	ANS_ID int auto_increment primary key,
	QUE_ID int not null,
	AC_ID int not null,
	ANS varchar(500) not null,
	RATE int not null,
	ANS_TIME varchar(20) not null,
	foreign key(QUE_ID) references QUESTION(QUE_ID) ON DELETE CASCADE
);

create table QUEIMG(
	QUEIMG_ID int auto_increment primary key,
	QUE_ID int not null,
	QUEIMG_PASS varchar(50) not null,
	foreign key(QUE_ID) references QUESTION(QUE_ID) ON DELETE CASCADE
);

create table BMQUE(
	BMQUE_ID int auto_increment primary key,
	AC_ID int not null,
	QUE_ID int not null,
	foreign key(QUE_ID) references QUESTION(QUE_ID) ON DELETE CASCADE
);

create table ANSIMG(
	ANSIMG_ID int auto_increment primary key,
	ANS_ID int not null,
	ANSIMG_PASS varchar(50) not null,
	foreign key(ANS_ID) references ANSWER(ANS_ID) ON DELETE CASCADE
);

create table RESPONSE(
	RES_ID int auto_increment primary key,
	ANS_ID int not null,
	AC_ID int not null,
	RES varchar(300) not null,
	RES_TIME varchar(20) not null,
	foreign key(ANS_ID) references ANSWER(ANS_ID) ON DELETE CASCADE
);

create table CATEGORY(
	CAT_ID int auto_increment primary key,
	CAT varchar (8) not null
);

create table BMCATEGORY(
	AC_ID int not null,
	CAT_ID int not null,
	foreign key(AC_ID) references ACCOUNT(AC_ID) ON DELETE CASCADE
);

create table TAG(
	TAG_ID int auto_increment primary key,
	QUE_ID int not null,
	TAG varchar(8) not null,
	foreign key(QUE_ID) references QUESTION(QUE_ID) ON DELETE CASCADE
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

CREATE TABLE IF NOT EXISTS chat_notification(
	id int auto_increment PRIMARY KEY,
	self_id INT NOT NULL,
	partner_id INT NOT NULL,
	timecreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (self_id) REFERENCES follow(self_id) ON DELETE CASCADE,
	FOREIGN KEY (partner_id) REFERENCES follow(partner_id) ON DELETE CASCADE
);

insert into ACCOUNT values(null, 'admin', 'Password1',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'kumaki', 'BearTree1',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'torii', 'BirdStay2',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'saginuma', 'EgretPond3',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'washio', 'EagleTail4',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'ushijima', 'CowIsland5',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'souma', 'PhaseHorse6',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'sarutobi', 'MonkeyFly7',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'inuyama', 'DogMountain8',NULL,NULL,NULL);
insert into ACCOUNT values(null, 'inokuchi', 'BoarMouse9',NULL,NULL,NULL);

INSERT INTO CATEGORY(CAT) 
VALUES
('その他'),
('仕事'),
('趣味'),
('サブカルチャー'),
('エンタメ'),
('スポーツ'),
('健康、美容'),
('住宅、家事'),
('ペット'),
('テクノロジー'),
('法律相談'),
('言葉、地域'),
('学校、子育て'),
('恋愛'),
('政治、社会問題'),
('ニュース'),
('学問、一般教養'),
('公共施設、役所'),
('マナー、手紙'),
('イラスト'),
('ファッション'),
('雑談');

INSERT INTO follow VALUE (1,2);
INSERT INTO follow VALUE (1,3);
INSERT INTO follow VALUE (1,4);
INSERT INTO follow VALUE (1,5);
INSERT INTO follow VALUE (1,6);
INSERT INTO follow VALUE (1,7);
INSERT INTO follow VALUE (2,1);
INSERT INTO follow VALUE (2,3);
INSERT INTO follow VALUE (3,1);
INSERT INTO follow VALUE (4,1);
INSERT INTO follow VALUE (5,1);
INSERT INTO follow VALUE (8,1);

INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO1",1, 2);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO2",1, 3);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO3",1, 4);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO4",1, 2);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO5",1, 5);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO6",1, 3);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO7",1, 5);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO8",5, 1);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO9",4, 1);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO10",3, 2);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO11",2, 1);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO12",1, 5);
INSERT INTO chat(chat, self_id, partner_id) VALUES ("HELLOOOOO13",2, 1);
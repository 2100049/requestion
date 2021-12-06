
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
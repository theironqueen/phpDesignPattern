create table contacts.contact (
	id int(10) unsigned not null AUTO_INCREMENT,
	ownerid int(10) unsigned not null,
	firstname tinytext not null,
	middlename tinytext not null,
	lastname tinytext not null,
	PRIMARY KEY (id)
	) ENGINE=InnoDB;
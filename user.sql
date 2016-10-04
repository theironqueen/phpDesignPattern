create table contacts.user ( 
	id int(10) unsigned not null AUTO_INCREMENT,
	username varchar(64) not null,
	password varchar(40) not null,
	admin tinyint(3) unsigned not null default 0,
	primary key (id)
) ENGINE=InnoDB;
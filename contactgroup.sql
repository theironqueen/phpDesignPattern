create table contacts.contactgroup (
	id int(10) unsigned not null AUTO_INCREMENT,
	contactid int(10) unsigned not null,
	label text not null,
	PRIMARY KEY (id)
	) ENGINE=InnoDB;
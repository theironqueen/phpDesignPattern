create table contacts.contactmethod (
	id int(10) unsigned not null AUTO_INCREMENT,
	contactgroupid int(10) unsigned not null,
	type tinytext not null,
	value text not null,
	PRIMARY KEY (id)
	) ENGINE=InnoDB;
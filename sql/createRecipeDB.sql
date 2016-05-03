//create database

DROP TABLE IF EXISTS CHEF;
DROP TABLE IF EXISTS A_RI;
DROP TABLE IF EXISTS A_RU;
DROP TABLE IF EXISTS A_INGREDIENT;
DROP TABLE IF EXISTS A_MEASURE;
DROP TABLE IF EXISTS A_RECIPE;

CREATE TABLE CHEF(
	id     int not null auto_increment,
	firstName  varchar(20) not null,
	lastName   varchar(20) not null,
	password   char(40) not null,
	email     varchar(50) not null,
	PRIMARY KEY(id)
) engine = InnoDB;


CREATE TABLE A_RECIPE(
	id   int not null auto_increment,
	r_name   varchar(25) not null,
	url   varchar(200) not null
	PRIMARY KEY(id)
) engine = InnoDB;

CREATE TABLE A_INGREDIENT(
	id int not null auto_increment,
	i_name  varchar(50) not null,
	PRIMARY KEY(id)
) engine = InnoDB;

CREATE TABLE A_MEASURE(
	id int not null auto_increment,
	m_name varchar(20) not null,
	PRIMARY KEY(id)
) engine = InnoDB;

CREATE TABLE A_RI(
	recipe_id int not null,
	ingredient_id int not null,
	measure_id int,
	amount float(4) not null,
	FOREIGN KEY (recipe_id) references A_RECIPE(id),
	FOREIGN KEY (ingredient_id) references A_INGREDIENT(id),
	FOREIGN KEY (measure_id) references A_MEASURE(id)
) engine = InnoDB;

CREATE TABLE A_RU(
	user_id int not null,
	recipe_id int not null,
	FOREIGN KEY(user_id) references CHEF(id),
	FOREIGN KEY(recipe_id) references A_RECIPE(id)
) engine = InnoDB;

	
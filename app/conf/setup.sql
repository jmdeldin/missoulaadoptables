set FOREIGN_KEY_CHECKS = 0;

/*
 * table: states
 */
drop table if exists states;
create table states(
    id      int auto_increment,
    abbr    char(2)     not null,
    name    varchar(21) not null,
    primary key(id)
) engine = InnoDB;


/*
 * table: shelters
 */
drop table if exists shelters;
create table shelters(
    id              int auto_increment,
    name            varchar(60)  not null,
    uri             varchar(255) not null,
    street_address  varchar(35)  not null,
    city            varchar(20)  not null,
    postal_code     int          not null,
    phone           varchar(10)  not null,
    email           varchar(100)     null,
    hours           varchar(100)     null,
    state_id        int          not null,
    -- foreign key: state_id (states.id)
    foreign key(state_id) references states(id)
        on update restrict
        on delete restrict,
    primary key(id)
) engine = InnoDB;


/*
 * table: common_names
 */
drop table if exists common_names;
create table common_names(
    id   int         auto_increment,
    name varchar(15) not null,
    primary key(id, name)
) engine=InnoDB;


/*
 * table: animals
 */
drop table if exists animals;
create table animals(
    id             int               auto_increment,
    entry_date     date                  null, -- we insert a null in here to get the current date (MySQL workaround)
    scrape_date    timestamp         not null default CURRENT_TIMESTAMP,
    name           varchar(45)       not null,
    description    text              not null,
    breed          varchar(45)       not null,
    sex            char(1)           not null,
    fixed          boolean           not null,
    age            varchar(11)       not null, -- TODO: Try to convert the age into an int at scrape time
    color          varchar(45)           null,
    active         boolean           not null default true,
    impound_num    varchar(8)            null, -- TODO: Remove this field after updating the scraper

    -- foreign key: common_name_id (common_names.id)
    common_name_id int               not null,
    foreign key(common_name_id) references common_names(id)
        on update restrict
        on delete restrict,

    -- foreign key: shelter_id (shelters.id)
    shelter_id     int               not null,
    foreign key(shelter_id) references shelters(id)
        on update restrict
        on delete restrict,
    primary key(id)
) engine = InnoDB
  charset utf8
  collate utf8_general_ci;


/*
 * table: pages
 *
 * This table is used for storing the scrapeable pages.
 */
drop table if exists shelter_pages;
create table shelter_pages(
    uri            varchar(255) not null,
    -- foreign key: shelter_id (shelters.id)
    shelter_id int              not null,
    foreign key(shelter_id) references shelters(id)
        on update restrict
        on delete restrict,

    -- foreign key: common_name_id (common_names_id)
    common_name_id int          not null,
    foreign key(common_name_id) references common_names(id)
        on update restrict
        on delete restrict,
    primary key(shelter_id, common_name_id)
) engine = InnoDB;

set FOREIGN_KEY_CHECKS = 1;


/*
 * view: search_index
 *
 * This view is a denormalized view of our data for easier searches.
 */
drop view if exists search_index;
create view search_index
as
    select animals.*, common_names.name as common_name
    from animals
        inner join common_names on
            animals.common_name_id = common_names.id
    where animals.active = true;


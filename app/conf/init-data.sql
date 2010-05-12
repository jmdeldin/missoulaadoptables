-- Initial data for our test database

/*
 * US States
 *
 * "traditional" US states included (no military bases or
 * territories included)
 * @link http://www.usps.com/ncsc/lookups/usps_abbreviations.html
 */
insert into states(name, abbr)
values ("Alaska", "AK"), ("Alabama", "AL"), ("Arizona", "AZ"),
       ("Arkansas", "AR"), ("California", "CA"), ("Colorado", "CO"),
       ("Connecticut", "CT"), ("Delaware", "DE"), ("District of Columbia", "DC"),
       ("Florida", "FL"), ("Georgia", "GA"), ("Hawaii", "HI"),
       ("Idaho", "ID"), ("Illinois", "IL"), ("Indiana", "IN"),
       ("Iowa", "IA"), ("Kansas", "KS"), ("Kentucky", "KY"),
       ("Louisiana", "LA"), ("Maine", "ME"), ("Maryland", "MD"),
       ("Massachusetts", "MA"), ("Michigan", "MI"), ("Minnesota", "MN"),
       ("Mississippi", "MS"), ("Missouri", "MO"), ("Montana", "MT"),
       ("Nebraska", "NE"), ("Nevada", "NV"), ("New Hampshire", "NH"),
       ("New Jersey", "NJ"), ("New Mexico", "NM"), ("New York", "NY"),
       ("North Carolina", "NC"), ("North Dakota", "ND"), ("Ohio", "OH"),
       ("Oklahoma", "OK"), ("Oregon", "OR"), ("Pennsylvania", "PA"),
       ("Rhode Island", "RI"), ("South Carolina", "SC"), ("South Dakota", "SD"),
       ("Tennessee", "TN"), ("Texas", "TX"), ("Utah", "UT"),
       ("Vermont", "VT"), ("Virginia", "VA"), ("Washington", "WA"),
       ("West Virginia", "WV"), ("Wisconsin", "WI"), ("Wyoming", "WY");

/*
 * Common Names
 */
insert into common_names(name)
values("dog"), ("cat");

/*
 * Shelters
 */
insert into shelters(name, uri, street_address, city, state_id, postal_code, phone, email, hours)
values("Missoula Animal Control",
       "http://www.montanapets.org/mac/",
       "6700 Butler Creek Rd.",
       "Missoula",
       (select id from states where abbr = "MT"),
       59808,
       "4065417387",
       "rocke@bigsky.net",
       "10-5:30 PM Monday through Friday; 12-4 PM Saturday"),
      ("Humane Society of Western Montana",
       "http://www.myhswm.org/",
       "5930 Hwy 93 South",
       "Missoula",
       (select id from states where abbr = "MT"),
       59804,
       "4065493934",
       "adoptions@myhswm.org",
       "1-6 PM Tuesday–Friday; 11-4 pm Saturday");


/*
 * Scrapeable pages
 */
insert into shelter_pages(shelter_id, common_name_id, uri)
values(1, (select id from common_names where name = "dog"),
       "http://www.montanapets.org/mac/residentdog.html");

/*
 * Animals
 */
insert into animals(entry_date, name, description,
                    breed, sex, fixed, age, color, common_name_id, shelter_id,
                    active, impound_num)
values("2010-04-03",
       "Suecm",
       "OWNER TURN IN: Suecm (whose name is Salish for \"lightening\") was left with us because her owner simply couldn\'t care for her anymore. She\'s a sweet, shy little lady who loves to be held and will sit still to be petted just as long as anyone is interested.",
       "Chihuahua X",
       'F',
       false,
       "8 months",
       "sable/white",
       (select id from common_names where name = "dog"),
       (select id from shelters where name = "Missoula Animal Control"),
       true,
       "A00001"),

      ("2010-04-03",
       "Cassie",
       "OWNER TURN IN: Cassie knows she\'s a bird dog, so she can\'t understand why she wasn\'t allowed to hunt her owner\'s chickens. She just wanted to chase them a little and then carry them around in her mouth, but the chickens (and her owner) didn\'t appreciate that kind of attention. This sweet, loving lady needs a chicken-free home and lots of people to give her belly rubs.",
       "Lab",
       'F',
       true,
       "3 years",
       "tan nylon",
       (select id from common_names where name = "dog"),
       (select id from shelters where name = "Missoula Animal Control"),
       true,
       "A00002");

use musicsphere;
alter table registration add column id int auto_increment primary key;
alter table favourites add column id int auto_increment primary key;
alter table recentlyplayed add column id int auto_increment primary key;
alter table rating add column id int auto_increment primary key;
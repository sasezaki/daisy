#daisy

sandbox for weierophinney/hal

## ATTENSION
This project is Work in Progress...

## Setup

```
mkdir data/db
sqlite3 data/db/daisy.sqlite3

sqlite> create table post(id integer primary key, title, body);
sqlite> create table comment(id integer primary key, post_id integer, body);
sqlite> .exit
```

## Notes
Inspired from 
http://qiita.com/koriym/items/1caf2a2a13f497755c88
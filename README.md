# FormstackJuniorDEVProject

## Introduction
Framework application assignment that Creates, Reads, Updates, Deletes, Downloads and Exports CSV created Documents.

## Requirements
You need to manually create the database and table used for the project.
Please use the included file schema.sql file that only contains the table structure.
Database settings need to be updated in the file: config/db.php<br>
DB should be named: "project" and table "documents".


## How to use
Clone or download this repository, with a web server running open a web browser and
make use of the CRUD operations:<br />

| Description | URL  |
| --- | --- |
|*__MAIN MENU__* |``` http://localhost:8080/``` |
|  | |
|*__CREATE__* |``` http://localhost:8080/documents/create```|
| |  |
|*__READ__* | ```http://localhost:8080/documents/view?id=[documentId]``` |
|  |  |
|*__UPDATE__*| ```http://localhost:8080/documents/update?id=[documentId]``` |
|  |  |
|*__DELETE__* | ```http://localhost:8080/documents/delete?id=[documentId]``` |
|  |  |
|*__GENERATE__*| ```http://localhost:8080/documents/generate?id=[documentId]``` |
|  |  |
|*__EXPORT__*| ```http://localhost:8080/documents/upload?id=[documentId]``` |


If you prefer to use the *__REST API__* services:

A folder called Postman inside the repository includes examples of *__GET, POST, PUT and DELETE__* requests.
Just import the .json file to Postman.

You can also use __*CURL__*, check these examples:

*__GET /doc__* 
```
curl -X GET \
  http://localhost:8080/doc \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'cache-control: no-cache'
```
*__GET /doc/:id__* 
```
curl -X GET \
  http://localhost:8080/doc/1 \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'Postman-Token: a0aa793b-3874-42ad-b801-8532f5747184' \
  -H 'cache-control: no-cache'

```
*__PUT /doc/:id__* 
```
curl -X PUT \
  http://localhost:8080/doc/4 \
  -H 'Accept: */*' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Cache-Control: no-cache' \
  -H 'Connection: keep-alive' \
  -H 'Content-Length: 67' \
  -H 'Content-Type: application/json' \
  -H 'cache-control: no-cache' \
  -d '{
    "name": "FileName",
    "key_values": "a:1,b:2,c:3,d:4,e:5"
}'
```
*__DELETE /doc/:id__* 
```
curl -X DELETE \
  http://localhost:8080/doc/1 \
  -H 'Postman-Token: 46090c0c-3230-4acc-b7b5-fd412d473d41' \
  -H 'cache-control: no-cache'
```





## Notes
The project was developed using the following:
* Yii2 Framework version 2.0 running the PHP built-in server integration
* PHP 7.2.23 
* MySQL 8.0.17

The functionalities for this project are:<br />
* The web application allows to store a set of key/value pairs and a document name in the DB.<br />
* It also stores metadata (date of document created, exported, updated)<br />
* Lists all files with metadata fields.<br />
* Updates name and key/ value pairs for existing document.<br />
* When updating the document it updates last modification date.<br />
* Allows to delete document.<br />
* Allows to export stored data as a CSV comma separated file.<br />

## BONUS<br />
* Exports stored data (CSV file) to Dropbox <br />
* Gets public URL from Dropbox <br />







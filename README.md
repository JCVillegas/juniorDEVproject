# FormstackJuniorDEVProject

## Introduction
Framework application assignment that Creates, Reads, Updates, Deletes, Downloads and Exports CSV created Documents.
Created under Yii2 Framework.

##Requirements
You need to manually install the database and table used for the project.
You can use the included schema.sql file.


##How to use
Clone or download this repository, with a web server running open a web browser and
make use of the CRUD operations:<br />

*__MAIN MENU__   - http://localhost:8080/<br />

*__CREATE__      - http://localhost:8080/documents/create<br />
*__READ__        - http://localhost:8080/documents/view?id=[documentId]<br />
*__UPDATE__      - http://localhost:8080/documents/update?id=[documentId]<br />
*__DELETE__      - http://localhost:8080/documents/delete?id=[documentId]<br />
*__GENERATE__    - http://localhost:8080/documents/generate?id=[documentId]<br />
*__EXPORT__      - http://localhost:8080/documents/upload?id=[documentId]<br />


## Notes
The project was developed under Yii2 Framework running the PHP built-in server integration using PHP 7.2.23 and MySQL 8.0.17 <br />
The functionalities for this project are:<br />
1 The web application allows to store a set of key/value pairs and a document name in the DB.<br />
2 It also stores metadata (date of document created, exported, updated)<br />
3 Lists all files with metadata fields.<br />
4 Updates name and key/ value pairs for existing document.<br />
5 When updating the document it updates last modification date.<br />
6 Allows to delete document.<br />
7 Allows to export stored data as a CSV comma separated file.<br />

##BONUS<br />
* Exports stored data (CSV file) to Dropbox <br />
* Gets publi URL from Dropbox <br />







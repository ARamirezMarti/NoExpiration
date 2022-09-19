# NoExpiration App

## Description

This repository contains the code for the NoExpiration application.This is divided into 3 parts.


### Docs

Here all the documentation of the application will be stored. For now it only contains the entity-relationship diagram of the database.

### Back-end


The server part is made with Laravel 9. 
Tests have also been carried out on all implemented endpoints.
The API is fully functional and can be deployed via docker-compose that you can find in this folder.

Last added features :
  - [x] Days left for each product is calculated everyday by a cron command called "expeditionHandler.php"
  - [x] Queued Emails : A job is created to calculate the day date and the alerts dates for each product. If the date is the same an 
  alert is sended to the client via email. The job dispatch the email to Queue  that sends the email to the client.

TODO:
  - [x] Create description field for Inventories
  - [ ] Create controller for:
  
        - [x] Alerts,
        - [x] Companies
        - [x] Product type.
        
  - [x] Dockerize
  - [x] Test added implementations.
  - [ ] Exports the list of products into an excel file
  - [ ] Fix the template for the alert email
  
  
### Front-end

The front is a mobile application made with Ionic. For now, you can try the mobile app using "npm start" like a node project to see the application in your browser. In the feature will be compiled and added to play store just for show pourposes.

The client is fully functional.

Contains the user registration and login. A landing page to show all the inventories that client has created, also, the client can create products and see the table with all the producs added to the inventory.

TODO:
  - [ ] use .env for  secret keys
  - [ ] add image on the creation of the product.
  

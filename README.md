# symfony-catalog-poc
##### A simple fictional catalog of shoes and T-shirts

The goal is to discover symfony, doctrine and API platform

Objectives:
- [x] Creating the database with doctrine
- [x] Creating forms to browse the catalog (front-office)
- [x] Creating a login system
- [x] Creating forms to add products to the catalog (back-office)
- [x] Exposing the catalog via API
- [ ] Make the create product form dynamic
- [ ] Back-end polish
- [ ] Front-end polish
  
The app uses symfony server to allow for easy and local deployment and is not designed for production  
The app uses a local mySQL environment. Fixtures are available to initialize and populate the database with test data
The search form can search for one term, in priority within the product name, then in the product tags
You will need to create a user (using the register form) and add roles manually in the database

Issues:
- The mySQL server driver could not be found. Fix: uncommented a line in my local PHP install php.ini file

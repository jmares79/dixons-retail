# Dixons 

## Objective

To perform a series of exercises in order to show proficiency in algorithms and good practices in general.

## Structure of the project

### Standard Symfony structure

The project is based on [Symfony framework](https://symfony.com/), version 4+, and implements for 
the first exercises as a console CLI commands.

The reason behind this is to show the ability to do that without a full MVC application, just as a Linux console, an at the same time to proof that good design practices doesn't need any framework or scaffolding structure per se.

Dependency injection was used when necessary, alongside SOLID principles with interfaces, SRP, etc so, if at any time the specific service core algorithms must be changed, it can be easily done by implementing a new service and implementing the interface method, thus inject it like the old service.

### Code structure

1. The company uses 2 (Or more in the future) data models/repositories:
	* ElasticSearch
	* MySQL
	* TBD in the future

They want to access data in an uniform way, accessing it mainly from ElasticSearch and, if that's not working, fetch data from MySQL.

```
**IMPORTANT NOTE**: The test provides 3 files as examples or for fixed use and starting point. Although the ProductController is ok, the 2 interfaces are not. 
The point of an interface is, in the end, to make the code flexible, and as each interface implements a different signature, the code becomes fixed, and hard to maintain and extend.

The solution is, from my point of view, to create a _new_ interface _CommonSearchDriver_ that provides a single entry point for fetching data. Then, all and any new driver has to implement this interface, 'hiding' the custom fixed way of fetching behind this method. That was done in the code.
```

That part of the logic was done in [FetcherService](https://github.com/jmares79/dixons-retail/blob/master/src/Services/FetcherService.php) by simply selecting the one that is enabled. 

As this was done with a simple if-else, is not meant for deploying in a production environment, as a proper _ConfigurationService_ has to be created (Ommited here for time constraints) which fully parses the configuration file/repository and logs any potential issue and returns an error if anything could be malfunctioning.

2. The company uses a cache system, which has to be used before the physical data model, for efficiancy purposes.

3. Also a tracking system is needed. In order of tracking which are the more successful items that people buy/fetches, so that have to be saved too (In a text file for now), but open to new devices in the future.

## Installation steps

Clone the repo in the web server document root (For the CLI commands) and it will be ready to use.
PHP is required to be installed.

## Usage

`php bin/console` will show the full options of Symfony console, among them there will be 2:

* `app:product-data <id>`: Retrieves the product details as JSON by its ID

So, in order to execute them should be for example: `php bin/console app:product-data 4` (Id could be a full string)

## Important notes:






The problem:

As the task is forcing me to implement 2 different interfaces, instead of a better idea of only one, with a common signature like "findById($id)" in all the interfaces (That would be an improvement to make the code easier), I added an extra layer in the shape of a _RepositoryService_, which will be the one in charge of reading the data access and, if ElasticSearch is not working, then seek MySQL data model.
Important points:

1) Company uses 2 (Or more in the future) data models/repositories:

a) ElasticSearch
b) MySQL
c) TBD in the future

They want to access data in an uniform way, accessing it mainly from ElasticSearch and, if that's not working, fetch data from MySQL.

However, they also want to have a cache, so we should check there first, and only then query the physical devices.

2) A tracking system is needed for tracking which are the more successful items that people buy/fetches, so that have to be saved too, in a text file for now, but open to new devices in the future.

The problem:

As the task is forcing me to implement 2 different interfaces, instead of a better idea of only one, with a common signature like "findById($id)" in all the interfaces (That would be an improvement to make the code easier), I added an extra layer in the shape of a _RepositoryService_, which will be the one in charge of reading the data access and, if ElasticSearch is not working, then seek MySQL data model.
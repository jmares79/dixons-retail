Important points:


1) Company uses 2 (Or more in the future) data models/repositories:

a) ElasticSearch
b) MySQL
c) TBD in the future

They want to access data in an uniform way, accessing it mainly from ElasticSearch and, if that's not
working, fetch data from MySQL.

However, they also want to have a cache, so we should check there first, and only then query the physical
devices.

A tracking system is needed for tracking which are the more successful items that people buy/fetches,
so that have to be saved too, in a text file for now, but open to new devices in the future.



ApiHistogram
============

ApiHistogram aims to create a history of your API responses and stores
the response in your database, so you can analyse variable data coming
from any web service that does not offer historical data, or to create
your own historical data based on a third party service.

--------------------------------------------

Installation
============

- To use this Standard version, what you need to do first is to clone
the repository.
- Then call ```composer install``` or ```composer update``` to get all
the dependencies set.
- Make sure that the ```ApiHistogramBundle``` is registered in
the ```AppKernel```.
- Fill the currency_url from the ```parameters``` file.
    + I used http://apilayer.net/api/live so the Cleaner given in the
    config file is design for it.
    + If you change the web service make sure you define the desired
    ```CleanerInterface``` instance.
- Make sure you set your database's configuration in the parameter's
file.
- You're done!

---------

Description
===========

ApiHistogram allows developers to query API data and save the response
data automatically while trying to be the most flexible as possible.
ApiHistogram focuses on performance, so all calls are asynchronous.
 
This allows to have "LIVE" data coming every time the command line tool
is called ```php app/console api-histogram:update```

----------------------------------------------------

Usage
=====

- To use the application, make sure you define your ```sites```in the
configuration file ```config.yml```.
    + Recommendation: Use a separate file to define your calls.
- And every time you call the command
```php app/console api-histogram:update``` ApiHistogram will append the
new data to the database.

Future development
==================

- The Api calls are now being used with a simple GET HTTP method. As
this is a good approach for a REST-full approach, no extra headers are
being placed in the request. So next step will be to add optional
headers to the HTTP Request.
- For now, all data is being saved in one schema in one connection,
in future releases using different schemas for different connections
 for individual calls will be possible.
- New ideas coming soon!


Contact
=======

- Arnulfo Solis
- Email: arnulfojr@kuzzy.com
- Twitter: @arnulfojr
- Demo: http://qcharts.myarny.org/qcharts
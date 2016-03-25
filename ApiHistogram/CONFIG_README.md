ApiHistogram Configuration
==========================

Get Started:
============
The best way to get started with ApiHistogram and begin using all the
advantages it offers, so just follow the steps to start:
- First require ApiHistogram via Composer with the following command.
Composer command: ```composer require arnulfosolis/apihistogram @dev```
- Once composer is finished, you have now ApiHistogram downloaded and
ready to be used.
- Next step we have to register ApiHistogram into the 
target's ```AppKernel```.
    + ApiHistogram consists of only one Bundle, so only one bundle is
    required to be loaded, ```ApiHistogramBundle\ApiHistogramBundle```.
- Once you have registered ApiHistogram's Bundle, you can go ahead and
 configure it.
    + Configuration for a site:
        - formatter must be a ```CleanerInterface``` instance!
            + Namespace: ```ApiHistogramBundle\Cleaners```
```yml
# config.yml
imports:
    # ...
    - { resource: config_apihistogram.yml }
# ...
```

```yml
# config_apihistogram.yml

# ApiHistogramBundle config - sample
api_histogram:
    connection: default # choose the database connection to use
    schema_name: histogram # the name of the schema to store the tables in
    sites: # the sites to fetch the API from
        apple_stock: # id of the Site
            name: Apple Stock # the name of the fetching
            url: http://finance.yahoo.com/webservice/v1/symbols/AAPL/quote?format=json
            formatter: ApiHistogramBundle\Cleaners\YahooStockCleaner # The namespace of the Cleaner instance
            database: # configuration of the database
                table_name: apple_stock # name of the table to create in the schema
                create_table: true # this will create the table if it does not exists, default value false
        another_site:
            ...
```

- Every time you run the command ```app/console api-histogram:update```
all your registered sites will be updated.
    + Tip: use a cron job to update it automatically for you!
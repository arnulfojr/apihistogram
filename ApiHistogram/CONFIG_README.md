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

- Configuration fields:
    + connection: Is the connection value of the database connection
    given by doctrine.
        - Required field.
    + schema_name: The name of the schema to put all tables in.
        - Required field.
    + sites: Sites to fetch the data from.
        - Required for logical reasons.
        - site_id: This is the Id given to the registered site.
            + name: Natural name (Title)
                - Required field.
            + url: URL used to call the data from.
            + formatter: The desired ```Cleaner```'s namespace.
                - This formatter has to implement the ```CleanerInterface```
                - Required field.
            + database: Database's configuration.
                - table_name: The name of the table to save the response
                data in.
                    + Required field.
                - create_table: (boolean) if the call will create the 
                table if the table is not found.
                    + If it is not found an exception will be thrown
                    and processing the rest of the sites will continue.
- Every time you run the command ```app/console api-histogram:update```
all your registered sites will be updated.
    + Tip: use a cron job to update it automatically for you!
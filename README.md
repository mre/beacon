# beacon

A simple beacon catcher for [boomerang](https://github.com/lognormal/boomerang) and [statsc](https://github.com/godmodelabs/statsc).  

1. Run `composer install`
2. Adjust the beacon url in `example/client.html`
3. Run a server with this directory as a document root.  
   For testing, you can use the builtin PHP webserver:
   `php -S 0.0.0.0:8000`
4. Call `client.html` from a web browser

The metrics will now be sent to [StatsD](https://github.com/etsy/statsd/).

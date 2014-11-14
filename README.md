# beacon

*Work in progress*  

A stupidly simple beacon catcher for boomerang.  

1. Run `composer install`
2. Adjust the beacon url in `example/client.html`
3. Run a server with this directory as a document root.  
   For testing, just run the builtin PHP webserver:
   `php -S 0.0.0.0:8000`
4. Call `client.html` from a web browser

The metrics will now be put into a file called `metrics.txt`

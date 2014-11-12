BeaconBacon
===========

A stupidly simple beacon catcher for boomerang.  
This is so alpha that it hurts.  

1. Adjust the beacon url in the `client.html` file
2. Run a server with this directory as a document root.
   For testing, just run the builtin PHP webserver:
   `php -S 0.0.0.0:8000`
3. Call `client.html` from a web browser
4. The metrics will be put into a file called `metrics.txt`

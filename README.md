![beacon](beacon.png)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mre/beacon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mre/beacon/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/mre/beacon/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mre/beacon/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/mre/beacon/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mre/beacon/?branch=master)

A dedicated endpoint for real user monitoring. A beacon backend for your application.  
Works with [boomerang](https://github.com/lognormal/boomerang) and [statsc](https://github.com/godmodelabs/statsc).  

### Usage

From your application, you can send `GET` requests to the beacon endpoint like so:  
`example.com/my/applicationname?redirect=619ms&cache=4ms&dns=0ms&connect=1ms&firstByte=715ms&items=30g`

This will send the following metrics via [statsd](https://github.com/etsy/statsd/) for further processing:

```
my.applicationname.redirect:619|ms
my.applicationname.cache:4|ms
my.applicationname.dns:0|ms
my.applicationname.connect:1|ms
my.applicationname.firstByte:715|ms
my.applicationname.items:30|g
```

Beacon is used with a time-series database like this:

```
client --> beacon --> statsd --> graphite/influxdb/opentsdb/...
```

We've included a `docker-compose.yml` file to try this out.


### Quick start with Docker

    docker build -t mre/beacon .
    docker run -it --rm -p 80:80 mre/beacon


### Manual Installation

Running this with Docker as shown above is the preferred method, but if you  
have to install it locally, here's how to do it:

1. Run `composer install`
2. Start a server with this directory as a document root.  
   For testing, you can use the builtin PHP webserver:
   `php -S 0.0.0.0:8000`
3. (Optional) For beatiful URLs, enable rewrite rules and put a `.htaccess`  
   file into that folder with the following entry:
   `RewriteRule ^(.*)$ index.php?handler=$1 [L,QSA]`


### Valid keys:

Keys consist of upper and lowercase separated by dots or underscores.  
Examples: foo, FOO, FOO_BAR, FOO.BAR, FOO.bar, foo.BAR, foo.bar.baz, foo.bar_baz

### Valid types:

All statsd datatypes are supported. Those are:

Name         | Long name | Usage                                              |
------------ |-----------|----------------------------------------------------|
c            | Counter   | A record of an event occuring                      |
g            | Gauge     | A snapshot value of a variable                     |
ms           | Time      | A record of how long an event took, in milliseconds|
s            | Set       | Unique occurences of events between flushes        |

For more info, see [the official statsd documentation](https://github.com/etsy/statsd/blob/master/docs/metric_types.md).


### Valid values:

Values are negative or positive int or float numbers.
Examples: 123, -123, 1.0, -1.0


### Credits

Beacon logo created by [Ahmed Elzahra](https://www.behance.net/ahmedelzahra) from the Noun Project. Thanks!

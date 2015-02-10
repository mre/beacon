![beacon](beacon.png)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mre/beacon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mre/beacon/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/mre/beacon/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mre/beacon/build-status/master)

A dedicated endpoint for real user monitoring.  
Works with [boomerang](https://github.com/lognormal/boomerang) and [statsc](https://github.com/godmodelabs/statsc).  

### Usage

After the setup you can send `GET` requests to the beacon endpoint like so:  
`example.com/my/applicationname?requests=1c&searchtime=320ms&items=30g`

This will send the following metrics via [statsd](https://github.com/etsy/statsd/) for further processing:

```
my.applicationname.requests:1|c
my.applicationname.searchtime:320|ms
my.applicationname.items:30|g
```

The process chain is as follows:  

```
client --> beacon --> statsd --> graphite/influxdb/opentsdb/...
```

### Installation

1. Run `composer install`
2. Start a server with this directory as a document root.  
   For testing, you can use the builtin PHP webserver:
   `php -S 0.0.0.0:8000`
3. (Optional) For beatiful URLs, enable rewrite rules and put a `.htaccess`  
   file into that folder with the following entry:
   `RewriteRule ^(.*)$ index.php?handler=$1 [L,QSA]`

Now you have a restful beacon backend for your application.

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
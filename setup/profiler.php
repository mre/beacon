<?php

/**
 * This is the entry point for profiling.
 * Make sure the path for profiling output is writable!
 * We use the tideways profiler which is a modern fork of xhprof.
 */
if (!isset($_COOKIE['profile']))
{
  return;
}

if (!extension_loaded('tideways'))
{
  return;
}

tideways_enable(TIDEWAYS_FLAGS_CPU + TIDEWAYS_FLAGS_MEMORY);

register_shutdown_function(function ()
{
  $filename = '/profiler_output/' . uniqid() . '.xhprof';
  file_put_contents($filename, serialize(tideways_disable()));
});

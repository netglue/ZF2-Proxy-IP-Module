# Remote IP Detection - Zend Framework Module

## Purpose

This module was devised to solve the problem of figuring out the remote address of a user when the app is behind a loadbalancer or any other proxy.

The module is centered around a service that will try to retrieve the most likely remote address based on the `$_SERVER` variables `REMOTE_ADDR` and `HTTP_X_FORWARDED_FOR`. Hopefully, proxies will provide an `X-Forwarded-For` header where the left most IP is the originating client, i.e `X-Forwarded-For: 192.168.0.1, 192.168.0.2`, however, in practice I've found that HaProxy for example adds an additional header line to the request when you've set `option forwardfor`, meaning that if you're 2 proxies deep, you only see the most recent in the chain. Anyhow, moving on, as CloudFlare is widely used, the service also checks for `'CF_CONNECTING_IP'` and provides the most likely source IP address in this order: `CF_CONNECTING_IP`, `X_FORWARDED_FOR`, `REMOTE_ADDR`.

If you are using Cloudflare infront of HaProxy, this module should give you the correct IP out of the box regardless of haproxy settings but otherwise, you may need to fiddle with your loadbalancer settings by turning off the forwardfor option selectively or using a different header name, for example `option forwardfor if-none` or `option forwardfor header X-HaProxy-Forwarded-For` to preserve existing `X-Forwarded-For` headers in PHP.

## Install

Install with composer, i.e. `composer require netglue/zf2-proxy-ip-module` and enable the module using the module name `NetglueIp`.

## Configure

The module has a bootstrap listener that will rewrite the current requests `'REMOTE_ADDR'` with whatever IP is detected but only if it's enabled in your configuration, so in one of your configuration files, set `['netglue_ip']['rewrite_remote_addr']` to `true` if you want this behaviour.

## Controller Plugin and View Helper

There's a controller plugin and view helper available and both are aliased to `$this->realIp()`. Calling either of these will return a string.


ZF2 module to make it easier to figure out who the remote user is when you're behind proxies or load balancers etc.

---

[Made with ︎♥️︎ in Devon by Net Glue](https://netglue.uk)


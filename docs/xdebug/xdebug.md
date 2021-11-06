### Configure Xdebug in PHPSTORM

xDebug3 default port is `9003`

Do some modification in `docker/php/conf.d/xdebug.ini`


![php-debug-config.png](imgs/php-debug-config.png)

![sever-config.png](imgs/sever-config.png)

![break-point.png](imgs/break-point.png)

# How to Troubleshoot Xdebug if it doesn’t work

    xdebug_info();
    exit;

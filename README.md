# timer
A timer, in PHP. You can (re)start, pause and stop. And get the passed time.

Currently supported time measuring options:

* dateime: uses PHP's DateTime class (this is the default)
* microtime: uses PHP's microtime function

## Installation

Using Composer:

```bash
composer require davidbehler/timer
```

## Usage

Create a new timer with autostart
``` php
$timer = new Timer;
```

Create a new timer with autostart and microtime option
``` php
$timer = new Timer(true, 'microtime');
```

Create a new timer without autostart
``` php
$timer = new Timer(false);
```

Manually start a timer
``` php
$timer = new Timer(false);

$timer->start();
```

Pause a timer
``` php
$timer = new Timer;

$timer->pause();
```

Stop a timer
``` php
$timer = new Timer;

$timer->stop();
```

Unpause a paused timer
``` php
$timer = new Timer;

$timer->pause();
$timer->start();
```

Restart a timer
``` php
$timer = new Timer;

$timer->restart();
```

Get duration of running timer in microseconds (uses current time)
``` php
$timer = new Timer;

usleep(1000);

$timer->getDuration(); // returns 1000 (in a perfect world, but of course timings aren't this perfect)
```

Get duration of running timer in seconds with 4 digits after decimal point (uses current time)
``` php
$timer = new Timer;

usleep(555);

$timer->getDuration(true, 3); // returns 0.555 (in a perfect world, but of course timings aren't this perfect)
```

Get duration of paused timer in seconds
``` php
$timer = new Timer;

usleep(500);

$timer->pause();

usleep(500);

$timer->getDuration(true); // returns 0.5 (in a perfect world, but of course timings aren't this perfect)
```

Get duration of stopped timer in seconds
``` php
$timer = new Timer;

usleep(500);

$timer->stop();

usleep(500);

$timer->getDuration(true); // returns 0.5 (in a perfect world, but of course timings aren't this perfect)
```

Get duration of timer paused/started multiple times in seconds
``` php
$timer = new Timer;

usleep(500);

$timer->pause();

usleep(500);

$timer->start();

usleep(200);

$timer->pause();

usleep(2000);

$timer->start();

usleep(1000);

$timer->stop();

$timer->getDuration(true); // returns 1.7 (in a perfect world, but of course timings aren't this perfect)
```
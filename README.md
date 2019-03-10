# timer
A timer, in PHP. You can (re)start, pause and stop. And get the passed time. With TimerCollection you can run multiple timers at once.

Currently supported time measuring options:

* dateime: uses PHP's DateTime class (this is the default)
* microtime: uses PHP's microtime function

## Installation

Using Composer

```bash
composer require davidbehler/timer
```

Without Composer

You can also download it from [Github] (https://github.com/davidbehler/timer), but no autoloader is provided so you'll need to register it with your own PSR-4 compatible autoloader.

## Timer Usage

Create a new timer with autostart
``` php
use DavidBehler\Timer\Timer;

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

Get a report
``` php
$timer->getReport();
```

## TimerCollection Usage
Create a new TimerCollection with the microtime option. All timers within this collection will use the measuring option the collection was inititialized with.
``` php
use DavidBehler\Timer\TimerCollection;

$timerCollection = new TimerCollection('microtime');
```

Start a time and get it's duration in seconds
``` php
$timerCollection->start('timer 1');

$timerCollection->getDuration('timer 1', true);
```

Start multiple timers at once and get their durations
``` php
$timerCollection->start('timer 1');
$timerCollection->start('timer 2');

$timerCollection->getDuration('timer 1');
$timerCollection->getDuration('timer 2');
// or
$timerCollection->start(array('timer 1', 'timer 2'));
$timerCollcetion->getDuration(array('timer 1', 'timer 2')); // returns an array of durations with timer labels as indeces
```

You can also stop, pause and restart multiple timers at once
``` php
$timerCollection->stop(array('timer 1', 'timer 2'));
$timerCollection->pause(array('timer 1', 'timer 2'));
$timerCollection->restart(array('timer 1', 'timer 2'));
```

You can get a list of all timers
``` php
$timerCollection->getTimers(); // returns an array with all setup timers
$timerCollection->getTimers(true); // returns an array with all the setup timers' labels
```

Get a single timer's report
``` php
$timerCollection->getReport('timer 4');
```

Get a report for multiple timers
``` php
$timerCollection->getReport(array('timer 5', 'timer 6'));
```
# ScriptCheck

## The Problem:

Working with CRON-jobs can be a pain sometimes. Having to ensure that your scheduled job did its thing without any errors can be a real hassle.

A real world example:
Imagine having a scheduled script that grabs some data from a 3rd party API or some RSS feed. If your script fails to parse
the feed/data, PHP offers you no built-in mechanism to be notified as an administrator. The only thing you can do is turn on Error-Logging and hope for the best.

**Note:** PHP has some error-handling limitations so make sure to read the "limitations" section below!

## The Solution

In order to solve this problem, we as developers have to specify how PHP should handle errors when they occur. ScriptCheck allows you to do just that!

```
require 'vendor/autoload.php';

use Lorenum\ScriptCheck\ScriptCheck;
use Lorenum\ScriptCheck\Handlers\FileLoggerHandler;

$sc = new ScriptCheck();
$sc->addHandler(new FileLoggerHandler(getcwd() . "/test.log"));
$sc->register();


throw new Exception("Test Exception");
```

Add the code above **at the top** of your CRON job and it will automatically log all Errors and Exceptions into the file test.log of under your current project's directory.


## Installation

Before you can run the code above you have to require the library via composer by using

```
    "require": {
        "lorenum/scriptcheck": "0.1"
    }
```

## Handlers

The package comes with 4 different handlers. FileLoggerHandler, SQLDBHandler, EmailHandler, APICallHandler.

##### FileLoggerHandler: Logs Errors/Exceptions into the filename specified in the constructor

```
$sc->addHandler(new FileLoggerHandler("test.log"));
```

##### SQLDBHandler: Logs Errors/Exceptions into a SQL DB.
```
$sc->addHandler(new SQLDBHandler('mysql:host=localhost;dbname=application', "root", "")); //Default table name is 'logs'
```

Alternatively you could use:

```
$h = new SQLDBHandler('mysql:host=localhost;dbname=application', "root", "");
$h->setTableName('my_logs_table');
$sc->addHandler($h);
```

You can see the table schema in the SQLDBHandler file. Alternatively you could extend it and make your own handler.

##### EmailHandler: Logs Errors/Exceptions by sending you an email
```
$sc->addHandler(new EmailHandler("MYEMAIL@SOMEEMAILPROVIDER.COM", "Email subject is optional"));
```

##### APICallHandler: Logs Errors/Exceptions by calling an external API. Supports **GET** or **POST**

```
$sc->addHandler(new APICallHandler("http://ENDPOINT.COM/YOURURI", APICallHandler::METHOD_GET));
```
OR

```
$sc->addHandler(new APICallHandler("http://ENDPOINT.COM/YOURURI", APICallHandler::METHOD_POST));
```

## Extensions

You can also create your own handler(s) by extending one of the 4 provided handlers above or by implementing the HandlerInterface in the \Handlers folder.


## Limitations:

For user triggered errors and exceptions this library will work without any problems what so ever. However, when dealing with fatal shutdown errors,
such as **parse error** (you forgetting a semicolon for instance), the script will only work **IF** the parse error happens in a different file than the one
in which the script is initiated.

Ex. if your **new ScriptCheck()** command is in the **index.php** file of your application, then the ScriptCheck library will not be able to workout parse errors on that file (index.php).
However, all files **required** by index.php will be checked without a problem.

## License

MIT

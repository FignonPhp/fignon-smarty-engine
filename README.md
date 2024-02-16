# Fignon Smarty Engine

This is a simple class to encapsulate the Smarty template engine and use it easily in the Fignon Framework.

In your Fignon project, run:

```bash
composer require fignon/fignon-smarty-engine
```

Then, use it like this:

```php
//app.php (or index.php) depending of how you call you entry point
declare(strict_types=1);

include_once __DIR__ . "/../vendor/autoload.php";

use Fignon\Tunnel;
use App\Features\Features;
use Fignon\Extra\SmartyEngine;

$app = new Tunnel();
$app->set('env', 'development');
// ... other middlewares

// View engine initialization
$app->set('views', dirname(__DIR__) . '/templates');
$app->set('views cache', dirname(__DIR__) . '/var/cache');
$app->set('view engine options', [ // Smarty require these additional option to work
    'compileDir' => 'path/to/compile/dir',
    'configDir' => 'path/to/config/dir'
]); // Add options to the view engine
$app->engine('smarty', new SmartyEngine()); 

$app->set('case sensitive routing', true);
//  ... other middlewares
 

// You can then use it to render
(new Features($app))->bootstrap();

$app->listen();
```

Other view engine integration to Fignon are:

- [The Twig Engine](https://github.com/FignonPhp/fignon-twig-engine)
- [The Plates Engine](https://github.com/FignonPhp/fignon-plate-engine)
- [The Laravel Blade Engine](https://github.com/FignonPhp/fignon-blade-engine)


Sample Smarty Config files:

```ini
#path/to/config/dir/smarty_config.conf

# global variables
pageTitle = "Main Menu"
bodyBgColor = #000000
tableBgColor = #000000
rowBgColor = #00ff00

[Customer]
pageTitle = "Customer Info"

[Login]
pageTitle = "Login"
focus = "username"
Intro = """This is a value that spans more
           than one line. you must enclose
           it in triple quotes."""

# hidden section
[.Database]
host=my.example.com
db=ADDRESSBOOK
user=php-user
pass=foobar
```

To learn more about smarty, please refer to the [documentation of Smarty.](https://smarty-php.github.io/smarty/stable/)
<<<<<<< HEAD
<?php

spl_autoload_register(function($class)
{
    $file = __DIR__.'/lib/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
=======
<?php

spl_autoload_register(function($class)
{
    $file = __DIR__.'/lib/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
});
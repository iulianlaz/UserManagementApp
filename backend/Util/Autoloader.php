<?php

define ("CORE_PATH", '');

spl_autoload_register(function($className)
{
    $namespace = str_replace("\\","/",__NAMESPACE__);
    $className = str_replace("\\","/",$className);

    $class = CORE_PATH . (empty($namespace) ? "" : $namespace . "/") . "{$className}.php";
    require_once($class);
});
?>
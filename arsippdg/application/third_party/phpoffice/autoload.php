<?php

$phpOfficeBase = __DIR__;

$autoloaders = [
    'PhpOffice\\PhpSpreadsheet\\' => $phpOfficeBase . '/phpspreadsheet/src/PhpSpreadsheet/',
    'Psr\\SimpleCache\\' => $phpOfficeBase . '/psr/simple-cache/src/',
    'Complex\\' => $phpOfficeBase . '/complex/classes/src/',
    'Matrix\\' => $phpOfficeBase . '/matrix/classes/src/',
    'ZipStream\\' => $phpOfficeBase . '/zipstream/src/',
    'ZipStream\\Exception\\' => $phpOfficeBase . '/zipstream/src/Exception/',
    'ZipStream\\Option\\' => $phpOfficeBase . '/zipstream/src/Option/',
];

spl_autoload_register(function ($class) use ($autoloaders) {
    foreach ($autoloaders as $prefix => $basePath) {
        if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
            continue;
        }

        $relative = substr($class, strlen($prefix));
        $file = $basePath . str_replace('\\', '/', $relative) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }

    return false;
});

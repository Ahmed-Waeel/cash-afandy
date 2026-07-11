<?php

use Redot\Application;

// Define the base path of the application
$basePath = dirname(__DIR__);

// Require the core app.php file
return Application::configure($basePath)->create();

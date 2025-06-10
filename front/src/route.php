<?php

require_once 'functions.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? 'default'; // Assuming action is passed as a GET parameter

switch ($requestMethod) {

    case 'POST':
        switch ($action) {
            case 'getWidgetInfo':
                $Controller = new SkynetWidget();
                echo $Controller->getWidgetInfo(); // Pass POST data
                break;
            case 'fetchWidgetSettings':
                $Controller = new SkynetWidget();
                echo $Controller->fetchWidgetSettings(); // Pass POST data
                break;
            default:
                // Default POST action
                echo "Default POST action.";
                break;
        }
        break;

    // Add cases for other HTTP methods like PUT, DELETE, etc. if needed
    default:
        // Handle unsupported methods
        header("HTTP/1.0 405 Method Not Allowed");
        echo "Method Not Allowed.";
        break;
}

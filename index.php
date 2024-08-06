<?php

require_once 'controllers/BuyerController.php';

$action = isset($_GET['action']) ? $_GET['action'] : null;

$controller = new BuyerController();

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    default:
        $controller->report();
        break;
}

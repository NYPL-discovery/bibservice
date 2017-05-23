<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\Config;
use NYPL\Starter\SwaggerGenerator;

Config::initialize(__DIR__);

$service = new Service();

$service->get("/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(
        [__DIR__ . "/src"],
        $response
    );
});

$service->post("/api/v0.1/bibs", function (Request $request, Response $response) {
    $controller = new Controller\BibController($request, $response);
    return $controller->createBib();
});

$service->get("/api/v0.1/bibs", function (Request $request, Response $response) {
    $controller = new Controller\BibController($request, $response);
    return $controller->getBibs();
});

$service->get("/api/v0.1/bibs/{nyplSource}/{id}", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\BibController($request, $response);
    return $controller->getBib($parameters["nyplSource"], $parameters["id"]);
});

$service->run();

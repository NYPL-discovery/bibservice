<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\Config;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\ErrorHandler;

try {
    Config::initialize(__DIR__ . '/config');

    $service = new Service();

    $service->get("/docs/bib", function (Request $request, Response $response) {
        return SwaggerGenerator::generate(
            [__DIR__ . "/src", __DIR__ . "/vendor/nypl/microservice-starter/src"],
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

    $service->get("/api/v0.1/bibs/{nyplSource}/{id}/related", function (Request $request, Response $response, $parameters) {
        $controller = new Controller\BibController($request, $response);
        return $controller->getRelatedBibs($parameters["nyplSource"], $parameters["id"]);
    });

    $service->get("/api/v0.1/bibs/{nyplSource}/{id}/related-simple", function (Request $request, Response $response, $parameters) {
        $controller = new Controller\BibController($request, $response);
        return $controller->getRelatedSimpleBibs($parameters["nyplSource"], $parameters["id"]);
    });

    $service->post("/api/v0.1/bib-post-requests", function (Request $request, Response $response) {
        $controller = new Controller\BasePostController\BibPostController($request, $response);
        return $controller->createBibPostRequest();
    });

    $service->run();
} catch (Exception $exception) {
    ErrorHandler::processShutdownError($exception->getMessage(), $exception);
}

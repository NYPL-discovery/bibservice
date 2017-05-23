# NYPL Bib Service

This package is intended to be used as a Lambda-based Bib Service using the 
[NYPL PHP Microservice Starter](https://github.com/NYPL/php-microservice-starter).

This package adheres to [PSR-1](http://www.php-fig.org/psr/psr-1/), 
[PSR-2](http://www.php-fig.org/psr/psr-2/), and [PSR-4](http://www.php-fig.org/psr/psr-4/) 
(using the [Composer](https://getcomposer.org/) autoloader).

## Requirements

* PHP >=7.0
* Node.js >=6.0

## Installation

1. Clone the repo.
2. Install required dependencies.
   * Run `npm install` to install Node.js packages.
   * Run `composer install` to install PHP packages.
   * If you have not installed `node-lambda` globally, run `npm install -g node-lambda`.
3. Setup [environment configuration](#environment-configuration).
   * Copy `.env.sample` to `.env` and make necessary changes.

## Configuration

### Environment Configuration

`.env` is used by `node-lambda` for deploying to and configuring the AWS Lambda. You can also use this file for  

### Deployment Configuration

## Features

## Usage

### Process a Lambda Event

To use `node-lambda` to process the sample API Gateway event in `event.json`, run:

~~~~
node-lambda run
~~~~


### Run as a Web Server

Create an `index.php` with a `Service` object and your [Slim](http://www.slimframework.com/) routes:

~~~~
Config::initialize(__DIR__ . '/config');

$service = new NYPL\Starter\Service();

$service->get("/v0.1/bibs", function (Request $request, Response $response) {
    $controller = new Controller\BibController($request, $response);
    return $controller->getBibs();
});
~~~~

Configure your web server to load `index.php` on all requests.
See the `samples/service-config` directory for sample configuration files for an Apache `.htaccess` or Nginx `nginx.conf` installation.

### Swagger Documentation Generator

Create a Swagger route to generate Swagger specification documentation:

~~~~
$service->get("/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(__DIR__ . "/src", $response);
});
~~~~

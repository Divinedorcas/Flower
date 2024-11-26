<?php
namespace Routes;
use Closure;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class contactController{
    protected $container;

    // constructor receives container instance
    public function _construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

  public function index(Request $request, Response $response, $args)
  {
    $response->getBody()->write("contact page");
    return $response;
}

public function emailContact($request, $response, $args){
  $response->getBody()->write("Contact Page Email ");
  return $response;
}

}
  







?>
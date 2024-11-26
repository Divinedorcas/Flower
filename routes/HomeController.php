<?php
namespace Routes;

use App\Models\UserModel;
use App\PageModels\HomePageModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HomeController{

private string $HomeTemplate = template_dir.'home.latte';

  public function __invoke(Request $request, Response $response, $args){  
   $user = new UserModel();
    $user -> FullName = "Emmanuel Ayela";
    $pageViewModel = new HomePageModel();
    $pageViewModel->user = $user; 

    $output = latte->renderToString($this->HomeTemplate,
    $pageViewModel);
   $response->getBody()->write($output);
    return $response;
}
  }









<?php
namespace Routes;

use App\Models\ProductModel;
use App\Models\UserModel;
use App\PageModels\HomePageModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


  class AboutController{

  public function __invoke(Request $request, Response $response, $args)
  {
    $user = new UserModel();
    $user -> FullName = "Emmanuel dorcas";
    $pageViewModel = new HomePageModel();
    $pageViewModel->user = $user; 
    $out = latte->renderToString('view/template.latte',
    $pageViewModel);
    $response->getBody()->write($out);
    return $response;
}





  }
  

  

?>
<?php
namespace Routes;

use Slim\Psr7\Request;
use Slim\Psr7\Response;




const GetAllQuery = "SELECT * from `product` WHERE 1 ";
class GetController{

    private string $authTemplate = template_dir.'auth.latte';

    public function __invoke( Request $request, Response $response ){


    // header("content-type: application/json");
    // $result= DB->query("SELECT * FROM `product` WHERE 1");
    // $data= $result->fetch_all(MYSQLI_ASSOC);

    // $response->getBody()->write(json_encode($data));

    header("content-type: application/json");
    $result= DB->query(GetAllQuery);
    $data= $result->fetch_all(MYSQLI_ASSOC);
   

    $output = latte->renderToString($authTemplate, $this);
    $response->getBody()->write($output);

        return $response;
    }
}







?>
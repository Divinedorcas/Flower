<?php

use FastRoute\Route;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Routes\AboutController;
use Routes\AuthController;
use Routes\ByeController;
use Routes\contactController;
use Routes\DashboardController;
use Routes\GetController;
use Routes\HomeController;
use Routes\ProductController;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__.'/includes/connection.php';
require_once __DIR__.'/includes/constant.php';
session_start();

$app = AppFactory::create();


const latte = new Latte\Engine;
const template_dir = __DIR__ ."/view/";


$app->get('/', Routes\HomeController ::class);

$app->get('/about', Routes\AboutController::class);

$app->get('/contact', Routes\contactController::class);

$app->get("/index", contactController::class. ":index");

$app->get("/auth", AuthController::class. ":index");

$app->post("/auth", AuthController::class. ":FormSubmitted");

$app->get("/logout", AuthController::class. ":Logout");

$app->get("/dashboard", DashboardController::class);

$app->post('/product', ProductController::class. ":Create");

$app->post("/getall", ProductController::class. ":GetAll");

///Products
$app->post("/product/update", ProductController::class. ":Update");

$app->post("/product/create", ProductController::class. ":Create");

$app->delete("/product/delete", ProductController::class. ":Delete");

$app->get("/product/all", ProductController::class. ":GetAll");

$app->get("/product/my", ProductController::class. ":MyProducts");

$app->post("/product/addtocart", ProductController::class. ":AddToCart");







//$app->get("/get", GetController::class);


// $app->get("/users/list", function (Request $req, Response $res){
//     header("content-type: application/json");
//     $result= DB->query("SELECT * FROM `product` WHERE 1");
//     $data= $result->fetch_all(MYSQLI_ASSOC);

//     $res->getBody()->write(json_encode($data));

//     return $res;
// });

// $app->get('/users/list',  function (Request $req, Response $res){
//     header("content-type: application/json");
//     $result= DB->query("INSERT INTO `shoper_vission`.`product` (`image`, `name`, `price`,`desc`, `owner_id`)
//     VALUE('adejoh roseline', 'rose', '9055', 'rosyrose', '15') ");
    
//     $data=[
//         'result'=>$result !=false
//         ];

//     $res->getBody()->write(json_encode($data));

//     return $res;
// });
   

$app->run();

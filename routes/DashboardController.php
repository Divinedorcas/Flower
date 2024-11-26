<?php
namespace Routes;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DashboardController {

    private string $dashboardTemplate = template_dir.'dashboard.latte';

    public $data;
    public function __invoke(Request $request, Response $response, $args) {
        ///if not loggedin goto auth
        if(!isset($_SESSION["user"])){
            $response = $response->withHeader("Location", "/auth")->withStatus(302);
            return $response;
        }else if($_SESSION["user"]["role"] != "seller"){
            $response = $response->withHeader("Location", "/auth")->withStatus(302);
            return $response;
        }

        $output = latte->renderToString($this->dashboardTemplate,
        $this);
        $response->getBody()->write($output);
        return $response;
    }
}
?>



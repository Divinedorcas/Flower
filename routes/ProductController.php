<?php
namespace Routes;

use App\Models\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

const NumPerPage = 10;
const GetAllQuery = "SELECT * from `product` WHERE 1 LIMIT ".NumPerPage." OFFSET ?";
const GetByUserIdQuery = "SELECT * from `product` WHERE `owner_id` = ? LIMIT ".NumPerPage." OFFSET ?";
const GetByIdQuery = "SELECT * from `product` WHERE `id` = ? ";
const DeleteByIdQuery = "DELETE from `product` WHERE `id` = ? ";
const UpdateQuery = "UPDATE `product` SET `name` = ?, `image` = ?, `price` = ?, `desc` = ?";
const CreateQuery = "INSERT INTO `product` (`name`,`image`,`price`,`desc`,`owner_id`) VALUES (?,?,?,?,?)";
const AddToCartQuery = "INSERT INTO `cart` (`qty`,`price`,`owner_id`) VALUES (?,?,?)";



class ProductController{

    protected $container;
    // constructor receives container instance
   public function __construct($container) {
       $this->container = $container;
   }

    public UserModel $user;

    public function GetById(Request $request, Response $res)
    {
        $data = $request->getQueryParams();
        $id = $data['id'] ?? null;
        $out = "{}";
        if($id){
            $stmt = DB->prepare(GetByIdQuery);
            $stmt->execute([$id]);
            $result = $stmt->get_result();
            if($result->num_rows){
                $data = $result->fetch_assoc();
                $out = json_encode($data);
            }
        }
        $res->getBody()->write($out);
        header("content-type: application/json");
        return $res;
    }

    public function GetAll(Request $request, Response $res)
    {

        $page = $_GET["page"] ?? 1;
        $offset = ($page - 1) * NumPerPage;
        $stmt = DB->prepare(GetAllQuery);
        $out = "[]";
        if($stmt->execute([$offset])){
            $request = $stmt->get_result();
            $data = $request->fetch_all(MYSQLI_ASSOC);
            $out = json_encode($data);
        }
        header("content-type: application/json");
        $res->getBody()->write($out);
        return $res;
    }


    public function MyProducts(Request $request, Response $res)
    {
        $page = $_GET["page"] ?? 1;
        $offset = ($page - 1) * NumPerPage;
        $stmt = DB->prepare(GetByUserIdQuery);
        $out = "[]";
        $sid = $_SESSION["user"]['id'];
        if($stmt->execute([$_SESSION["user"]['id'],$offset])){
            $request = $stmt->get_result();
            $data = $request->fetch_all(MYSQLI_ASSOC);
            $out = json_encode($data);
        }
        header("content-type: application/json");
        $res->getBody()->write($out);
        return $res;
    }



    public function Create(Request $request, Response $res)
    {$uploadDir = __DIR__."/../static/uploads";
        $data = $request->getParsedBody();
        //$data = json_decode(file_get_contents("php://input"),true);
        $name = $data["name"] ?? null;
        //$image = $data["image"] ?? null;
        $image = $_FILES["image"]??null;
        $price = $data["price"] ?? null;
        $desc = $data["desc"] ?? null;
        $owner_id = $_SESSION["user"]['id'];
        $out = [];

        if ($image["error"] == 0) {
            $image_name = uniqid("FILE_").".".pathinfo( $image["name"], PATHINFO_EXTENSION);
            //FILE_3456789dsf.png

            $result = move_uploaded_file($image["tmp_name"],$uploadDir. "/" . $image_name );
            if($result){
                if(isset($name,$image,$price,$desc)){
                    $stmt = DB->prepare(CreateQuery);
                    $result =$stmt->execute([$name,"/static/uploads/".$image_name,$price,$desc,$owner_id]);
                    if($result){
                        $out["massage"] = "Created";
                    }else{
                        $out["massage"] = "Failed To Create";
                    }
                }else{
                    $out["massage"] = "Missing Param";
                }
            }else{
                $out["massage"] = "Failed To Process Uploaded File";
            }
            
        }else{
            $out["massage"] = "Failed To Upload";
        }

        header("content-type: application/json");
        
        $res->getBody()->write(json_encode($out));
        return $res;
    }

    public function Update(Request $request, Response $res)
    { $uploadDir = __DIR__."/../static/uploads";

        $name = $_POST["name"] ?? null;
        $image = $_FILES["image"]??null;
        $price = $_POST["price"] ?? null;
        $desc = $_POST["desc"] ?? null;

        if($image != null){
            $image_name = uniqid("FILE_").".".pathinfo( $image["name"], PATHINFO_EXTENSION);
            //FILE_3456789dsf.png
            $result = move_uploaded_file($image["tmp_name"],$uploadDir. "/" . $image_name );
            $stmt = DB->prepare("UPDATE `product` SET `image` = ?");
            $stmt->execute([$image_name]);
        }

        if($name != null){
            $stmt = DB->prepare("UPDATE `product` SET `name` = ?");
            $stmt->execute([$name]);
        }

        if($price != null && filter_var($price,FILTER_SANITIZE_NUMBER_FLOAT)){
            $stmt = DB->prepare("UPDATE `product` SET `price` = ?");
            $stmt->execute([$price]);
        }

        if($desc != null){
            $stmt = DB->prepare("UPDATE `product` SET `desc` = ?");
            $stmt->execute([$desc]);
        }

        header("content-type: application/json");
        $out = "{}"; 
        $res->getBody()->write($out);
        return $res;
    }

    public function Delete(Request $request, Response $res)
    { $product_id = $_GET["id"]??null;
        $stmt = DB->prepare(DeleteByIdQuery);
        $out = "{}";
        if(!$product_id){
            header("content-type: application/json");
            $res->getBody()->write($out);
            return $res;
        }
        $stmt->execute([$product_id]);
        header("content-type: application/json");
        $res->getBody()->write($out);
        return $res;
    }
    public function AddToCart(Request $request, Response $res)
    {
        $data = $request->getParsedBody();
        //$data = json_decode(file_get_contents("php://input"),true);
        $qty = $data["qty"] ?? 
        $price = $data["price"] ?? null;
        $owner_id = $data['id'];
        $out = [];
                    $stmt = DB->prepare(AddToCartQuery);
                    $result =$stmt->execute([$qty,$price,$owner_id]);
                    if($result){
                        $out["massage"] = "Added";
                    }else{
                        $out["massage"] = "Failed To Add";
                    }
                
            
        
        header("content-type: application/json");
        
        $res->getBody()->write(json_encode($out));
        return $res;
    }


    
}




?>

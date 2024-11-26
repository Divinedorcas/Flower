<?php
namespace Routes;

use App\Models\UserModel;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AuthController{
    protected $container;
    public ?string $massage = "";
    private string $authTemplate = template_dir.'auth.latte';
//  public function __invoke(Request $request, Response $res)
//  {
//     $out = latte->renderToString('view/auth.latte',   ["user"=> new UserModel() ]);
//      $res->getBody()->write($out);

//     return $res;
//  }

public function _construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function index(Request $request, Response $response, $args)
    {
        $page = latte->renderToString($this->authTemplate, $this );
    $response->getBody()->write($page);
      return $response;
  }

  public function Logout(Request $request,Response $response, $args){
    $_SESSION["User"] = null;
    session_destroy();
    $response = $response->withHeader("Location", "/auth")->withStatus(302);
    $response->getBody();
    return $response;
}

        //get data from database
        //validate password
        //save in sess

    
        public function FormSubmitted(Request $request,Response $response, $args){
            $data = $request->getParsedBody();
            if(isset($data["login"])){
                $email = $data["email"] ?? null;
                $password = $data["password"] ?? "";
                $query = "SELECT `id`, `username`, `password`, `role` from `user` WHERE `email` = ?";
                $stmt = DB->prepare($query);
                if($stmt->execute([$email])){
                    $result = $stmt->get_result();
                    $userData = $result->fetch_assoc();
                    if($userData ){
                        if(password_verify($password,$userData["password"])){
                            $userData["password"] = "";
                            $_SESSION["user"] = $userData;
                            $response = $response->withHeader("Location", "/dashboard")->withStatus(302);
                        }else {
                            $this->massage = "wrong Password";
                        }
                    }else{
                        $this->massage = "User Not Found!";
                    }
                }else{
                    $this->massage = "User Not Found!";
                }
              
                $page = latte->renderToString($this->authTemplate,$this);
                $response->getBody()->write($page);
                return $response;
                
              }

     $FilterPassed= true;
        $data= $request->getParsedBody();
        $fullname=$data['fullname']?? "";
        $email=$data['email']?? "";
        $phone=$data['phone']?? "";
        $password=$data['password']?? "";
        $username=$data['username']?? "";
        $role=$data['role']?? "";
       

        $isValidFullName = preg_match(FullNameValidationPattern, $fullname);
        $isValidUserName = preg_match(UserNameValidationPattern, $username);
        $isValidPhone = preg_match(PhoneValidationPattern, $phone);
       $isValidPassword = preg_match(PasswordValidationPattern, $password);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $this->massage .= "Invalid Email, ";
            $FilterPassed = false;
        }
        if(!$isValidFullName){
            $this->massage .= "Invalid Full Name, ";
            $FilterPassed = false;
        }
       if(!$isValidUserName){
            $this->massage .= "Invalid Username, ";
            $FilterPassed = false;
        }
        if(!$isValidPhone){
            $this->massage .= "Invalid Phone Number, ";
            $FilterPassed = false;
        }
        if(!$isValidPassword){
            $this->massage .= "Invalid Password, Your Password requires at least one uppercase letter, one lowercase letter, one number,
         and one special character, with a minimum length of 8 characters";
            $FilterPassed = false;
        }



        //php filter function to validate data from users

      $query=  "INSERT INTO `user` (`fullname`, `email`,  `phone`, `password`, `username`, `role` ) 
     VALUE(?,?,?,?,?,?) ";
if ($FilterPassed){
        try{
            $stmt=DB->prepare($query);
            
    $result = $stmt->execute([
            $fullname,
            $email,
            $phone,
           password_hash($password, PASSWORD_DEFAULT),
           $username,
            $role
    ]);

    if($result){
        $this->massage= 'user added';
    }else{
        $this->massage= 'user not added';
    }
 } catch(\mysqli_sql_exception $th){
            $this->massage= 'unknon error adding user';
        }
        catch(\throwable $th){
            $this->massage= 'unknon error adding user again';
        }
    }
    
    $page = latte->renderToString($this->authTemplate, $this );
    $response->getBody()->write($page);
      return $response;
    }



        }
        // DIFADOR1d
        // ghtjDBNVHJA234
        // D1234o4321

?>
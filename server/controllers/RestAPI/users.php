<?php 
   require_once 'api.php';
   require_once '../../vendor/autoload.php';
   use \Firebase\JWT\JWT;
   class Users extends wrapper{
      private $conn;
      private $msg; 
      public function __construct($request){
         parent:: __construct($request);
         $this->conn = new Database();
         if(!empty($this->params)){
               $id = $this->params['param1'];
         }

         switch($this->method){
               case 'GET':
                  $this->verify_token();
                  if(isset($this->params['param1'])){
                     $query = $this->get_user_id($request,$id);
                  }else{
                     $query = $this->get_user($request);
                  }
                  break;

               case "POST": switch($request){
                     case 'register':
                        $post_values = json_decode(file_get_contents("php://input"),true);
                        $email = $post_values['email'];
                        $password = $post_values['password'];
                        $username = $post_values['username'];
                        $message = $this->check_fields($email,$password,$username);
                        if(!empty($message)){
                           echo $message;
                        }else{
                           $query = $this->register($email,$username,$password);
                        }
                        break;

                     case 'email':
                        $post_values = json_decode(file_get_contents("php://input"),true);
                        $email = $post_values['email'];
                        if($email != '' && filter_var($email,FILTER_VALIDATE_EMAIL)){
                           $from = "jitendrashrestha666@gmail.com";
                           $reply_to = "eWallet";
                           $token_array = generate_random_token($email);
                           $token = $token_array['jwt'];
                           if($this->send_token($from,$email,$token,$reply_to)){
                              $this->insert_token($email,$token);
                              echo "message sent";
                           } 
                        }else{
                           echo "Invalid email or empty email field";  
                        }
                        break;

                     case 'login':
                        $post_values = json_decode(file_get_contents("php://input"),true);
                        $email = $post_values['email'];
                        $password = $post_values['password'];
                        $this->login($email,$password);
                        break;
                  }
                  break;

               case 'PUT':
                  $post_values = json_decode(file_get_contents("php://input"),true);
                  $password = $post_values['password'];
                  $secret_key = base64_decode(SECRET_KEY);
                  $token = $post_values['token'];
                  $decoded_array = JWT::decode($token,$secret_key,array('HS512'));
                  $email = $decoded_array->data->email;
                  if($this->has_same_token($token)){
                     $query = $this->update_password($email,$password);
                  }else{
                     echo "token incorrect";
                  }
                  break;

               case 'DELETE':
                  $query = $this->delete_user($id);
                  break;

               default:
                  $this->_response("Method Not Allowed",405);
         }

         if(!empty($query)){
               $result = mysqli_query($this->conn->get_connection(),$query);
         }else{
               $result = NULL;
         }

         if($this->method == "GET"){
            if(mysqli_num_rows($result) == 0){
               $this->_response("No match found",404);
            }else{
               echo "\n";
               while($row = mysqli_fetch_assoc($result)){
                  echo $row['email'] . "\n";
               }
            }
         }
         if($this->method == 'POST' && $result){
            $secret_key = base64_decode(SECRET_KEY);
            $jwt = generate_token($email); 
            setcookie("token",$jwt);
            echo $jwt;
         }

         if($this->method == 'PUT' && $result){
            echo "Password changed";
         }
      }
      
      private function register($email,$username,$password){
         $password = md5($password);
         $query = "INSERT INTO user (`email`,`username`,`password`) VALUES ('$email','$username','$password')";
         return $query;
      }

      private function delete_user($id){
         // $query = "DELETE FROM $request WHERE id = $id";
         $query = "DELETE From wallet_data WHERE user_id = $id";
         mysqli_query($this->conn->get_connection(),$query);
         $query = "DELETE cd from category_data as cd INNER JOIN category as c ON c.id = cd.category_id WHERE c.user_id = $id";
         mysqli_query($this->conn->get_connection(),$query);
         $query = "DELETE FROM category WHERE user_id = $id";
         mysqli_query($this->conn->get_connection(),$query);
         $query = "DELETE from user WHERE id = $id";
         mysqli_query($this->conn->get_connection(),$query);
      }

      private function get_user($request){
         $query = "SELECT * FROM $request";
         return $query;
      }

      private function get_user_id($request,$id){
         $query = "SELECT * FROM $request WHERE id = $id";
         return $query;
      }

      private function update_password($email,$password){ 
         $password = md5($password);
         $query = "UPDATE user SET password = '$password' WHERE email = '$email'";
         return $query;
      }

      private function login($email,$password){
         $email = $email;
         $password = md5($password);
         $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
         $result = mysqli_query($this->conn->get_connection(),$query);
         if(mysqli_num_rows($result)>0){
            $secret_key = base64_decode(SECRET_KEY);
            $jwt = generate_token($email); 
            // setcookie("token",$jwt);
            echo $jwt;
         }else{
            echo "Invalid Username or Password";
         }
      }

      private function insert_token($email,$token){
         $query = "SELECT * FROM token WHERE email = '$email'";
         $result_token = mysqli_query($this->conn->get_connection(),$query);
         if(mysqli_num_rows($result_token)>0){
               $query = "UPDATE token SET token = '$token' WHERE email = '$email'";
               $result = mysqli_query($this->conn->get_connection(),$query);
         }else{
               $query = "INSERT INTO token (`email`,`token`) VALUES ('$email','$token')";
               $result = mysqli_query($this->conn->get_connection(),$query);
         }
      }

      private function has_same_token($token){
         $secret_key = base64_decode(SECRET_KEY);
         $decoded_array = JWT::decode($token,$secret_key,array('HS512'));
         $email = $decoded_array->data->email;
         $query = "SELECT token FROM token WHERE email = '$email'";
         $result = mysqli_query($this->conn->get_connection(),$query);
         $saved_token = mysqli_fetch_assoc($result);
         $saved_token = $saved_token['token'];
         if($token == $saved_token){ 
               return 1;
         }else{
               return 0;
         }
      }

      private function check_fields($email,$password,$username){
         $message = "";
         $query = $this->get_user('user');
         $result = mysqli_query($this->conn->get_connection(),$query);
         $users = []; //stores user's email from database
         while($row = mysqli_fetch_assoc($result)){
            $users[] = $row['email'];
         }
         if($email == ""){
            $message = "Email required";
         }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $message = "Email Invalid";
         }else if($password == ""){
            $message = "Passsword required";
         }else if($username == ""){
            $message = "Username required";
         }else if(in_array($email,$users)){
            $message = "Email already taken";
         }
         return $message;
      }
   } 

   if(isset($_GET['request'])){
      $user = new Users($_GET['request']);
   }   
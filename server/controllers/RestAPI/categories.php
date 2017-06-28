<?php
   require_once 'api.php';
   require_once '../../includes/database.php';
   require_once '../../vendor/autoload.php';
   use \Firebase\JWT\JWT;
   class Categories extends wrapper{
      private $conn;
      private $email;
      private $required_token;
      public function __construct($request){
         parent::__construct($request);
         $this->conn = new Database();
         // $token = $_COOKIE['token'];
         if(isset($this->token)){
            $this->required_token = $_COOKIE['token'];
         }else{
            $this->required_token = $this->access_token;
         }
         $this->verify_token();
         $secret_key = base64_decode(SECRET_KEY);
         $decoded_array = JWT::decode($this->required_token,$secret_key,array('HS512'));
         $this->email = $decoded_array->data->email;
         switch($this->method){
            case 'GET':
               if(isset($this->params['param1']) && !isset($this->params['param2'])){
                  $this->get_user_categories();
               }else if(isset($this->params['param2'])){
                  $this->get_category_data($this->params['param2']);
               }
               break;

            case 'POST':
               if(isset($this->params['param1']) && !isset($this->params['param2'])){
                  $post_values = json_decode(file_get_contents("php://input"),true);
                  $category_name = $post_values['name'];
                  if(empty($category_name)){
                     echo "empty";
                  }else{
                     $this->add_categories($category_name);
                  }
               }else if(isset($this->params['param2'])){
                  $post_values = json_decode(file_get_contents("php://input"),true);
                  // $category_name = $post_values['name'];
                  $category_name = $this->params['param2'];
                  $field_name = $post_values['field_name'];
                  $field_value = $post_values['field_value'];
                  $user_id = $this->logged_in_email();
                  if(empty($field_name)){
                     echo "Category field empty";
                  }else{
                     $this->add_data($user_id,$category_name,$field_name,$field_value); 
                  }
               }
               break;

            case 'PUT':
               $category_name = $this->params['param2'];
               $post_values = json_decode(file_get_contents("php://input"),true);
               if(isset($this->params['param2']) && !isset($this->params['param3'])){
                  $new_category_name = $post_values['name'];
                  if(empty($new_category_name)){
                     echo "name empty";
                  }else{
                     $this->update_category($category_name,$new_category_name);
                  }
               }else if(isset($this->params['param3'])){
                  $category_data = $this->params['param3'];
                  $new_data = $post_values['new_data'];
                  $new_value = $post_values['new_value'];
                  if(empty($new_data)){
                     echo "field empty";
                  }else{
                     $this->update_data($category_name,$category_data,$new_data,$new_value); 
                  }
               }
               break;

            case 'DELETE':
               $category_name = $this->params['param2'];
               if(isset($this->params['param2']) && !isset($this->params['param3'])){
                  $this->delete_categories($category_name);
               }else if(isset($this->params['param3'])){
                  $category_data = $this->params['param3'];
                  $this->delete_data($category_name,$category_data);   
               }
               break;
         }
      }

      private function get_user_categories(){
         $user_id = $this->logged_in_email();
         $query = "SELECT * FROM category WHERE user_id = $user_id";
         $result = mysqli_query($this->conn->get_connection(),$query);
         $category = [];
         while($row = mysqli_fetch_assoc($result)){
            $category[] = $row['name']; 
         }
         $category = Array('categories' => $category);
         echo json_encode($category);
      }

      private function get_category_data($category_name){
         $user_id = $this->logged_in_email();
         // $query = "SELECT field_name FROM category_data as data INNER JOIN category 
         // --           ON data.category_id = category.id WHERE category.user_id = $user_id AND category.name = '$category_name'"; 
         // $category_data = [];
         $category_id = $this->categoryId_from_userId($user_id,$category_name);
         $query = "SELECT c.field_name,w.field_value FROM wallet_data as w inner join category_data as c 
                   on w.category_data_id=c.id where c.category_id = $category_id";
         $result = mysqli_query($this->conn->get_connection(),$query);
         $category_data = [];
         while($row = mysqli_fetch_assoc($result)){
            $category_data[$row['field_name']] = $row['field_value'];
         }
         // print_r($result);
         echo json_encode($category_data);
      }

      private function add_categories($category){
         $user_id = $this->logged_in_email();
         $query = "INSERT INTO category (`user_id`,`name`) VALUES ($user_id,'$category')";
         if(mysqli_query($this->conn->get_connection(),$query)){
            echo "Category added";
         }else{
            echo "Cannot add category";
         }
      }

      //add category data
      private function add_data($user_id,$category_name,$field_name,$field_value){
         $category_id = $this->categoryId_from_userId($user_id,$category_name);
         $query = "INSERT INTO category_data (`category_id`,`field_name`) VALUES ($category_id,'$field_name')";
         if(mysqli_query($this->conn->get_connection(),$query)){
            $id = mysqli_insert_id($this->conn->get_connection()); //last inserted id for category_data_id
            $query = "INSERT INTO wallet_data (`user_id`,`category_id`,`category_data_id`,`field_value`) 
                      VALUES ($user_id,$category_id,$id,'$field_value')";
            mysqli_query($this->conn->get_connection(),$query);
         }
      }

      //api/user/categories/($category_name)
      private function delete_categories($category_name){
         $user_id = $this->logged_in_email();
         $category_id = $this->categoryId_from_userId($user_id,$category_name);
         $query = "SELECT id FROM category_data WHERE category_id = $category_id";
         $result = mysqli_query($this->conn->get_connection(),$query);
         $category_data_id = [];
         if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
               $category_data_id[] = $row['id'];
            }
            $category_data_id = implode($category_data_id,",");
            $this->delete_selected_rows('wallet_data','category_data_id',$category_data_id);
            $this->delete_selected_rows('category_data','id',$category_data_id);
         }
         $this->delete_selected_rows('category','id',$category_id);
         if(mysqli_affected_rows($this->conn->get_connection()) > 0){
            echo "Category " . $category_name . " deleted";
         }else{
            echo "Cannot delete category";
         }
      }

      //api/user/categories/($category_name)/($category_data)
      private function delete_data($category_name,$category_data){
         $user_id = $this->logged_in_email();
         $category_id = $this->categoryId_from_userId($user_id,$category_name);
         $query = "DELETE w FROM wallet_data AS w INNER JOIN category_data AS c ON w.category_data_id=c.id  
                   WHERE user_id = $user_id AND w.category_id=$category_id AND field_name='$category_data'";
         mysqli_query($this->conn->get_connection(),$query);
         $query = "DELETE FROM category_data WHERE category_id = $category_id AND field_name = '$category_data'";
         mysqli_query($this->conn->get_connection(),$query);
      }

      //api/user/categories/(category_name)
      private function update_category($category_name,$new_category_name){
         $user_id = $this->logged_in_email();
         $query = "UPDATE category SET name = '$new_category_name' WHERE user_id = $user_id AND name = '$category_name'";
         mysqli_query($this->conn->get_connection(),$query);
      }

      //api/user/categories/($category_name)/($category_data)
      private function update_data($category_name,$category_data,$new_data,$new_value){
         $user_id = $this->logged_in_email();
         $category_id = $this->categoryId_from_userId($user_id,$category_name);
         $query = "SELECT id FROM category_data WHERE category_id = $category_id AND field_name = '$category_data'";
         $result = mysqli_fetch_assoc(mysqli_query($this->conn->get_connection(),$query));
         $category_data_id = $result['id']; 
         $query = "UPDATE category_data SET field_name = '$new_data' WHERE category_id = $category_id AND field_name = '$category_data'";
         mysqli_query($this->conn->get_connection(),$query);
         $query = "UPDATE wallet_data SET field_value = '$new_value' WHERE category_data_id = $category_data_id";
         mysqli_query($this->conn->get_connection(),$query);
      }

      //returns logged in user's id
      private function logged_in_email(){
         $query = "SELECT id FROM user WHERE email = '$this->email'";
         $result = mysqli_fetch_assoc(mysqli_query($this->conn->get_connection(),$query));
         $id = $result['id'];
         return $id;
      }

      //get category id of logged in user to insert the data in selected category
      private function categoryId_from_userId($user_id,$category_name){
         $query = "SELECT id FROM category WHERE user_id = $user_id AND name = '$category_name'";
         $result = mysqli_fetch_assoc(mysqli_query($this->conn->get_connection(),$query));
         $category_id = $result['id'];
         return $category_id; }

      //values = numbers of ids to be deleted
      private function delete_selected_rows($table,$delete_id,$values){
         $query = "DELETE FROM $table WHERE $delete_id in ($values)";
         mysqli_query($this->conn->get_connection(),$query);   
      }
   }

   $category = new Categories($_GET['request']);
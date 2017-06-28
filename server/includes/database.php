<?php require_once 'constants.php';?>
<?php 
   class Database{
      public $db;
      public function __construct(){
         $this->db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB);
         if(!$this->db){
               echo "connection failed";
         }
      }

      public function get_connection(){
         return $this->db;
      }

   }
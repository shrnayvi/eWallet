<?php 
   require_once '../../includes/database.php';
   require_once '../../includes/functions.php';
   require_once '../../phpmailer/PHPMailerAutoload.php';
   require_once '../../vendor/autoload.php';
   use \Firebase\JWT\JWT;

   abstract class wrapper{
      protected $method;
      protected $params;
      protected $token;
      protected $access_token;
      public function __construct($request){
         $this->method = $_SERVER['REQUEST_METHOD'];
         $headers = getallheaders();
         $token_not_required = array('login','register','email');
         $this->access_token = isset($headers['access_token'])?$headers['access_token'] : NULL;
         
         if(isset($this->access_token) || in_array($request,$token_not_required) || ($this->method == 'PUT' && $request == 'user')){
            if(!$this->has_route($request) == true){
               $this->_response("Error:Page Not Found",404);
               die;
            }
         }else{
            $this->_response("Please login or provide correct token",401); die;
         }
         $this->params = $this->set_params();
      }

      private function set_params(){
         if(isset($_GET['params'])){
            $args = $_GET['params'];
            for($i = 1; $i <= count($args); $i++){
               $params['param'.$i] = $args[$i-1];
            }
         }else{
            $params = "";
         }
         return $params;
      }

      protected function verify_token(){
         $provided_token = "";
         if(isset($this->access_token)){
            $provided_token = $this->access_token;
         }
         try{
            $secretKey = base64_decode(SECRET_KEY); 
            $DecodedDataArray = JWT::decode($provided_token, $secretKey, array('HS512'));
         }catch (Exception $e) {
            $this->_response("Please provide correct token",401); die;
         }
      }

      private function has_route($request){
         $flag = false;
         $routes = Array('user','email','login','register','categories');
         if(in_array($request,$routes)){
               $flag = true;
         }
         return $flag;
      }

      protected function _response($data, $status = 200) {
         header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
         echo $data."\n";
      }

      private function _requestStatus($code) {
         $status = array(  
               200 => 'OK',
               404 => 'Not Found',   
               405 => 'Method Not Allowed',
               500 => 'Internal Server Error',
               401 => 'Unauthorized',
         ); 
         return ($status[$code])?$status[$code]:$status[500]; 
      }

      protected function send_token($from,$to,$message='',$reply_to){
         $mail = new PHPMailer;
         $mail->isSMTP();     
         $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
         $mail->SMTPAuth = true;                               // Enable SMTP authentication
         $mail->Username = $from;                 // SMTP username
         $mail->Password = "";                           // SMTP password
         $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
         $mail->Port = 465;                                    

         $mail->setFrom($from, 'eWallet');
         $mail->addAddress($to, '');     // Add a recipient
         $mail->addReplyTo($reply_to,'');
         
         $mail->isHTML(true);
         $mail->Subject = 'Quote Request';
         $mail->Body    = "$message";
         //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

         if(!$mail->send()) {
               echo 'Message could not be sent.';
               echo 'Mailer Error: ' . $mail->ErrorInfo;
         } else {
               return true ;
         }
      }
   }
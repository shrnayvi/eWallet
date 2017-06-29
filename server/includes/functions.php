<?php 
   require_once '../../vendor/autoload.php';
   use \Firebase\JWT\JWT;
   define('SECRET_KEY','VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==');

   function generate_random_token($email){
      $tokenId = base64_encode(mcrypt_create_iv(32));
      // date_default_timezone_set("Asia/Kathmandu");
      $name = generate_random_string();//random string for the name
      $issuedAt = time();
      $notBefore = $issuedAt-1;
      $expire = $notBefore + 60*60;
      $serverName = 'http://localhost/eWallet';
      $data = [
         'iat' => $issuedAt,
         'jti' => $tokenId,
         'iss' => $serverName,
         'nbf' => $notBefore,
         'exp' => $expire,
         'data' => [
               'name' => $name,
               'email' => $email
         ]
      ];
      $secret_key = base64_decode(SECRET_KEY);
      
      $jwt = JWT::encode(
                  $data,
                  $secret_key,
                  'HS512'
               );
      // setcookie("test",$jwt);
      $unencoded_array = ['jwt' => $jwt];
      return $unencoded_array;
   }
   
   function generate_random_string($length=10){
      $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $characters_length = strlen($characters);
      $string = "";
      for($i=0;$i<$length;$i++){
         $string.= $characters[rand(0,($characters_length-1))];
      }
      return $string;
   }

   function mail_admin($from,$to,$message='',$reply_to){
      require '../phpmailer/PHPMailerAutoload.php';
      $mail = new PHPMailer;
      $mail->isSMTP();     
      $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $from;                 // SMTP username
      $mail->Password = "";                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to

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

   function generate_token($email){
      $tokenId = base64_encode(mcrypt_create_iv(32));
      date_default_timezone_set("Asia/Kathmandu");

      $issuedAt = time() - 1;
      $notBefore = $issuedAt + 0.1;
      $expire = $notBefore + 60*60*24;
      $serverName = 'http://localhost/eWallet';
      $data = [
         'iat' => $issuedAt,
         'jti' => $tokenId,
         'iss' => $serverName,
         'nbf' => $notBefore,
         'exp' => $expire,
         'data' => [
               'email' => $email,    
         ]
      ];

      $secret_key = base64_decode(SECRET_KEY);
      
      $jwt = JWT::encode(
                  $data,
                  $secret_key,
                  'HS512'
               );
      return $jwt;
   }

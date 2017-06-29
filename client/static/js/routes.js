Finch.route("/dashboard",function(){
   show_categories();
});

Finch.route("/login",function(){
   show_templates("http://localhost/eWallet/client/templates/login.php","login");
});

Finch.route("/forgotpassword",function(){
   show_templates("http://localhost/eWallet/client/templates/forgot_password.php","forgot-password-template");
});

Finch.route("/register",function(){
   show_templates('http://localhost/eWallet/client/templates/registration.php','registration');
});

Finch.route("/request-token",function(){
   Finch.observe("email",function(email){
      request_token_template(email);
   });
});

Finch.route('data',function(){
   Finch.observe('category',function(category){
      show_data(category);
   });
});

Finch.listen();
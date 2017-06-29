//all the login works
$("#login-nav").click(function(e){
   e.preventDefault();
   if(get_cookie("token")!=""){
      Finch.navigate("dashboard");
   }else{
      Finch.navigate("login");
   }
});

function user_login(){
   form_data = {
      email: $("#email").val(),
      password: $("#password").val() 
   };
   $.ajax({
      type: 'POST',
      url: 'http://localhost/eWallet/server/controllers/RestAPI/users.php?request=login',    
      data: JSON.stringify(form_data), 
      success: function(data){
         if(data == "Invalid Username or Password"){
            $("#invalid").html(data);
         }else{
            document.cookie = "token=" + data;
            $("#logout-nav").css("display","block");
            $("#login-nav").css("display","none");
            $("#dashboard-nav").css("display","block");
            $("#register").css("display","none");
            Finch.navigate("dashboard");
         }
      },
   });
   return false;
}

function forgot_password(){
   Finch.navigate("forgotpassword");
   return false;
}

function request_token(msg="sent"){
   $.ajax({
      url: 'http://localhost/eWallet/server/controllers/RestAPI/users.php?request=email',
      type: 'POST',
      data: JSON.stringify({
         email : $("#email").val()
      }),
      success: function(data){
         if(data == "Invalid email or empty email field"){
            $("#invalid").html(data);
         }else{
            alert("Token has been " +msg+ " to your email account");
            Finch.navigate("request-token",{email: $("#email").val()});
         }
      }
   });
   return false;
}

function new_password(){
   $.ajax({
      url: 'http://localhost/eWallet/server/controllers/RestAPI/users.php?request=user',
      type: 'PUT',
      data: JSON.stringify({
         token: $("#token").val(),
         password: $("#password").val()
      }),
      success: function(data){
         alert(data);
         if(data == "Password changed"){
               Finch.navigate("login");
         }else{
               $("#invalid").html(data);
         }
      }
   });
   return false;
}

$(document).on('click','#dashboard-nav',function(e){
   e.preventDefault();
   Finch.navigate("dashboard");
})
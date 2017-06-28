//all the registration works
$("#register").click(function(e){
   e.preventDefault();
   Finch.navigate("register");
});

function register_user(){
   form_data = {
      username: $("#username").val(),
      email: $("#email").val(),
      password: $("#password").val() 
   };
   $.ajax({
      type: 'POST',
      url: 'http://localhost/eWallet/server/controllers/RestAPI/users.php?request=register',    
      data: JSON.stringify(form_data), 
      success: function(data){
         if(data == "Email required"){
            $("#invalid").html(data);
         }else if(data == "Email Invalid"){
            $("#invalid").html("Please enter valid email address");
         }else if(data == "Password required"){
            $("#invalid").html(data);
         }else if(data == "Username required"){
            $("#invalid").html(data);
         }else if(data == "Email already taken"){
            $("#invalid").html("This email already exists. Please provide another email address!!");
         }else{
            // document.cookie = "token=" + data;
            $("#logout-nav").css("display","block");
            Finch.navigate("dashboard");
         }
      },
   });
   return false;
}

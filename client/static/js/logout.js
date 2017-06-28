$("#logout-nav").click(function(e){
   e.preventDefault();
   document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
   $("#logout-nav").css("display","none");
   $("#login-nav").css("display","block");   
   $("#dashboard-nav").css("display","none");
   $("#register").css("display","block");   
   Finch.navigate("login");
});
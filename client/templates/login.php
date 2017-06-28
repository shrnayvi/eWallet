<script id="login" type="text/x-handlebars-template">
   <div class="col-sm-4" id="wrapper">
      <div class="panel panel-primary">
         <div class="panel-heading center-text">Login</div>
         <div class="panel-body">
               <form action="#/dashboard" id="form-register" method="post" name="myForm" onsubmit="return user_login()">
                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-envelope icon-size"></i></span>
                           <input type="text" class="form-control" name="email" id="email" placeholder="Email or Username"> 
                     </div>
                  </div>

                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-lock icon-size"></i></span>
                           <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
                     </div>
                  </div>
                  <p id="invalid"></p>
                  <a href="#/forgotpassword" id="pass" class="pull-left" onclick="forgot_password()">Forgot Password?</a>
                  <button type="submit" id="submit" class="btn btn-primary pull-right" >Login</button>
               </form>
         </div>
      </div>
   </div>
</script>

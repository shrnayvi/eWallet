<script id="registration" type="text/x-handlebars-template">
   <div class="col-sm-4" id="wrapper">
   <div class="panel panel-primary">
      <div class="panel-heading center-text">Register</div>
      <div class="panel-body">
         <form id="form-register" method="post" onsubmit="return register_user()" name="myForm" >
               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon"><i class="fa fa-user icon-size"></i></span>
                     <input type="text" class="form-control" name="username" id="username" placeholder="Username"> 
                  </div>
               </div>
               
               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon"><i class="fa fa-envelope icon-size"></i></span>
                     <input type="text" class="form-control" name="email" id="email" placeholder="Email"> 
                  </div>
               </div>

               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon"><i class="fa fa-lock icon-size"></i></span>
                     <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
                  </div>
               </div>
               <p id="invalid"></p>
               <button id="submit" class="btn btn-primary pull-right">Register</button>
         </form>
      </div>
   </div>
   </div>
</script>
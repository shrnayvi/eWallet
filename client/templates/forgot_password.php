<script id="forgot-password-template" type="text/x-handlebars-template">
   <div class="col-sm-4" id="wrapper">
      <div class="panel panel-primary">
         <div class="panel-heading center-text">Forgot Password</div>
         <div class="panel-body">
               <form  id="form-register" method="post" name="myForm" onsubmit="return request_token()">
                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-envelope icon-size"></i></span>
                           <input type="text" class="form-control" name="email" id="email" placeholder="Email or Username"> 
                     </div>
                  </div>
                  <p id="invalid"></p>
                  <button id="send" class="btn btn-primary pull-right">Send</button>
               </form>
         </div>
      </div>
   </div>
</script>

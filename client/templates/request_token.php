<script id="request-token" type="text/x-handlebars-template">
   <div class="col-sm-4" id="wrapper">
      <div class="panel panel-primary">
         <div class="panel-heading center-text">Request token</div>
         <div class="panel-body">
               <form id="form-register" method="post" name="myForm" onsubmit="return new_password()">
                  <div class="form-group">
                     <label>Please enter the token sent to your email account</label>
                     <input type="text" class="form-control" name="token" id="token" placeholder="Enter token">
                  </div>
                  <div class="form-group">
                     <label>Enter your new password</label>
                     <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                  </div>
                  <input id="email" class="re-email" value="{{email}}">
                  <p id="invalid"></p>
                  <p class="pull-left">Didn't get token? <a href="#" id="resend" onclick="return request_token('resent')">resend</a> again</p>
                  <button type="submit" id="submit" class="btn btn-primary pull-right">Submit</button>
               </form>
         </div>
      </div>
   </div>
</script>
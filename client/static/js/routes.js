Finch.route("/dashboard",function(){
   $.ajax({
      url: 'http://localhost/eWallet/api/user/categories',
      type: 'GET',
      dataType: 'json',
      success: function(data){
         var categories = data; 
         show_templates('http://localhost/eWallet/client/templates/dashboard.php','categories-template',categories);
      },
      error: function(){
         alert("There is a server problem or you are logged out");
      }
   }); 
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

Finch.route("/add-category",function(){
   show_templates('http://localhost/eWallet/client/templates/add_categories.php','add-category-template');
});

Finch.route("/edit-category",function(){
   Finch.observe("category",function(category){
      var value = {"name" : category};
      show_templates('http://localhost/eWallet/client/templates/edit_category.php','edit-category-template',value);
   })
});

Finch.route("/edit-data",function(){
      Finch.observe("category","field","value",function(category,field,value){
         var json = {"field" : field,"value": value};
         show_templates('http://localhost/eWallet/client/templates/edit_data.php','edit-data-template',json)
      })
})

Finch.route("/add-data",function(){
   Finch.observe('category',function(category){
      show_templates('http://localhost/eWallet/client/templates/add_category_field.php','add-field-template');
   });
});

Finch.route('data',function(){
   Finch.observe('category',function(category){
      $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category,
         type: 'GET',
         dataType: 'json', 
         success: function(data){
            var category_data = {"category" : data};
            show_templates('http://localhost/eWallet/client/templates/category_data_template.php','categories-data-template',category_data);
         }
      });
   });
});

Finch.listen();
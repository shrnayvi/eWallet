var token = get_cookie('token');

function show_category_data(name){
   Finch.navigate("data" ,{category: name});
}

//adds category
$(document).on('submit','#submit-addCategory',function(event){
   event.preventDefault();
   form_data = {name : document.getElementById('new-category').value};
   $.ajax({
      url: 'http://localhost/eWallet/api/user/categories',
      type: 'POST',
      headers: {'access_token' : token},
      data: JSON.stringify(form_data),
      success: function(data){
         if(data == 'empty'){
            document.getElementById('invalid').innerHTML += "Category field is empty";
         }else{
            show_categories();
            $('#add-Modal').remove();
            $('.modal-backdrop').remove(); // removes the overlay
         }
      }
   });
   return false;
})

//adds data
$(document).on('submit','#add-categoryField',function(event){
   form_data = {
      field_name: document.getElementById('field').value,
      field_value: document.getElementById('field-value').value
   };
   var url = window.location.href;
   url = url.split("=");
   var category_name = url[1];
   category_name = category_name.replace(/25+/g,""); 
   $.ajax({
      url: 'http://localhost/eWallet/api/user/categories/'+category_name,
      type: 'POST',
      headers: {"access_token" : token},
      data: JSON.stringify(form_data),
      success: function(data){
         if(data == "Category field empty"){
            document.getElementById('invalid').innerHTML += "Category field is empty";
         }else{
            show_data(category_name);
            $('#add-Modal').remove();
            $('.modal-backdrop').remove(); // removes the overlay
         }
      }
   });
   return false;
});

//deletes category 
$(document).on('click','.delete-category',function(){
   if(confirm("Are you sure?")){
      var category = $(this).attr('id');
      var parent = $(this).parent().parent();
      $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category,
         type: 'DELETE',
         headers: {"access_token" : token},
         success: function(data){
            parent.remove();
         }
      });
   }
});

//deletes category fields and values
$(document).on('click','.delete-data',function(){
   if(confirm("Are you sure?")){
      var category_field = $(this).attr('id');
      var parent = $(this).parent().parent();
      var url = window.location.href;
      var category = url.split("=");
      category = category[1];
      category = category.replace(/25+/g,'');
      $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category+'/'+category_field,
         type: 'DELETE',
         headers: {"access_token" : token},
         success: function(data){
            parent.remove();  
         }
      });
   }
});

//locally stores the data
$(document).on('click','.edit-category',function(){
   var category_name  = $(this).attr('id');
   localStorage.setItem("local_value",category_name);
   var given_category = localStorage.getItem("local_value");
   $('#edit-category').val(given_category);
});

//edits category
$(document).on('submit','#submit-editCategory',function(){
   form_data = {name: document.getElementById('edit-category').value};
   var category = localStorage.getItem("local_value");
   $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category,
         type: 'PUT',
         headers: {'access_token' : token},
         data: JSON.stringify(form_data),
         success: function(data){
            if(data == "name empty"){
               document.getElementById('invalid').innerHTML += "Category is empty";
            }else{
               localStorage.clear();
               show_categories();
               $("#edit-Modal").remove();
               $(".modal-backdrop").remove();
            }
         }
   });
   return false;
});

//locally storing the values for edit data
$(document).on('click','.edit-data',function(){
   var field_name = $(this).attr('id');
   var field_value = $(this).attr('name');
   var url = window.location.href;
   url = url.split("=");
   var category_name = url[1];
   var local = {field: field_name,value: field_value,category: category_name};
   local = JSON.stringify(local);
   localStorage.setItem("local_value",local);
   var data = JSON.parse(localStorage.getItem("local_value"));
   $('#new-data').val(data.field);
   $('#new-value').val(data.value);
});

//edits the data
$(document).on('submit','#submit-editData',function(){
   var local = localStorage.getItem("local_value");
   local = JSON.parse(local);
   var category_name = local.category;
   var field_name = local.field;
   form_data = {
                  new_data : document.getElementById('new-data').value,
                  new_value : document.getElementById('new-value').value
               }
      $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category_name+'/'+field_name,
         type: 'PUT',
         headers: {'access_token' : token},
         data: JSON.stringify(form_data),
         success: function(data){   
            if(data == "field empty"){
               document.getElementById('invalid').innerHTML += "Field id empty";
            }else{
               localStorage.clear();
               show_data(category_name);
               $("#edit-dataModal").remove();
               $(".modal-backdrop").remove();
            }
         },
         error: function(){
            console.log("error");
         }
      });
   return false;
});

$(document).on('click','#back',function(){
   Finch.navigate("dashboard");
});

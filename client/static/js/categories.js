function show_category_data(name){
Finch.navigate("data" ,{category: name});
}

//template
$(document).on('click','.add-category',function(){
Finch.navigate("add-category");
});

//adds category 
function add_category(){
form_data = {name : document.getElementById('new-category').value};
$.ajax({
   url: 'http://localhost/eWallet/api/user/categories',
   type: 'POST',
   data: JSON.stringify(form_data),
   success: function(data){
      if(data == 'empty'){
         document.getElementById('invalid').innerHTML += "Category field is empty";
      }else{
         Finch.navigate("dashboard");
      }
   }
});
return false;
}

//template
$(document).on('click','#add-data',function(){
var url = window.location.href;
   url = url.split("=");
   var category = url[1];
   Finch.navigate("add-data",{category: category});
});

//adds category field
function add_category_field(){
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
      data: JSON.stringify(form_data),
      success: function(data){
         if(data == "Category field empty"){
            document.getElementById('invalid').innerHTML += "Category field is empty";
         }else{
            Finch.navigate("data" ,{category: category_name});
         }
      }
   });
   return false;
}

//deletes category 
$(document).on('click','.delete-category',function(){
   if(confirm("Are you sure?")){
      var category = $(this).attr('id');
      var parent = $(this).parent().parent();
      $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category,
         type: 'DELETE',
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
         success: function(data){
            parent.remove();  
         }
      });
   }
});

//template
$(document).on('click','.edit-category',function(){
   var category_name  = $(this).attr('id');
   Finch.navigate("edit-category",{category: category_name});
});

//edits category
function edit_category(){
   form_data = {name: document.getElementById('new-category').value};
   var url = window.location.href;
   url = url.split("=");
   var category = url[1];
   $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category,
         type: 'PUT',
         data: JSON.stringify(form_data),
         success: function(data){
            if(data == "name empty"){
               document.getElementById('invalid').innerHTML += "Category is empty";
            }else{
               Finch.navigate("dashboard");
            }
         }
   });
   return false;
}

//template
$(document).on('click','.edit-data',function(){
   var field_name = $(this).attr('id');
   var field_value = $(this).attr('name');
   var url = window.location.href;
   url = url.split("=");
   var category_name = url[1];
   Finch.navigate("edit-data",{category: category_name,field: field_name,value: field_value}) 
});

//edits category data
function edit_data(){
   var url = window.location.href;
   url = url.split("=");
   var category_name = url[1];
   category_name = category_name.split("&");
   category_name = category_name[0];
   category_name = category_name.replace(/25+/g,"");
   var field_name = url[2];
   field_name = field_name.split("&");
   field_name = field_name[0];
   form_data = {
                  new_data : document.getElementById('new-data').value,
                  new_value : document.getElementById('new-value').value
               }
      $.ajax({
         url: 'http://localhost/eWallet/api/user/categories/'+category_name+'/'+field_name,
         type: 'PUT',
         data: JSON.stringify(form_data),
         success: function(data){   
            if(data == "field empty"){
               document.getElementById('invalid').innerHTML += "Field id empty";
            }else{
               Finch.navigate("data",{category: category_name});
            }
         }
      });
      return false;
   }


$(document).on('click','#back',function(){
   Finch.navigate("dashboard");
})

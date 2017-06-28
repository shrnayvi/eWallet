<script id="edit-category-template" type="text/x-handlebars-template">
   <div id="page-content">
      <form id="" method="post" onsubmit="return edit_category()" name="myForm" >
         <div class="form-group">
            <label>Edit category</label>
            <input type="text" class="form-control" name="new-category" id="new-category" placeholder="Enter category" value="{{name}}"> 
         </div>

         <p id="invalid"></p>
         <button id="submit" class="btn btn-primary">Edit category</button>
      </form>
   </div>
</script>
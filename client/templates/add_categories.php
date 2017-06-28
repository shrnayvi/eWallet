<script id="add-category-template" type="text/x-handlebars-template">
   <div id="page-content">
      <form id="" method="post" onsubmit="return add_category()" name="myForm" >
            <div class="form-group">
               <label>Enter new category</label>
               <input type="text" class="form-control" name="new-category" id="new-category" placeholder="Enter category"> 
            </div>

            <p id="invalid"></p>
            <button id="submit" class="btn btn-primary">Add category</button>
      </form>
   </div>
</script>
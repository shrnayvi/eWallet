<script id="edit-data-template" type="text/x-handlebars-template">
   <div id="page-content">
      <form id="" method="post" onsubmit="return edit_data()" name="myForm" >
            <div class="form-group">
               <label>Edit field</label>
               <input type="text" class="form-control" name="new-category" id="new-data" placeholder="Enter field" value="{{field}}"> 
            </div>

            <div class="form-group">
               <label>Edit value</label>
               <input type="text" class="form-control" name="new-category" id="new-value" placeholder="Enter value" value="{{value}}"> 
            </div>

            <p id="invalid"></p>
            <button id="submit" class="btn btn-primary">Edit category</button>
      </form>
   </div>
</script>
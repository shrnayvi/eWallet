<script id="add-field-template" type="text/x-handlebars-template">
   <div id="page-content">
      <form id="" method="post" onsubmit="return add_category_field()" name="myForm" >
            <div class="form-group">
               <label>Enter category field</label>
               <input type="text" class="form-control" name="field" id="field" placeholder="Enter Field"> 
            </div>

            <div class="form-group">
               <label>Enter field value</label>
               <input type="text" class="form-control" name="field-value" id="field-value" placeholder="Enter field value">
            </div>

            <p id="invalid"></p>
            <button id="submit" class="btn btn-primary">Add category</button>
      </form>
   </div>
</script>
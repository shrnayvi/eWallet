<script id="categories-template" type="text/x-handlebars-template">
   <div id="categories">
      <h1>Categories</h1>
      <button class="btn btn-primary pull-right add-category" id="right-align" data-toggle="modal" data-target="#add-Modal">Add Categories</button>
      <table class="table">
         <thead>
            <th>Categories</th> 
            <th>Action</th>
         </thead>
         <tbody>
         {{#each categories}}
            <tr>
               <td><p class="pointer" onclick="show_category_data('{{this}}')">{{this}}</p></td>
               <td>
                  <button class="btn btn-danger delete-category" id="{{this}}">Delete</button>
                  <button class="btn btn-success edit-category" id="{{this}}" data-toggle="modal" data-target="#edit-Modal">Edit</button>
               </td>
            </tr>
         {{/each}}
         </tbody>
      </table>
   </div>

   <div id="add-Modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Add Category</h4>
            </div>
            <div class="modal-body">
               <form id="submit-addCategory" method="post" name="myForm">
                     <div class="form-group">
                        <label>Enter new category</label>
                        <input type="text" class="form-control" name="new-category" id="new-category" placeholder="Enter category"> 
                     </div>

                     <p id="invalid"></p>
                     <button id="submit" class="btn btn-primary">Add category</button>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>

   <div id="edit-Modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close cancel" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Edit data</h4>
            </div>
            <div class="modal-body">
               <form id="submit-editCategory" method="post" name="myForm">
                  <div class="form-group">
                     <label>Edit category</label>
                     <input type="text" class="form-control" name="edit-category" id="edit-category" placeholder="Enter category" value="{{name}}"> 
                  </div>

                  <p id="invalid"></p>
                  <button id="submit" class="btn btn-primary">Edit category</button>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</script>


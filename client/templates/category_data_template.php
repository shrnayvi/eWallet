<script id="categories-data-template" type="text/x-handlebars-template">
   <div id="page-content">
      <button class="btn btn-primary" id="back">go back</button>
      <button class="btn btn-primary pull-right" id="add-data" data-toggle="modal" data-target="#add-dataModal">Add data</button>
      <table class="table">
         <thead>
            <th>Category Data</th>
            <th></th>
            <th>Action</th>
         </thead>
         <tbody>
               {{#each category}}
                  <tr>
                     <td>{{@key}}</td> 
                     <td>{{this}}</td>
                     <td>
                        <button class="btn btn-success edit-data" name="{{this}}" id="{{@key}}" data-toggle="modal" data-target="#edit-dataModal">Edit</button>
                        <button class="btn btn-danger delete-data" id="{{@key}}">Delete</button>
                     </td>
                  </tr>
               {{/each}}
         </tbody>
      </table>
   </div>

   <div id="add-dataModal" class="modal fade" role="dialog">>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Add data</h4>
            </div>
            <div class="modal-body">
                  <form id="add-categoryField" method="post" name="myForm" >
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
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>

   <div id="edit-dataModal" class="modal fade" role="dialog">>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Edit data</h4>
            </div>
            <div class="modal-body">
               <form id="submit-editData" method="post" name="myForm" >
                     <div class="form-group">
                        <label>Edit field</label>
                        <input type="text" class="form-control" name="new-category" id="new-data" placeholder="Enter field" value=""> 
                     </div>

                     <div class="form-group">
                        <label>Edit value</label>
                        <input type="text" class="form-control" name="new-category" id="new-value" placeholder="Enter value" value="{{value}}"> 
                     </div>

                     <p id="invalid"></p>
                     <button id="submit" class="btn btn-primary">Edit category</button>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</script>
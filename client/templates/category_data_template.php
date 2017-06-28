<script id="categories-data-template" type="text/x-handlebars-template">
   <div id="page-content">
      <button class="btn btn-primary" id="back">go back</button>
      <button class="btn btn-primary pull-right" id="add-data">Add data</button>
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
                        <button class="btn btn-success edit-data" name="{{this}}" id="{{@key}}">Edit</button>
                        <button class="btn btn-danger delete-data" id="{{@key}}">Delete</button>
                     </td>
                  </tr>
               {{/each}}
         </tbody>
      </table>
   </div>
</script>
<script id="categories-template" type="text/x-handlebars-template">
   <div id="categories">
      <h1>Categories</h1>
      <button class="btn btn-primary pull-right add-category" id="right-align" onclick="#">Add Categories</button>
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
                  <button class="btn btn-success edit-category" id="{{this}}">Edit</button>
               </td>
            </tr>
         {{/each}}
         </tbody>
      </table>
   </div>
</script>


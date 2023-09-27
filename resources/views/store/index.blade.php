<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
             <div class="card-header">
                <button class="btn btn-outline-primary" onclick="createStore()"> 
                    Add New Entry
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div"></div>
                <table class="table table-bordered" id="stores-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th width="240px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="stores-table-body">
                    </tbody>      
                </table>
            </div>
        </div>
    </div>

<!-- Store Form Modal (Create/Update) -->
<div class="modal" tabindex="-1" role="dialog" id="form-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Store Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="error-div"></div>
        <form>
            <input type="hidden" name="update_id" id="update_id">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="type"> Choose Type </label>
        <select class="form-control" name="type" id="type">
            <option value="seller">seller</option>
            <option value="buyer">buyer</option>
        </select>
            </div>
            <button type="button" class="btn btn-outline-primary mt-3" id="save-store-btn" onclick=savestore()>Save</button>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Show/View Modal -->
<div class="modal " tabindex="-1" role="dialog" id="view-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Store Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <b>Name:</b>
        <p id="name-info"></p>
        <b>Type:</b>
        <p id="type-info"></p>
      </div>
    </div>
  </div>
</div>


<!-- Confirmation Modal -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Confirm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body">
             Please Confirm to Delete?
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-si">Yes</button>
        <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>

<div class="alert" role="alert" id="result"></div>




@endsection
@push('scripts')
    
     <!-- Script -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
     <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

<script>

$(function() {
     
        jQuery.noConflict();
      //  var baseUrl = $('meta[name=app-url]').attr("content");
       // let url = '/store';

       
        // create a datatable
        $('#stores-table').DataTable({

            processing: true,

            ajax: '{{ route('stores.get') }}',

            "order": [[ 0, "desc" ]],

            columns: [
                { data: 'name'},
                { data: 'type'},
                { data: 'action'},
            ],

            dom: 'Blfrtip',
              buttons: [
                   {
                       extend: 'pdf',
                   },
                   {
                       extend: 'csv',
                   },
                   {
                       extend: 'excel',
                   }
              ],
              
        });
});
      
  
    function reloadTable()
    {
        jQuery.noConflict();
        /* reload the data on the datatable */
        $('#stores-table').DataTable().ajax.reload();
    }

   


    


    /* check if form submitted is for creating or updating*/
   function savestore(){

        //alert();
        jQuery.noConflict();
      //  event.preventDefault();
        if($("#update_id").val() == null || $("#update_id").val() == "")
        {
            // console.log("store");
            storeStore();
           
        } else {
            
             //console.log("update");
            updateStore();
            
        }
    }
/*show modal for creating a record and empty the values of form and remove existing alerts*/
    function createStore()
    {
        $("#alert-div").html("");
        $("#error-div").html("");
        $("#update_id").val("");
        $("#name").val("");
        $("#type").val("");
        $("#form-modal").modal('show'); 
    }
  
    /*submit the form and will be stored to the database*/
    function storeStore()
    {   
        $("#save-store-btn").prop('disabled', true);
        let url = "/store/create";
        let data = {
            name: $("#name").val(),
            type: $("#type").val(),
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                $("#save-store-btn").prop('disabled', false);
                let successHtml = '<div class="alert alert-success" role="alert"><b>Entry Created Successfully</b></div>';
                $("#alert-div").html(successHtml);
                $("#name").val("");
                $("#type").val("");
                reloadTable();
                $("#form-modal").modal('hide');
            },
            error: function(response) {
                $("#save-store-btn").prop('disabled', false);
                if (typeof response.responseJSON.errors !== 'undefined') 
                {
                    let errors = response.responseJSON.errors;
                    let descriptionValidation = "";
                    if (typeof errors.description !== 'undefined') 
                        {
                            descriptionValidation = '<li>' + errors.description[0] + '</li>';
                        }
                    let nameValidation = "";
                    if (typeof errors.name !== 'undefined') 
                        {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }
      
                    let errorHtml = '<div class="alert alert-danger" role="alert">' +
                        '<b>Validation Error!</b>' +
                        '<ul>' + nameValidation + descriptionValidation + '</ul>' +
                        '</div>';
                    $("#error-div").html(errorHtml);            
}
            }
        });
    }
  
  
    /*edit record function it will get the existing value and show the store form*/
    function editStore(id)
    {
        jQuery.noConflict();
        let url = "/store/json/" + id;
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                let store = response.data;
                $("#alert-div").html("");
                $("#error-div").html("");
                $("#update_id").val(store.id);
                $("#name").val(store.name);
                $("#type").val(store.type);
                $("#form-modal").modal('show'); 
            },
            
            error: function(response) {
                $("#save-store-btn").prop('disabled', false);
                if (typeof response.responseJSON.errors !== 'undefined') 
                {
    let errors = response.responseJSON.errors;
    let descriptionValidation = "";
    if (typeof errors.description !== 'undefined') 
                    {
                        descriptionValidation = '<li>' + errors.description[0] + '</li>';
                    }
                    let nameValidation = "";
    if (typeof errors.name !== 'undefined') 
                    {
                        nameValidation = '<li>' + errors.name[0] + '</li>';
                    }
      
    let errorHtml = '<div class="alert alert-danger" role="alert">' +
        '<b>Validation Error!</b>' +
        '<ul>' + nameValidation + descriptionValidation + '</ul>' +
    '</div>';
    $("#error-div").html(errorHtml);            
}
            }
        });
    }
  
    /* sumbit the form and will update a record */
    function updateStore()
    {
        $("#save-store-btn").prop('disabled', true);
        let url =  "/store/update/" + $("#update_id").val();
        let data = {
            id: $("#update_id").val(),
            name: $("#name").val(),
            type: $("#type").val(),
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "PUT",
            data: data,
            success: function(response) {
                console.log(response);
                $("#save-store-btn").prop('disabled', false);
                let successHtml = '<div class="alert alert-success" role="alert"><b>Entry Updated Successfully</b></div>';
                $("#alert-div").html(successHtml);
                $("#name").val("");
                $("#type").val("");
                reloadTable();
                $("#form-modal").modal('hide');
            },
            error: function(response) {
                $("#save-store-btn").prop('disabled', false);
                if (typeof response.responseJSON.errors !== 'undefined') 
                {
    let errors = response.responseJSON.errors;
    let descriptionValidation = "";
    if (typeof errors.description !== 'undefined') 
                    {
                        descriptionValidation = '<li>' + errors.description[0] + '</li>';
                    }
                    let nameValidation = "";
    if (typeof errors.name !== 'undefined') 
                    {
                        nameValidation = '<li>' + errors.name[0] + '</li>';
                    }
      
    let errorHtml = '<div class="alert alert-danger" role="alert">' +
        '<b>Validation Error!</b>' +
        '<ul>' + nameValidation + descriptionValidation + '</ul>' +
    '</div>';
    $("#error-div").html(errorHtml);            
}
            }
        });
    }
  
    /*get and display the record info on modal*/
    function showStore(id)
    {   jQuery.noConflict();
        $("#name-info").html("");
        $("#type-info").html("");
        let url = "/store/json/" + id +"";
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#name-info").html(data.name);
                $("#type-info").html(data.type);
                $("#view-modal").modal('show'); 
  
            },
            error: function(response) {
                console.log(response.responseJSON)
            }
        });
    }
  
    /*
        delete record function
    */

  

    function destroyStore(id)
    {
       jQuery.noConflict();
         
var modalConfirm = function(callback){
  $("#modal-btn-si").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-no").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};

$("#mi-modal").modal('show');
       modalConfirm(function(confirm){
  if(confirm){
    

        let url = "/store/delete/" + id;
        let data = {
            name: $("#name").val(),
            type: $("#type").val(),
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "delete",
            data: data,
            success: function(response) {
                let successHtml = '<div class="alert alert-success" role="alert"><b>Entry Deleted Successfully</b></div>';
                $("#alert-div").html(successHtml);
                reloadTable();
            },
             error: function(response) {
                $("#save-store-btn").prop('disabled', false);
                if (typeof response.responseJSON.errors !== 'undefined') 
                {
    let errors = response.responseJSON.errors;
    let descriptionValidation = "";
    if (typeof errors.description !== 'undefined') 
                    {
                        descriptionValidation = '<li>' + errors.description[0] + '</li>';
                    }
                    let nameValidation = "";
    if (typeof errors.name !== 'undefined') 
                    {
                        nameValidation = '<li>' + errors.name[0] + '</li>';
                    }
      
    let errorHtml = '<div class="alert alert-danger" role="alert">' +
        '<b>Validation Error!</b>' +
        '<ul>' + nameValidation + descriptionValidation + '</ul>' +
    '</div>';
    $("#error-div").html(errorHtml);            
}
            }


        });

       } });
    }




</script>
@endpush

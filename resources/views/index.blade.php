<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jean-Pearl - CRUD App Laravel 8 & Ajax</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

</head>
{{-- add new Perfume modal start --}}
<div class="modal fade" id="addPerfumeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Perfume</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_perfume_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="perfume_name">Name</label>
            <input type="text" name="perfume_name" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_flavor">Flavor</label>
            <input type="text" name="perfume_flavor" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_country">Country</label>
            <input type="text" name="perfume_country" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_price">Price</label>
            <input type="text" name="perfume_price" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_image">Select Image</label>
            <input type="file" name="perfume_image" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_perfume_btn" class="btn btn-primary">Add Perfume</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new Perfume modal end --}}

{{-- edit Perfume modal start --}}
<div class="modal fade" id="editPerfumeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Perfume</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_perfume_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="update_perfume_id" id="update_perfume_id">
        <input type="hidden" name="update_perfume_image" id="update_perfume_image">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="perfume_name">Name</label>
            <input type="text" name="perfume_name" id="perfume_name" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_flavor">Flavor</label>
            <input type="text" name="perfume_flavor" id="perfume_flavor" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_country">Country</label>
            <input type="text" name="perfume_country" id="perfume_country" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_price">Price</label>
            <input type="text" name="perfume_price" id="perfume_price" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="perfume_image">Select Image</label>
            <input type="file" name="perfume_image" class="form-control">
          </div>
          <div class="mt-2" id="perfume_image">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_perfume_btn" class="btn btn-success">Update Perfume</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit Perfume modal end --}}

<body class="bg-light">
  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Perfumes</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addPerfumeModal"><i
                class="bi-plus-circle me-2"></i>Add New Perfume</button>
          </div>
          <div class="card-body" id="show_all_perfumes">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {

      // add new Perfume ajax request
      $("#add_perfume_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_perfume_btn").text('Adding...');
        $.ajax({
          url: '{{ route('create') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Perfume Added Successfully!',
                'success'
              )
              fetchAllPerfumes();
            }
            $("#add_perfume_btn").text('Add Perfume');
            $("#add_perfume_form")[0].reset();
            $("#addPerfumeModal").modal('hide');
          }
        });
      });

      // edit Perfume ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('edit') }}',
          method: 'get',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#perfume_name").val(response.perfume_name);
            $("#perfume_flavor").val(response.perfume_flavor);
            $("#perfume_country").val(response.perfume_country);
            $("#perfume_price").val(response.perfume_price);
            $("#perfume_image").html(
              `<img src="files/public/images/${response.perfume_image}" width="100" class="img-fluid img-thumbnail">`);
            $("#update_perfume_id").val(response.id);
            $("#update_perfume_image").val(response.perfume_image);
          }
        });
      });

      // update Perfume ajax request
      $("#edit_perfume_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_perfume_btn").text('Updating...');
        $.ajax({
          url: '{{ route('update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Perfume Updated Successfully!',
                'success'
              )
              fetchAllPerfumes();
            }
            $("#edit_perfume_btn").text('Update Perfume');
            $("#edit_perfume_form")[0].reset();
            $("#editPerfumeModal").modal('hide');
          }
        });
      });

      // delete Perfume ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your Perfume has been deleted.',
                  'success'
                )
                fetchAllPerfumes();
              }
            });
          }
        })
      });

      // fetch all Perfumes ajax request
      fetchAllPerfumes();

      function fetchAllPerfumes() {
        $.ajax({
          url: '{{ route('read') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_perfumes").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
</body>

</html>
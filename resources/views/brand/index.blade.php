@extends('welcome')
@section('content')
  <div class="fw-bold text-center mt-3">Brand</div>
  <hr>
  <div class="row">
    <div class="col-md-4">
      <div class="errors"></div>
      <form id="brandForm" class="card p-3">
        @csrf
        <div class="mb-3">
          <label for="brandName" class="form-label">Brand Name</label>
          <input type="text" name="name" class="form-control id="brandName" aria-describedby="brandName" value="{{ old('name') }}">
          <div id="brandName" class="form-text">Shuld be valid name or minimum 4 character</div>
        </div>
        <div class="mb-3">
          <label for="brandDetails" class="form-label">Brand Details</label>
          <textarea name="details" id="brandDetails" cols="10" rows="5" class="form-control">{{ old('details') }}</textarea>
        </div>
        <button type="button" id="brandSubmit" class="btn btn-primary rounded-0">Submit</button>
      </form>
    </div>
    <div class="col-md-8">
      <div class="card p-3">
        <table class="table table-sm" id="brandTable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Brand Name</th>
              <th scope="col">Details</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($brands as $brand)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $brand->name }} <sup class="text-muted">({{ $brand->id }})</sup> </td>
                <td>{{ $brand->details }}</td>
                <td class="d-flex justify-content-center">
                  <button type="button" class="btn btn-success btn-sm rounded-0 brandEdit" data-bs-toggle="modal" data-bs-target="#updateBrandModal" data-id="{{ $brand->id }}">Edit</button>
                  <button class="btn btn-danger btn-sm rounded-0 brandDelete" data-id="{{ $brand->id }}">Delete</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{ $brands->links() }}
      </div>
    </div>
  </div>


 <!-- brand edit modal -->
<!-- Modal -->
<div class="modal fade" id="updateBrandModal" tabindex="-1" aria-labelledby="brandEditForm" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="brandEditForm">Brand Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" class="updateBrandForm">
          @csrf
          <div class="mb-3">
            <label for="brandName">Brand Name</label>
            <input type="text" name="editBrandName" id="brandName" class="form-control">
            <input type="hidden" name="editBrandId">
          </div>

          <div class="mb-3">
            <label for="brandDetails" class="form-label">Brand Details</label>
            <textarea name="editBrandDetails" id="brandDetails" cols="10" rows="5" class="form-control">{{ old('details') }}</textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary rounded-0" id="updateBrand">Update Brand</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
      $(document).ready(function () {


        // brand store ajax request
        $("#brandSubmit").on("click", function (e) {
          e.preventDefault();
          let data = $("#brandForm").serialize();
          console.log(data);
          $.ajax({
            type: "post",
            url: "{{ route('brands.store') }}",
            data: data,
            dataType: "json",
            success: function (response) {

              if(response.message){
                console.log(response.message);
                $(".table").load(location.href+' .table');
                $("#brandForm")[0].reset();
              }

              if(response.errors) {
                let err = response.errors;
                console.log(err);
                
                for (let index = 0; index < err.length; index++) {
                  $('.errors').append(
                    "<div class='text-danger text-center mb-2'>"+response.errors[index]+"</div>"
                  );
                }
              }
            }
          });
        });

        // brand edit ajax request
        $(".brandEdit").on("click", function () {
          var id = $(this).data('id');
          // console.log(itemId);
          $.ajax({
            type: "get",
            url: "{{ route('brands.edit') }}",
            dataType: "json",
            data: {
              'id' : id,
            },
            success: function (response) {
              console.log(response.data);
              $('input[name="editBrandId"]').val(response.data.id);
              $('input[name="editBrandName"]').val(response.data.name);
              $('textarea[name="editBrandDetails"]').val(response.data.details);
            }
          });
        });

        // update brand with ajax request
        $("#updateBrand").on("click", function () {
          var data = $(".updateBrandForm").serialize();
          console.log(data);
          $.ajax({
            type: "post",
            url: "{{ route('brands.update') }}",
            data: data,
            dataType: "json",
            success: function (response) {
              console.log(response);
              $(".table").load(location.href+' .table');
              $(".updateBrandForm")[0].reset();
              $("#updateBrandModal").modal('hide');
            }
          });
        });
        
        // delete brand with ajax request
        $(document).on("click", ".brandDelete", function () {
          var BrandId = $(this).data("id");
          console.log(BrandId);
          
              $.ajax({
              type: "get",
              url: "{{ route('brands.delete') }}",
              data: {
                'id' : BrandId,
              },
              dataType: "json",
              success: function (response) {
                console.log(response.status);
                $(".table").load(location.href+' .table');
              }
            });

        });


      });


    </script>
@endsection
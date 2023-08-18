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

$(document).ready(function() {
    init();
    
    function init() {
        $.ajax({
            url: "action.php",
            type: "GET",
            data: {
                action: "view"
            },
            success: function(response) {
                $("#tableData").html(response);
            }
        });
    }

    $(document).on('click', '.show-create-modal', function() {
        $('#modal-title').text('Create a new Address');
        $('#submit').text('Create');
        $('#address-id').val('');
        $("#formData")[0].reset();

        $('#addressModal').modal();
    })

    $("#submit").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();

            var method = $('#address-id').val() === '' ? 'POST' : 'PUT';

            $.ajax({
                url: "action.php",
                type: method,
                data: $("#formData").serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: method === 'POST' ? 'Address added successfully.' : 'Address updated successfully.',
                    });

                    $("#addressModal").modal('hide');
                    init();
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: error.responseJSON.message
                    });
                }
            });
        }
    });

    $(document).on("click", ".show-update-modal", function() {
        $('#modal-title').text('Update a existing Address');
        $('#submit').text('Update');
        $("#formData")[0].reset();

        var addressId = $(this).attr('id');

        $.ajax({
            url : "action.php",
            type : "get",
            data : {
                id: addressId,
                action: 'read'
            },
            success: function(response) {
                var data = JSON.parse(response);
                $("#address-id").val(data.id);
                $("#firstname").val(data.firstname);
                $("#lastname").val(data.lastname);
                $("#email").val(data.email);
                $("#city").val(data.city);
                $("#zip").val(data.zip);
                $("#phone").val(data.phone);

                $('#addressModal').modal();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: error.responseJSON.message
                });
            }
        });
    });

    $(document).on("click", ".delete", function() {
        var addressId = $(this).attr('id');

        $.ajax({
            url: "action.php",
            type: "DELETE",
            data: {
                id: addressId
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Address deleted successfully.',
                });

                init();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: error.responseJSON.message
                });
            }
        })
    });
});
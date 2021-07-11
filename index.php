<!DOCTYPE html>
<html lang="en">
<head>
    <title>Address Book</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>

<body>
    <div class="card text-center" style="padding:15px;">
        <h3>Address Book</h3>
    </div>
    
    <br><br> 

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary m-1 float-right show-create-modal">
                    <i class="fa fa-plus"></i> Add New Record
                </button>
            </div>
        </div>
        <br>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="table-responsive" id="tableData">
                    <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Create & Update Modal -->
    <div class="modal" id="addressModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="formData">
                        <input type="hidden" name="id" id="address-id">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="firstname">First Name:</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter first name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name:</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter last name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="city">City:</label>
                                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter city" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="zip">Zip:</label>
                                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Enter zip" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
                        </div>
                        
                        <hr>

                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-success" id="submit"></button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="/scripts/script.js"></script>
</body>
</html>
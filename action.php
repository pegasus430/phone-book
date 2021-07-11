<?php

	include_once('config.php');

	$db = new Database();

    // List ALL

    if (isset($_SERVER['REQUEST_METHOD'])) {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if(isset($_GET['action']) && $_GET['action'] == "view") {
                    $output = "";

                    $addresses = $db->list();
                    
                    if (count($addresses) > 0) {
                        $output .="<table class='table table-striped table-hover'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>Zip</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        foreach ($addresses as $address) {
                            $output.="<tr>
                                        <td>".$address['id']."</td>
                                        <td>".$address['firstname'].' '.$address['lastname']."</td>
                                        <td>".$address['email']."</td>
                                        <td>".$address['city']."</td>
                                        <td>".$address['zip']."</td>
                                        <td>".$address['phone']."</td>
                                        <td>
                                            <button type='button' class='btn btn-sm btn-info show-update-modal' id='".$address['id']."'>
                                                <i class='fa fa-pencil'></i>
                                            </button>
                                            <button type='button' class='btn btn-sm btn-danger delete' id='".$address['id']."'>
                                                <i class='fa fa-trash'></i>
                                            </button>
                                        </td>
                                    </tr>";
                        }
            
                        $output .= "</tbody>
                                      </table>";
                          echo $output;	
                    } else {
                        echo '<h3 class="text-center mt-5">No records found</h3>';
                    }
                }

                if (isset($_GET['action']) && $_GET['action'] == "read" && isset($_GET['id'])) {
                    $row = $db->get($_GET['id']);
                    echo json_encode($row);
                }
                break;
            case 'POST':
                $firstname = htmlspecialchars($_POST['firstname']);
                $lastname = htmlspecialchars($_POST['lastname']);
                $email = $_POST['email'];
                $city = htmlspecialchars($_POST['city']);
                $zip = htmlspecialchars($_POST['zip']);
                $phone = $_POST['phone'];

                if ($firstname && $lastname && $email && $city && $zip && $phone) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[0-9]{3}-[0-9]{2}-[0-9]{3}$/", $phone)) {
                        $db->insert($firstname, $lastname, $email, $city, $zip, $phone);
                    } else {
                        header('HTTP/1.1 400 BAD Request');
                        header('Content-Type: application/json; charset=UTF-8');
                        die(json_encode(array('message' => 'Email or Phone is not validated.')));
                    }
                } else {
                    header('HTTP/1.1 400 BAD Request');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'Please provide all fields.')));
                }
        
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $request_vars);
                $id = $request_vars['id'];
                $firstname = htmlspecialchars($request_vars['firstname']);
                $lastname = htmlspecialchars($request_vars['lastname']);
                $email = $request_vars['email'];
                $city = htmlspecialchars($request_vars['city']);
                $zip = htmlspecialchars($request_vars['zip']);
                $phone = $request_vars['phone'];
        
                if ($id && $firstname && $lastname && $email && $city && $zip && $phone) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[0-9]{3}-[0-9]{2}-[0-9]{3}$/", $phone)) {
                        $db->update($id, $firstname, $lastname, $email, $city, $zip, $phone);
                    } else {
                        header('HTTP/1.1 400 BAD Request');
                        header('Content-Type: application/json; charset=UTF-8');
                        die(json_encode(array('message' => 'Email or Phone is not validated.')));
                    }
                } else {
                    header('HTTP/1.1 400 BAD Request');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'Please provide all fields.')));
                }
                
                break;
            case 'DELETE':
                parse_str(file_get_contents("php://input"), $request_vars);
                $id = $request_vars['id'];
                if ($id) {
                    $db->delete($id);
                } else {
                    header('HTTP/1.1 400 BAD Request');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'You must provide Address ID.')));
                }

                break;
        }
    }

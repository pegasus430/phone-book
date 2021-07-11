<?php
	
	class Database 
	{
		private $server = "localhost";
		private $user   = "root";
		private $password   = "";
		private $db = "test";
		public $connection;
		public $table = "addresses";

		public function __construct()
		{
			try {
				$this->connection = new mysqli($this->server, $this->user, $this->password, $this->db);	
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		public function insert($firstname, $lastname, $email, $city, $zip, $phone)
		{
            $checkStmt = $this->connection->prepare("SELECT * FROM $this->table WHERE email = ? OR phone = ?");
            $checkStmt->bind_param("ss", $email, $phone);

            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                header('HTTP/1.1 409 Duplication DB Error');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'Email or Phone number is already existing.')));
			} else {
                $stmt = $this->connection->prepare("INSERT INTO $this->table (firstname, lastname, email, city, zip, phone) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $firstname, $lastname, $email, $city, $zip, $phone);

                $result = $stmt->execute();
                if ($result) {
                    return true;
                } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'Something went wrong.')));
                }
			}
		}

        public function update($id, $firstname, $lastname, $email, $city, $zip, $phone)
		{
            $checkStmt1 = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ?");
            $checkStmt1->bind_param("d", $id);

            $checkStmt1->execute();
            $checkResult1 = $checkStmt1->get_result();

            if ($checkResult1->num_rows > 0) {
                $checkStmt2 = $this->connection->prepare("SELECT * FROM $this->table WHERE (email = ? OR phone = ?) AND id != ?");
                $checkStmt2->bind_param("ssd", $email, $phone, $id);

                $checkStmt2->execute();
                $checkResult2 = $checkStmt2->get_result();
                
                if ($checkResult2->num_rows > 0) {
                    header('HTTP/1.1 409 Duplication DB Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'Email or Phone number is already existing.')));
                } else {
                    $stmt = $this->connection->prepare("UPDATE $this->table SET firstname = ?, lastname = ?, email = ?, city = ?, zip = ?, phone = ? WHERE id = ?");
                    $stmt->bind_param("ssssssd", $firstname, $lastname, $email, $city, $zip, $phone, $id);

                    $result = $stmt->execute();
                    if ($result) {
                        return true;
                    } else {
                        header('HTTP/1.1 500 Internal Server Error');
                        header('Content-Type: application/json; charset=UTF-8');
                        die(json_encode(array('message' => 'Something went wrong.')));
                    }
                }
            } else {
                header('HTTP/1.1 400 Bad Request');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'Address ID is not existing.')));
            }
		}

		public function list()
		{
            $query = "SELECT * FROM $this->table";

			$result = $this->connection->query($query);

			$data = array();
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
			}

            return $data;
		}

		public function get($id)
		{
            $stmt = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ?");
            $stmt->bind_param("s", $id);

			$stmt->execute();
            $result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
                $row['firstname'] = htmlspecialchars_decode($row['firstname']);
                $row['lastname'] = htmlspecialchars_decode($row['lastname']);
                $row['city'] = htmlspecialchars_decode($row['city']);
                $row['zip'] = htmlspecialchars_decode($row['zip']);
                
				return $row;
			} else {
				header('HTTP/1.1 400 Bad Request');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'Address ID is not existing.')));
			}
		}

        public function delete($id)
        {
            $checkStmt = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ?");
            $checkStmt->bind_param("d", $id);

            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $stmt = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
                $stmt->bind_param("d", $id);

                $result = $stmt->execute();
                if ($result) {
                    return true;
                } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'Something went wrong.')));
                }
            } else {
                header('HTTP/1.1 400 Bad Request');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'Address ID is not existing.')));
            }
        }
	}
<?php
class database {
	var $db;
	
	function __construct($db_host, $db_name, $db_username, $db_password) {
		// Attempt MySQL server connection
		$this->db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8mb4', $db_username, $db_password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	
	function insert_row($data, $table) {
		// Start building query
		$query = "INSERT INTO " . $table . " (";
		
		// Set counter
		$i = count($data);
		
		// Grab array keys, add keys to query
		foreach($data as $key => $value) {
			--$i;
			
			if(!$i) {
				$query .= $key . ") VALUES (";
			} else {
				$query .= $key . ", ";
			}
		}
		
		// Set counter
		$i = count($data);
		
		// Add prepared statements to query
		foreach($data as $key => $value) {
			--$i;
			
			if(!$i) {
				$query .= ":" . $key . ")";
			} else {
				$query .= ":" . $key . ", ";
			}
			
			$data[':' . $key] = $data[$key];
			unset($data[$key]);
		}
		
		// Prepare, then execute query
		$stmt = $this->db->prepare($query);
		$stmt->execute($data);
		
		// Close connection
		$stmt = null;
		$this->db = null;
	}
	
	function select_row($data, $table) {
		// Start building query
		$query = "SELECT * FROM " . $table . " WHERE ";
		
		// Set counter
		$i = count($data);
		
		// Add prepared statements to query
		foreach($data as $key => $value) {
			--$i;
			
			if(!$i) {
				$query .= $key . " = :" . $key;
			} else {
				$query .= $key . " = :" . $key . " AND ";
			}
		
			$data[':' . $key] = $data[$key];
			unset($data[$key]);
		}
		
		// Prepare, then execute query
		$stmt = $this->db->prepare($query);
		$stmt->execute($data);
		
		// Grab result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		// Close connection
		$stmt = null;
		$this->db = null;
		
		return $result;
	}
	
	function select_all($table) {
		// Execute query
		$stmt = $this->db->query("SELECT * FROM " . $table);
		
		// Grab result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		// Close connection
		$stmt = null;
		$this->db = null;
		
		return $result;
	}
	
	function update_row($set, $where, $table) {
		// Start building query
		$query = "UPDATE " . $table . " SET ";
		
		// Set counter
		$i = count($set);
		
		// Add prepared statements to query
		foreach($set as $key => $value) {
			--$i;
			
			if(!$i) {
				$query .= $key . " = :" . $key . " WHERE ";
			} else {
				$query .= $key . " = :" . $key . ", ";
			}
			
			$set[':' . $key] = $set[$key];
			unset($set[$key]);
		}
		
		// Set counter
		$i = count($where);
		
		// Add prepared statements to query
		foreach($where as $key => $value) {
			--$i;
			
			if(!$i) {
				$query .= $key . " = :" . $key;
			} else {
				$query .= $key . " = :" . $key . " AND ";
			}
			
			$where[':' . $key] = $where[$key];
			unset($where[$key]);
		}
		
		// Merge the two arrays
		$data = array_merge($set, $where);
		
		// Prepare, then execute query
		$stmt = $this->db->prepare($query);
		$stmt->execute($data);
		
		// Close connection
		$stmt = null;
		$this->db = null;
	}
	
	function delete_row($data, $table) {
		// Start building query
		$query = "DELETE FROM " . $table . " WHERE ";
		
		// Set counter
		$i = count($data);
		
		// Add prepared statements to query
		foreach($data as $key => $value) {
			--$i;
			
			if(!$i) {
				$query .= $key . " = :" . $key;
			} else {
				$query .= $key . " = :" . $key . " AND ";
			}
		
			$data[':' . $key] = $data[$key];
			unset($data[$key]);
		}
		
		// Prepare, then execute query
		$stmt = $this->db->prepare($query);
		$stmt->execute($data);
		
		// Close connection
		$stmt = null;
		$this->db = null;
	}
}
?>
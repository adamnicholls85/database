<?php
class database {
	var $db;
	
	function __construct($db_host, $db_name, $db_username, $db_password) {
		// Attempt MySQL server connection
		$this->db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8mb4', $db_username, $db_password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	
	function insert_row($table, $data) {
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
	
	function select_row($table, $data) {
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
	
	function select_all($table, $data = NULL) {
		// Start building query
		$query = "SELECT * FROM " . $table;
		
		// Check for order, add prepared statements to query, if necessary
		if($data['order_by'] && $data['order']) {
			$query .= " ORDER BY " . $data['order_by'] . " " . $data['order'];
			
			unset($data['order_by']);
			unset($data['order']);
		}
		
		// Check for limits, add prepared statements to query, if necessary
		if(!is_null($data['limit_one']) && !is_null($data['limit_two'])) {
			$query .= " LIMIT :limit_one, :limit_two";
			
			$data[':limit_one'] = $data['limit_one'];
			$data[':limit_two'] = $data['limit_two'];
			unset($data['limit_one']);
			unset($data['limit_two']);
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
	
	function update_row($table, $set, $where) {
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
	
	function delete_row($table, $data) {
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
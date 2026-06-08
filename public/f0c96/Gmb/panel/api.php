<?php

    class con extends SQLite3 {

        function __construct() {
            $dbPath = dirname(__DIR__,1) . '/panel/database.db';
            if (!file_exists($dbPath)) {
                die("Database file not found: " . $dbPath);
            }
            $this->open($dbPath);
        }

        function command($cmd) {
            $result = $this->query($cmd);
            if (!$result) {
                die("SQL Error: " . $this->lastErrorMsg());
            }
            return $result;
        }

        function MyData($data) {
            $my_array = [];
            while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
                $my_array[] = $row;
            }
            return $my_array;
        }
    }

    $connexion = new con();

    function insert_data($table,$data = array()) {
        GLOBAL $connexion;
        if( empty($table) )
            return false;
        if( !is_array($data) )
            return false;
        $columns = implode(", ",array_keys($data));
        $values  = implode("', '", array_values($data));
        $sql = "insert into $table ($columns) values ('$values')";
        $connexion->command($sql);
    }

    function update_data($table,$data = array(),$condition) {
        GLOBAL $connexion;
        if( empty($table) )
            return false;
        if( !is_array($data) )
            return false;

        $updateSql = "UPDATE $table SET ";
        $params = [];
        foreach ($data as $key => $value) {
            if(is_numeric($value)) {
                $updateSql .= "$key = $value, ";
            } else {
                $updateSql .= "$key = '$value', ";
            }
        }
        $updateSql = rtrim($updateSql, ", "); // Remove the trailing comma
        $updateSql .= " WHERE ";
        foreach ($condition as $key => $value) {
            if(is_numeric($value)) {
                $updateSql .= "$key = $value AND ";
            } else {
                $updateSql .= "$key = '$value' AND ";
            }
        }
        $updateSql = rtrim($updateSql, "AND "); // Remove the trailing "AND"
        $connexion->command($updateSql);
    }

    function delete_data($table,$data = array()) {
        GLOBAL $connexion;
        if( empty($table) )
            return false;
        if( !is_array($data) )
            return false;
        $sql = "DELETE FROM $table ";
        $where = $data[array_key_first($data)];
        foreach($data as $key => $value) {
            if(is_numeric($value)) {
                $sql .= " WHERE " . $key . " = " . $value;
            } else {
                $sql .= " WHERE " . $key . " = '" . $value . "'";
            }
        }
        $connexion->command($sql);
    }

    function get_data($table,$data = null) {
        GLOBAL $connexion;
        if( empty($table) )
            return false;
        $sql = "SELECT * FROM $table ";
        if (!empty($data)) {
            $conditions = [];
            foreach ($data as $key => $value) {
                if(is_numeric($value)) {
                    $conditions[] = "$key = $value";
                } else {
                    $conditions[] = "$key = '$value'";
                }
            }
            $sql .= " WHERE " . implode(" AND ", $conditions);
            $sql .= " ORDER BY id DESC";
        }

        $query = $connexion->command($sql);
        $results = $connexion->MyData($query);
        return $results;
    }

    function action($jsonData) {

        $jsonData = json_decode($jsonData, true);

        if ($jsonData === null) {
            echo "Invalid JSON data";
            exit;
        }

        if ($jsonData['action'] !== 'GET' && $jsonData['action'] !== 'INSERT' && $jsonData['action'] !== 'VISITORS' && $jsonData['action'] !== 'UPDATE' && $jsonData['action'] !== 'RESETGOTO' && $jsonData['action'] !== 'CHECKGOTO') {
            echo "Invalid Action";
            exit;
        }

        $action = $jsonData['action'];

        // ACTION : INSERT
        if( $action == 'INSERT' ) {
            $insert = insert_data('data',[
                'ip' => $jsonData['ip'],
                'created_at' => date('Y-m-d h:i:s'),
                'results' => json_encode($jsonData['results']),
            ]);
        }

        // ACTION : UPDATE
        if( $action == 'UPDATE' ) {
            $get = get_data('data',['ip' => $jsonData['ip']]);
            $dd = $get[0];
            $old = json_decode($dd['results'],true);
            $new = array_merge($old,$jsonData['results']);        
            $data = [
                'results' => json_encode($new),
            ];
            $conditions = [
                'id' => $dd['id'],
            ];
            $update = update_data('data',$data,$conditions);
        }

        // ACTION : GET
        if( $action == 'GET' ) {
            $check = get_data('data',['ip' => $jsonData['ip']]);
            if( count($check) == 0 ) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Invalid Data']);
                exit;
            } else {
                return $check[0]["data"];
            }
        }

        // ACTION : VISITORS
        if( $action == 'VISITORS' ) {
            $check = get_data('visitors',['ip' => $jsonData['ip']]);
            if( count($check) == 0 ) {
                $insert = insert_data('visitors',[
                    'ip' => $jsonData['ip'],
                    'page' => $jsonData['page'],
                    'last_activity' => time(),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            } else {
                $update = update_data('visitors',['page' => $jsonData['page'],'last_activity' => time(),'updated_at' => date('Y-m-d h:i:s')],['ip' => $jsonData['ip']]);
            }
        }

        // ACTION : RESETGOTO
        if( $action == 'RESETGOTO' ) {
            $check = get_data('data',['ip' => $jsonData['ip']]);
            if( count($check) > 0 ) {
                $update = update_data('data',['goto' => 0],['ip' => $jsonData['ip']]);
            }
        }

        // ACTION : CHECKGOTO
        if( $action == 'CHECKGOTO' ) {
            $check = get_data('data',['ip' => $jsonData['ip']]);
            if( count($check) > 0 ) {
                return $check[0]["goto"];
            }
        }

    }


?>
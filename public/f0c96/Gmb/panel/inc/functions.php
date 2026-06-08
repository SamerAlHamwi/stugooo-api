<?php

function insert_data($table,$data = array()) {
    GLOBAL $connexion;
    if( empty($table) )
        return false;
    if( !is_array($data) )
        return false;
    $columns = implode(", ",array_keys($data));
    $values  = implode("', '", array_values($data));
    $sql = "insert into $table ($columns) values ('$values')";
    $connexion->command($connexion,$sql);
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
    $connexion->command($connexion,$updateSql);
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
    $connexion->command($connexion,$sql);
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

    $query = $connexion->command($connexion,$sql);
    $results = $connexion->MyData($query);
    return $results;
}

function insert_user($username,$password,$role = 2) {
    GLOBAL $connexion;

    if( empty($username) || empty($password) )
        return false;

    $check = get_data('users',['username' => $username]);
    if( count($check) > 0 )
        return false;

    $data = [
        "username"    => $username,
        "password"    => password_hash($password, PASSWORD_DEFAULT),
        "role"    => $role,
        "created_at" => date('Y-m-d h:i:s'),
    ];
    $add = insert_data('users',$data);
    return true;
}







function visitor_status($ip) {
    GLOBAL $connexion;
    $period      = 12;
    $curtime     = time();
    $visitor     = get_data('visitors',['ip' => $ip]);
    $victim_time = $visitor['last_activity'] + $period;
    if( $victim_time > time() ) {
        return "online";
    } else {
        return "offline";
    }
}

function dump($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}


function is_logged() {
    if (!isset($_SESSION['loggedin']))
        return false;
    return true;
}

function is_superadmin() {
    if( is_logged() && $_SESSION['role'] == 1 )
        return true;
    return false;
}


?>
<?php

class Harviacode
{

    private $host;
    private $user;
    private $password;
    private $database;
    private $sql;

    function __construct()
    {
        $this->connection();
    }

    function connection()
    {
        $db = file_get_contents('../application/config/database.php');
        $db = explode("\$db['default'] = array(", $db);
        $db = explode(");", $db[1]);
        $db = explode(',', $db[0]);

        for ($i = 0; $i < count($db); $i++) {
            $host = explode(' => ', $db[$i]);
            $data[] = trim($host[1], "'");
        }

        $this->host = $data[1];
        $this->user = $data[2];
        $this->password = $data[3];
        $this->database = $data[4];

        $this->sql = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->sql->connect_error) {
            echo $this->sql->connect_error . ", please check 'application/config/database.php'.";
            die();
        }
    }

    function table_list()
    {
        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=?";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('s', $this->database);
        $stmt->bind_result($table_name);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[] = array('table_name' => $table_name);
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    function primary_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_KEY = 'PRI'";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key);
        $stmt->execute();
        $stmt->fetch();
        return $column_name;
        $stmt->close();
        $this->sql->close();
    }

    function not_primary_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE,COLUMN_COMMENT,IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_KEY <> 'PRI'";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key, $data_type,$column_comment,$is_nullable);
        $stmt->execute();
        while ($stmt->fetch()) {
            if ($column_name =='created_at' or 
                $column_name =='updated_at' or 
                $column_name =='deleted_at' or 
                $column_name =='created_by' or 
                $column_name =='updated_by'
                ) {
                continue;
            }
            $get_arr = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type,'is_nullable'=>$is_nullable);
            $get_arr['f_name'] = $column_name;
            $get_arr['validation'] = "";
            if (!empty($column_comment)) {
                $j = json_decode($column_comment);
                if($j){
                    if (isset($j->n)) {
                        $get_arr['f_name'] = $j->n;
                    }
                    if (isset($j->v)) {
                        $get_arr['validation'] = $j->v;
                    }
                }
            }
            $fields[] = $get_arr;
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    function all_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=?";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key, $data_type,$column_comment);
        $stmt->execute();
        while ($stmt->fetch()) {
            if ($column_name =='created_at' or 
                $column_name =='updated_at' or 
                $column_name =='deleted_at' or 
                $column_name =='created_by' or 
                $column_name =='updated_by'
                ) {
                continue;
            }
            $get_arr = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
            $get_arr['f_name'] = $column_name;
            if (!empty($column_comment)) {
                $j = json_decode($column_comment);
                if($j){
                    if (isset($j->n)) {
                        $get_arr['f_name'] = $j->n;
                    }
                }
            }
            $fields[] = $get_arr;
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    public function table_process($stmt)
    {
        # code...
    }

    function reference_field($table)
    {
        $query = "  SELECT column_name,referenced_table_name,referenced_column_name 
                    FROM
                        information_schema.key_column_usage
                    WHERE
                        referenced_table_name is not null
                        and table_schema = ? 
                        and table_name = ?";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $referenced_table_name, $referenced_column_name);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[$column_name] = array(
                'column_name' => $column_name, 
                'r_table' => $referenced_table_name, 
                'r_column' => $referenced_column_name,
                'r_model' => ucfirst($referenced_table_name).'_model'
            );
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    public function with_reference($all,$reference)
    {
        foreach ($all as $key => $row) {

            $all[$key]['r_table']=false;
            $all[$key]['r_column']=false;
            $all[$key]['r_model']=false;
            $all[$key]['r_label']=false;
            $all[$key]['img']=false;

            if(array_key_exists($row["column_name"], $reference) ) {
                $all[$key]['r_table']=$reference[$row["column_name"]]["r_table"];
                $all[$key]['r_column']=$reference[$row["column_name"]]["r_column"];
                $all[$key]['r_model']=$reference[$row["column_name"]]["r_model"];
                $all[$key]['r_label']='$this->'.$reference[$row["column_name"]]["r_model"].'->label';
                
            }elseif (strpos($row['column_name'], '_img') !== false) {
                $all[$key]['img']=true;
            }elseif (strpos($row['column_name'], '_file') !== false) {
                $all[$key]['file']=true;
            }
        }
        return $all;
    }

}

$hc = new Harviacode();
?>
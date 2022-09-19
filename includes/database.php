<?php
if (!defined('_INCODE')) die('Access Deined....');

function query($sql, $data = [], $statementStatus = false)
{

    global $conn;

    $query = false;

    try {

        $statement = $conn->prepare($sql);

        if (empty($data)) {

            $query = $statement->execute();
        } else {

            $query = $statement->execute($data);
        }
    } catch (Exception $exception) {
        require_once 'modules/error/database.php';
        die();
    }

    if ($statementStatus && $query) {
        return $statement;
    }

    return $query;
}


//  viết hàm thêm dữ liệu vào table 

function insert($table, $dataInsert)
{
    // lấy key của mảng 
    $keyArr = array_keys($dataInsert);

    // chuyển key của datainsert thành chuỗi 
    $fiedl_Str = implode(',', $keyArr);

    // gán giá trị đứg sau values thành chuỗi 
    $valuesStr = ':' . implode(', :', $keyArr);

    $sql = 'INSERT INTO ' . $table . '(' . $fiedl_Str . ') VALUES(' . $valuesStr . ')';

    return query($sql, $dataInsert);
}


//viết hàm sửa data (update )


function updateData($table, $update_data, $condition = '')
{

    $updateStr = '';

    foreach ($update_data as $key => $value) {

        $updateStr .= $key . '=:' . $key . ', ';
    }

    $updateStr = rtrim($updateStr, ', '); //loại bỏ dấy phẩy cuỗi chuỗi trên 

    if (!empty($condition)) {
        $sql = 'UPDATE ' . $table . ' SET ' . $updateStr . ' WHERE ' . $condition;
    } else {
        $sql = 'UPDATE' . $table . ' SET ' . $updateStr;
    }

    return query($sql, $update_data);
}



// viết hàm xoá dữ liệu trong mysql 

//muốn thực hiện lệnh xoá data cần phải bỏ bỏ $data ở trong execute ở dòng 20 đi thì mới chạy đc 

function delete($table, $condition_delete = '')
{
    $sql = 'DELETE FROM ' . $table;
    if (!empty($condition_delete)) {
        $sql = "DELETE FROM $table WHERE $condition_delete";
    } else {
        $sql = "DELETE FROM $table";
    }

    return query($sql);
}

// lấy dữ liệu từ câu lệnh sql - lấy tất cả 
function getRaw($sql)
{
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $dataFetch;
    }
    return false;
}


// lấy dữ liệu từ câu lệnh sql - 1 bản ghi đầu
function firstRaw($sql)
{
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        $dataFetch = $statement->fetch(PDO::FETCH_ASSOC);
        return $dataFetch;
    }
    return false;
}

// lấy dữ liệu theo table, feild, condition
function get($table, $field = '*', $condition = '')
{
    $sql = "SELECT $field FROM $table";
    if ($condition) {
        $sql .= " WHERE $condition";
    }
    return getRaw($sql);
}

function fisrt($table, $field = '*', $condition = '')
{
    $sql = 'SELECT ' . $field . ' FROM ' . $table;
    if ($condition) {
        $sql .= ' WHERE ' . $condition;
    }
    return firstRaw($sql);
}

// lấy ra số dòng bản ghi sql
function getRows($sql)
{
    $statement = query($sql, [], true);
    if (!empty($statement)) {
        return $statement->rowCount();
    }
}
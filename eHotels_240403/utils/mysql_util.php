<?php

$conn;
function openDBConnection(){

    global $conn;
    $conn = mysqli_connect("localhost", "csi2132", "csi2132", "eHotels");
    if (!$conn) {
        // echo "Connection error: " . mysqli_connect_error();
        // exit(1);
    } else {
        // echo "Connection to db successful. <br>";
        return true;
    }

    return false;
}

function runSQLQueryAndReturnRows($query){
    global $conn;
    $result = mysqli_query($conn, $query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function runSQLUpdate($query){
    global $conn;
    mysqli_query($conn, $query);

    if(mysqli_affected_rows($conn) > 0){
        return true;
    }else{
        return false;
    }
}

function closeDBConnection(){

    global $conn;
    if ($conn) {
        mysqli_close($conn);
        return true;
    }

    return false;
}
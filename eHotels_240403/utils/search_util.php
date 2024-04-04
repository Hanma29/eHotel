<!-- A general module that can be used for searching anything based on its unique ID in the db and returning the results -->
<?php

$unique_id = "test";
$unique_col_name;
$table_name;


$query_result;

$result_data;

function setupSearchUtil($id, $col_name, $table){
    global $unique_id, $unique_col_name, $table_name;
    
    $unique_id = $id;
    $unique_col_name = $col_name;
    $table_name = $table;
}

if(isset($_POST["search"])){

    global $unique_id, $unique_col_name, $table_name;

    echo $unique_id;
    
    // if(openDBConnection()){
    
    //     global $result_data;
    
    //     $result_data = runSQLQueryAndReturnRows("SELECT * from '$table_name' WHERE '$unique_col_name'='$unique_id';")[0];
    // }
}

?>


<div class="py-8 px-8">

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w-1/2">
        <label class="input input-bordered flex items-center gap-2">
            
            <input type="text" class="grow" placeholder="Search" />

            <?php 
                $set_data = [''];
            ?>
            
            <input type="hidden" name="sent_data" value="<?php print_r($sent_data)?> ">
            
            <button name="search" value="confirm" class="btn btn-xs">Search</button>

        </label>
    </form>

</div>
<?php require ("./components/header.php"); ?>

<?php

$all_hotels;

if(openDBConnection()){
    
    global $all_hotels;
    $all_hotels = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`h_name` FROM `hotels`;");

    closeDBConnection();
}

if (isset($_POST['submit'])) {

    $hotel_id = $_POST['hotel_id'];
    $employ_name = $_POST['employ_fname'];
    $employ_addressline1 = $_POST['employ_addressline1'];
    $employ_addressline2 = $_POST['employ_addressline2'];
    $employ_idtype = $_POST['employ_idtype'];
    $employ_position_name = $_POST['employ_position_name'];

    // $employ_idnumber = $_POST['employ_idnumber'];

    $query = "INSERT INTO employees(hotel_id, employ_fname, employ_addressline1, employ_addressline2, id_type, position_name) VALUES ('$hotel_id', '$employ_name', '$employ_addressline1', '$employ_addressline2', '$employ_idtype', '$employ_position_name');";

    echo $query;

    if (openDBConnection()) {

        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully created employee: '.$employ_name);

            // header("Location: create_customer.php");

            // echo $query;
            // echo "Query successful.";
        } else {
            logErrorToDisplay("Unsuccessfully run.");
        }

        closeDBConnection();
    }

}

?>

<div>

    <?php include("./utils/alert_util.php") ?>

    <h1 class="text-xl">Create a New Employee</h1>

    <form method="POST" action="create_employee.php" class="flex flex-col w-1/2 flex-wrap space-y-4 px-4 my-8">

        <label class="input input-bordered flex items-center gap-2">
            Name
            <input name="employ_fname" type="text" class="grow" placeholder="Employee Name" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 1
            <input name="employ_addressline1" type="text" class="grow"
                placeholder="Address Line 1 (House No., PO Box.)" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 2
            <input name="employ_addressline2" type="text" class="grow" placeholder="" />
            <span class="badge badge-info">Optional</span>
        </label>

        <select name="hotel_id" value="" class="select select-bordered w-full max-w-xs">
               
        <option disabled selected>Hotel Name</option>

                <?php foreach($all_hotels as $hotel_row): ?>
                    <option value="<?php echo $hotel_row['hotel_id'] ?>"><?php echo htmlspecialchars($hotel_row['hotel_id'].' - '.$hotel_row['h_name']) ?></option>
                <?php endforeach; ?>

            </select>

        <label class="input input-bordered flex items-center gap-2">
            Employee Position
            <input name="employ_position_name" type="text" class="grow" placeholder="" />
        </label>

        <div>
            <h4>ID Type:</h4>

            <div class="form-control flex">
                <label class="label cursor-pointer">
                    <span class="label-text">SIN</span>
                    <input value="SIN" type="radio" name="employ_idtype" class="radio checked:bg-red-500" checked />
                </label>

                <label class="label cursor-pointer">
                    <span class="label-text">Driver's Licence</span>
                    <input value="License" type="radio" name="employ_idtype" class="radio checked:bg-red-500" />
                </label>

                <label class="label cursor-pointer">
                    <span class="label-text">Passport</span>
                    <input value="Passport" type="radio" name="radio-10" class="radio checked:bg-red-500" />
                </label>
            </div>

            <label class="input input-bordered flex items-center gap-2">
                ID Number:
                <input name="employ_idnumber" type="text" class="grow" placeholder="ID Number" />
            </label>
        </div>


        <button name="submit" class="btn btn-primary">Create Employee</button>

    </form>
</div>

<?php require ("./components/footer.php"); ?>
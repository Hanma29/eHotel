<?php require ("./components/header.php"); ?>

<?php

$all_chains;
$all_employees;

if(openDBConnection()){
    
    global $all_chains;
    $all_chains = runSQLQueryAndReturnRows("SELECT DISTINCT `chain_id`,`chain_name` FROM `hotel_chain`;");

    global $all_employees;
    $all_employees = runSQLQueryAndReturnRows("SELECT DISTINCT `employ_id`,`employ_fname` FROM `employees`;");

    closeDBConnection();
}

if (isset($_POST['submit'])) {

    $chain_id = $_POST['chain_id'];
    $hotel_name = $_POST['h_name'];
    $hotel_addressline1 = $_POST['hotel_addressline1'];
    $hotel_addressline2 = $_POST['hotel_addressline2'];
    $hotel_email = $_POST['hotel_email'];
    $hotel_totalRooms = $_POST['hotel_totalRooms'];
    $hotel_score = $_POST['hotel_score'];
    $hotel_manager_id = $_POST['manager_id'];

    // $chain_idnumber = $_POST['chain_idnumber'];

    $query = "INSERT INTO hotels(chain_id, h_name, hotel_addressline1, hotel_addressline2, hotel_email, totalRooms, hotel_score, manager_id) VALUES ('$chain_id', '$hotel_name', '$hotel_addressline1', '$hotel_addressline2', '$hotel_email', '$hotel_totalRooms', '$hotel_score', '$hotel_manager_id');";

    // echo $query;

    if (openDBConnection()) {

        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully created hotel: ' . $hotel_name);
            // header("Location: create_chain.php");

        } else {

            logErrorToDisplay("Unsuccessful query execution, hotel create.");
            // echo "Unsuccessful query execution.";
        }

        closeDBConnection();
    }

}

?>

<div>

    <?php include ("./utils/alert_util.php") ?>

    <h1 class="text-xl">Create a New Hotel</h1>

    <form method="POST" action="create_hotel.php" class="flex flex-col flex-wrap space-y-4 px-4 my-8">

        <select name="chain_id" value="" class="select select-bordered w-full max-w-xs">

            <option disabled selected>ChainID - Chain Name</option>

            <?php foreach ($all_chains as $chain_row): ?>
                <option value="<?php echo $chain_row['chain_id'] ?>">
                    <?php echo htmlspecialchars($chain_row['chain_id'] . ' - ' . $chain_row['chain_name']) ?>
                </option>
            <?php endforeach; ?>

        </select>

        <label class="input input-bordered flex items-center gap-2">
            Hotel Name
            <input name="h_name" type="text" class="grow" placeholder="Hotel Name" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 1
            <input name="hotel_addressline1" type="text" class="grow"
                placeholder="Address Line 1 (House No., PO Box.)" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 2
            <input name="hotel_addressline2" type="text" class="grow" placeholder="" />
            <span class="badge badge-info">Optional</span>
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Hotel Email
            <input name="hotel_email" type="text" class="grow" placeholder="Hotel Email" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Total Rooms
            <input name="hotel_totalRooms" type="text" class="grow" placeholder="Total Rooms (number)" />
        </label>

        <h3>Hotel Rating:</h3>
        <input name="hotel_score" type="range" min="1" max="5" class="range" step="1" />
        <div class="w-full flex justify-between text-xs px-2">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
        </div>

        <h3>Manager's ID:</h3>
        <select name="manager_id" value="" class="select select-bordered w-full max-w-xs">
               
            <option disabled selected>EmployeeID - Employee Name</option>

            <?php foreach($all_employees as $employ_row): ?>
                <option value="<?php echo $employ_row['employ_id'] ?>"><?php echo htmlspecialchars($employ_row['employ_id'].' - '.$employ_row['employ_fname']) ?></option>
            <?php endforeach; ?>

        </select>

        <button name="submit" class="btn btn-primary">Create Hotel</button>

    </form>
</div>

<?php require ("./components/footer.php"); ?>
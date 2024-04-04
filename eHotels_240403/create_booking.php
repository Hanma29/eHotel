<?php require ("./components/header.php"); ?>

<?php

$all_hotels;
$all_rooms;
$all_customers;
$all_employees;

if (openDBConnection()) {

    global $all_hotels;
    $all_hotels = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`h_name`, `hotel_addressline1`, `hotel_addressline2` FROM `hotels`;");

    global $all_rooms;
    $all_rooms = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`room_id` FROM `rooms`;");

    global $all_customers;
    $all_customers = runSQLQueryAndReturnRows("SELECT DISTINCT `cust_id`,`cust_fname`FROM `customers`;");

    global $all_employees;
    $all_employees = runSQLQueryAndReturnRows("SELECT DISTINCT `employ_id`,`employ_fname` FROM `employees`;");

    closeDBConnection();
}

if (isset($_POST['submit'])) {

    $hotel_id = $_POST['hotel_id'];
    $room_id = $_POST['room_id'];
    $cust_id = $_POST['cust_id'];
    $employ_id = $_POST['employ_id'];
    $from_date = strtotime($_POST['from_date']);
    $to_date = strtotime($_POST['to_date']);

    $paid;
    if (isset($_POST['paid']) && $_POST['paid'] == 'on') {
        $paid = 1;
    } else {
        $paid = 0;
    }

    $duration = $to_date - $from_date;

    // $chain_idnumber = $_POST['chain_idnumber'];

    $query = "INSERT INTO renting(hotel_id,room_id, cust_id, employ_id, fromDate, toDate, duration, paid) VALUES ('$hotel_id', '$room_id', '$cust_id', '$employ_id', '$from_date', '$to_date', '$duration', '$paid');";

    // echo $query;

    if (openDBConnection()) {

        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully created booking.');
            // header("Location: create_chain.php");

        } else {

            logErrorToDisplay("Unsuccessful query execution, Room create.");
            // echo "Unsuccessful query execution.";
        }

        closeDBConnection();
    }

}

?>

<div class="w-3/4 border-gray-300">

    <?php include ("./utils/alert_util.php") ?>

    <form method="POST" action="create_booking.php" class="flex flex-wrap space-y-4 px-4 my-8">
    <h1 class="text-xl">Create a New Booking</h1>
        <div class="flex space-x-12 w-full">
            <select name="hotel_id" value="" class="select select-bordered w-1/2 max-w-xs">

                <option disabled selected>HotelID - Hotel Name</option>

                <?php foreach ($all_hotels as $hotel_row): ?>
                    <option value="<?php echo $hotel_row['hotel_id'] ?>">
                        <?php echo htmlspecialchars('Hotel ID#' . $hotel_row['hotel_id'] . ' - ' . $hotel_row['h_name']) ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <select name="room_id" value="" class="select select-bordered w-1/2 max-w-xs">

                <option disabled selected>HotelID - Hotel Name - Room ID</option>

                <?php foreach ($all_rooms as $room_row): ?>
                    <option value="<?php echo $room_row['room_id'] ?>">

                        <?php

                        $room_id = $room_row['room_id'];
                        $hotel_id = $room_row['hotel_id'];

                        $hotel_name_row;

                        openDBConnection();
                        $hotel_name_row = runSQLQueryAndReturnRows("SELECT `h_name` FROM hotels WHERE `hotel_id`=$hotel_id;");
                        closeDBConnection();

                        echo htmlspecialchars('Hotel #' . $hotel_id . ' - ' . $hotel_name_row[0]['h_name'] . ' - Room #' . $room_id) ?>

                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="flex space-x-12 w-full">
            <select name="cust_id" value="" class="select select-bordered w-full max-w-xs">

                <option disabled selected>CustID - Cust Name</option>

                <?php foreach ($all_customers as $cust_row): ?>
                    <option value="<?php echo $cust_row['cust_id'] ?>">
                        <?php echo htmlspecialchars($cust_row['cust_id'] . ' - ' . $cust_row['cust_fname']) ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <select name="employ_id" value="" class="select select-bordered w-full max-w-xs">

                <option disabled selected>EmployID - Employ Name</option>

                <?php foreach ($all_employees as $employ_row): ?>
                    <option value="<?php echo $employ_row['employ_id'] ?>">
                        <?php echo htmlspecialchars($employ_row['employ_id'] . ' - ' . $employ_row['employ_fname']) ?>
                    </option>
                <?php endforeach; ?>

            </select>

        </div>

        <div date-rangepicker class="flex items-center w-full">
        <span class="mx-4 text-gray-500">From</span>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input name="from_date" type="text" value="<?php echo $start ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Select date start">
            </div>
            <span class="mx-4 text-gray-500">to</span>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input name="to_date" type="text" value="<?php echo $end ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Select date end">
            </div>
        </div>

        <div class="flex space-x-12">
            <div class="flex flex-co w-full">
                <div class="form-control w-52">
                    <label class="cursor-pointer label">
                        <span class="label-text">Transfer to renting immediately?</span>

                        <input name="paid" value="" type="checkbox" class="toggle toggle-primary" />
                    </label>
                </div>
            </div>

            <button name="submit" class="btn btn-primary">Create Booking</button>
        </div>

    </form>
</div>

<?php require ("./components/footer.php"); ?>
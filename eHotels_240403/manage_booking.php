<?php

require ("./components/header.php");
require ("./utils/reverse_print_r.php");

$id;
$col_name = 'rent_id';
$table = 'renting';

$result_data;
$rent_row;

$all_hotels;
$all_customers;
$all_employees;
$all_rooms;

if (openDBConnection()) {

    global $all_hotels, $all_rooms, $all_customers, $all_employees;

    $all_hotels = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`h_name`, `hotel_addressline1`, `hotel_addressline2` FROM `hotels`;");

    $all_rooms = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`room_id` FROM `rooms`;");

    $all_customers = runSQLQueryAndReturnRows("SELECT DISTINCT `cust_id`,`cust_fname`FROM `customers`;");

    $all_employees = runSQLQueryAndReturnRows("SELECT DISTINCT `employ_id`,`employ_fname` FROM `employees`;");

}

if (isset($_POST["search"])) {

    global $id, $col_name, $table, $result_data;

    $id = $_POST['id_data'];

    if (openDBConnection()) {

        $query = "SELECT * FROM `$table` WHERE $col_name=$id;";
        // echo $query;

        $result_data = runSQLQueryAndReturnRows($query);

        if ($result_data) {
            //print_r($result_data);
            $rent_row = $result_data[0];
        } else {
            logErrorToDisplay("No record found for the id:$id");
        }

        closeDBConnection();
    }
}


if (isset($_POST['edit'])) {

    // print_r($_POST);

    $rent_row_defaults = print_r_reverse($_POST['edit']);
    $rent_id = $rent_row_defaults['rent_id'];

    $hotel_id = $_POST['hotel_id'] ?? $rent_row_defaults['hotel_id'];

    $room_id = $_POST['room_id'] ?? $rent_row_defaults['room_id'];

    $cust_id = $_POST['cust_id'] ?? $rent_row_defaults['cust_id'];

    $employ_id = $_POST['employ_id'] ?? $rent_row_defaults['employ_id'];

    $from_date = strtotime($_POST['from_date']);
    $to_date = strtotime($_POST['to_date']);

    $paid = 0;
    if (isset($_POST['paid'])) {
        $paid = 1;
    }

    $duration = $to_date - $from_date;

    $query = "UPDATE renting SET hotel_id=$hotel_id,room_id=$room_id, cust_id=$cust_id, employ_id=$employ_id, fromDate=$from_date, toDate=$to_date, duration=$duration, paid=$paid WHERE rent_id=$rent_id";

    if (openDBConnection()) {

        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully updated booking.');

        } else {

            logErrorToDisplay("Unsuccessful query execution, Booking update.");
        }

        closeDBConnection();
    }

}
?>

<div class="py-8 px-8">

    <div class="divider divider-secondary">Booking Search</div>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w-3/4">
        <label class="input input-bordered flex items-center gap-2">

            <input name="id_data" type="text" class="grow" placeholder="Enter Booking/Renting ID" />

            <button name="search" value="confirm" class="btn btn-sm">Search</button>

        </label>
    </form>


    <div class="divider divider-secondary">Booking Details:</div>

    <div class="my-4">
        <?php include ("./utils/alert_util.php") ?>
    </div>

    <!-- Results of search query, create form and add save button to update and delete button -->
    <?php global $result_data;
    if ($result_data): ?>

        <div class="">

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="flex flex-wrap space-y-4 px-4 my-8">
                <h1 class="text-xl">Edit Booking with ID#:
                    <?php echo $rent_row['rent_id']; ?>
                </h1>
                <div class="flex space-x-12 w-full">

                    <select name="hotel_id" value="<?php echo $rent_row['hotel_id']; ?>"
                        class="select select-bordered w-1/2 max-w-xs">

                        <option disabled>HotelID - Hotel Name</option>

                        <?php
                        openDBConnection();

                        $hotel_id = $rent_row['hotel_id'];

                        $old_hotel_info = runSQLQueryAndReturnRows("SELECT * FROM hotels WHERE hotel_id=$hotel_id")[0];
                        closeDBConnection();
                        ?>

                        <option disabled selected>
                            <?php echo $hotel_id ?> -
                            <?php echo $old_hotel_info['h_name'] ?>
                        </option>

                        <?php foreach ($all_hotels as $hotel_row): ?>

                            <option value="<?php echo $hotel_row['hotel_id'] ?>">
                                <?php echo htmlspecialchars($hotel_row['hotel_id'] . ' - ' . $hotel_row['h_name']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <select name="room_id" value="<?php echo $rent_row['room_id']; ?>"
                        class="select select-bordered w-1/2 max-w-xs">

                        <option disabled>HotelID - Hotel Name - Room ID</option>

                        <?php
                        openDBConnection();

                        $room_id = $rent_row['room_id'];
                        $hotel_id = $rent_row['hotel_id'];

                        $old_hotel_name = runSQLQueryAndReturnRows("SELECT `h_name` FROM hotels WHERE hotel_id=$hotel_id")[0];

                        closeDBConnection();
                        ?>

                        <option disabled selected>
                            <?php echo $hotel_id ?> -
                            <?php echo $old_hotel_name['h_name'] ?> - Room #
                            <?php echo $room_id ?>
                        </option>


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
                    <select name="cust_id" value="<?php $cust_id = $rent_row['cust_id'];
                    echo $cust_id; ?>"
                        class="select select-bordered w-full max-w-xs">

                        <option disabled>CustID - Cust Name</option>

                        <?php
                        openDBConnection();

                        // $cust_id = $rent_row['cust_id'];
                    
                        $cust_data = runSQLQueryAndReturnRows("SELECT `cust_fname` FROM customers WHERE cust_id=$cust_id")[0];

                        closeDBConnection();
                        ?>

                        <option disabled selected>
                            <?php echo $cust_id ?> -
                            <?php echo $cust_data['cust_fname'] ?? "Test User"; ?>
                        </option>

                        <?php foreach ($all_customers as $cust_row): ?>
                            <option value="<?php echo $cust_row['cust_id'] ?>">
                                <?php echo htmlspecialchars($cust_row['cust_id'] . ' - ' . $cust_row['cust_fname']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <select name="employ_id" value="" class="select select-bordered w-full max-w-xs">

                        <option disabled>EmployID - Employ Name</option>

                        <?php
                        openDBConnection();

                        $employ_id = $rent_row['employ_id'];

                        $data = runSQLQueryAndReturnRows("SELECT `employ_fname` FROM employees WHERE employ_id=$employ_id")[0];

                        closeDBConnection();
                        ?>

                        <option disabled selected>
                            <?php echo $employ_id ?> -
                            <?php echo $data['employ_fname'] ?? "System Admin"; ?>
                        </option>

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
                                <span class="label-text">Has the booking been paid for?</span>

                                <?php

                                $paid_value = $rent_row['paid'];

                                if ($paid_value == 0): ?>

                                    <input name="paid" value="paidFalse-<?php echo $paid_value; ?>" type="checkbox"
                                        class="toggle toggle-primary" />

                                <?php else: ?>

                                    <input name="paid" value="paidTrue-<?php echo $paid_value; ?>" type="checkbox"
                                        class="toggle toggle-primary" checked />

                                <?php endif; ?>

                            </label>
                        </div>
                    </div>

                    <button name="edit" value="<?php print_r($rent_row); ?>" class="btn btn-primary">Edit Booking</button>
                </div>

            </form>

        </div>

    <?php else: ?>

    <?php endif; ?>

</div>

<?php require ("./components/footer.php"); ?>
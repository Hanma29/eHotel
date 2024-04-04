<?php

$start;
$end;
$capacity;
$location;
$hotel_chain;
$rating;
$room_total;
$price;

$booking_data;

if (isset($_POST["submit"])) {
    global $start;
    global $end;
    global $capacity;
    global $location;
    global $hotel_chain;
    global $rating;
    global $room_total;
    global $price;

    $start = strtotime($_POST['start']) ?? strtotime(date('d/m/Y'));
    $end = strtotime($_POST['end']) ?? strtotime(date('d/m/Y'));

    $capacity = $_POST['capacity'] ?? 1;
    $location = $_POST['location'] ?? "None Selected" ;
    $hotel_chain = $_POST['hotel_chain'] ?? "None Selected";
    $rating = $_POST['rating'] ?? 1;
    $room_total = $_POST['room_total'] ?? 1;
    $price = $_POST['price'] ?? 1;

    $actual_price = $price * 400;

} else {
    $start = $end = $location = $hotel_chain = '';
    $capacity = $rating = $room_total = $price = 1;
}

?>

<?php require ("./components/header.php"); ?>

<?php


// Getting all chains & all locations to for use in select btns

$all_chains;
$all_locations;
$hotels_to_display;

$available_rooms;

if (openDBConnection()) {

    global $all_chains;
    $all_chains = runSQLQueryAndReturnRows("SELECT DISTINCT `chain_id`,`chain_name` FROM `hotel_chain`;");

    global $all_locations;
    $all_locations = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_addressline1` FROM `hotels`;");

    closeDBConnection();
}

if (isset($_POST["submit"])) {


    if (openDBConnection()) {


        /*  global $hotels_to_display;
         $hotels_to_display = array();

         $hotels_to_display = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`h_name` FROM `hotels` WHERE `chain_id`='$hotel_chain'"); */

        /* $get_avail_rooms = runSQLQueryAndReturnRows("SELECT * FROM `rooms` WHERE `room_id` NOT IN (
            SELECT * FROM `bookings` WHERE `room_id`
        )"); */

        global $available_rooms;
        $available_rooms = array();

        $query = "SELECT DISTINCT rooms.*
        FROM rooms
        LEFT JOIN renting ON rooms.room_id = renting.room_id
        WHERE renting.room_id IS NULL 
           OR (renting.room_id IS NOT NULL 
               AND ('$start' NOT BETWEEN renting.fromDate AND renting.toDate 
                   AND '$end' NOT BETWEEN renting.fromDate AND renting.toDate))
        AND rooms.hotel_id IN (
            SELECT DISTINCT hotel_id
            FROM hotels
            WHERE chain_id ='$hotel_chain' AND hotels.hotel_score>='$rating' AND hotels.totalRooms >='$room_total' AND hotels.hotel_addressline1='$location')
        AND rooms.price <= '$actual_price'
        AND rooms.capacity >= '$capacity'
        ";

        // echo $query;

        // echo $query;

        $available_rooms = runSQLQueryAndReturnRows($query);

        // print_r(($hotels));

        closeDBConnection();
    }
}

?>

<div class="homepage-search border-2 border-current rounded-lg px-8 py-8 h-1/2">

    <h3>Start your search journey today:</h3>

    <form method="POST" action="search.php" class="flex flex-wrap space-y-4">

        <div date-rangepicker class="flex items-center w-full">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input name="start" type="text" value="<?php echo $start ?>"
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
                <input name="end" type="text" value="<?php echo $end ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Select date end">
            </div>
        </div>

        <h3>Room Capacity:</h3>
        <input type="range" name="capacity" min="1" max="4" value="<?php echo $capacity ?>" class="range" step="1" />
        <div class="w-full flex justify-between text-xs px-2 range-sm">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4+</span>
        </div>

        <div class="w-full flex space-x-8">
            <select name="location" value="<?php echo $location ?>" class="select select-bordered w-full max-w-xs">
                <option disabled selected>Hotel Location</option>

                <?php foreach ($all_locations as $loc_row): ?>
                    <option>
                        <?php echo htmlspecialchars($loc_row['hotel_addressline1']) ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <select name="hotel_chain" value=" <?php echo htmlspecialchars($chain_row['chain_id']) ?>"
                class="select select-bordered w-full max-w-xs">
                <option disabled selected>Hotel Chain</option>

                <?php foreach ($all_chains as $chain_row): ?>
                    <option value="<?php echo htmlspecialchars($chain_row['chain_id']) ?>">
                        <?php echo htmlspecialchars($chain_row['chain_name']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <h3>Hotel Rating:</h3>
        <input name="rating" type="range" min="1" max="5" value="<?php echo $rating ?>" class="range" step="1" />
        <div class="w-full flex justify-between text-xs px-2">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
        </div>

        <h3>Total Rooms:</h3>
        <input name="room_total" type="range" min="1" max="4" value="<?php echo $room_total ?>" class="range"
            step="1" />
        <div class="w-full flex justify-between text-xs px-2">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
        </div>

        <h3>Price per Night/Per Room</h3>
        <input name="price" type="range" min="1" max="4" value="<?php echo $price ?>" class="range" step="1" />
        <div class="w-full flex justify-between text-xs px-2">
            <span>$100</span>
            <span>$400</span>
            <span>$800</span>
            <span>$1200+</span>
        </div>

        <button name="submit" class="btn btn-primary">Search</button>
    </form>

</div>

<?php if (isset($_POST['submit'])): ?>
    <div class="search-results">
        <h3 class="text-center text-white text-xl bold py-4">Search Results: </h3>


        <?php if ($available_rooms): ?>

            <div class="grid grid-cols-3 gap-8 px-8 mb-4">

                <?php
                global $available_rooms;

                foreach ($available_rooms as $room_row): ?>

                    <div class="card w-96 bg-base-300 shadow-xl">
                        <figure><img
                                src="https://media.istockphoto.com/id/1198357641/photo/beachfront-bungalow-with-sea-view.jpg?s=612x612&w=0&k=20&c=IzbxGDLBX_Bk-gAth-bo2B6DoecThMDcOkSdiGiXW0w="
                                alt="Shoes" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">Room #
                                <?php echo $room_row['room_id'] ?> - 
                                <?php echo date("d-m-Y", $start) ?> to <?php echo date("d-m-Y", $end) ?>
                            </h2>

                            <div class="badge badge-accent">Available</div>
                            <p>
                                Ammenities:
                                <?php echo $room_row['amenities'] ?>
                            </p>

                            <div class="grid grid-cols-2 gap-2">

                                <div class="badge badge-outline badge-primary">Hotel:
                                    <?php

                                    $hotel_id = $room_row['hotel_id'];

                                    openDBConnection();

                                    $hotel_name_query = runSQLQueryAndReturnRows("SELECT * FROM `hotels` WHERE `hotel_id`='$hotel_id'");

                                    closeDBConnection();

                                    // print_r($hotel_name_query);
                        
                                    echo $hotel_name_query[0]['h_name'];

                                    ?>
                                </div>

                                <div class="badge badge-outline">View type:
                                    <?php echo $room_row['view_type'] ?>
                                </div>

                                <div class="badge badge-outline badge-secondary">
                                    <?php

                                    global $hotel_name_query;
                                    echo $hotel_name_query[0]['hotel_addressline1'];

                                    ?>
                                </div>

                                <div class="badge badge-outline"> Capacity:
                                    <?php echo $room_row['capacity'] ?>
                                </div>

                                <div class="badge badge-outline">$
                                    <?php echo $room_row['price'] ?>/night
                                </div>
                            </div>

                            <!-- <div class="card-actions justify-end">

                                <button class="btn btn-primary">Book Now</button>
                            </div> -->

                            <button class="btn btn-primary" onclick="book_<?php

                            $modal_id;
                            $modal_id = $room_row['hotel_id'] . '_' . $room_row['room_id'];

                            echo $modal_id;
                            ?>.showModal()">Book Now</button>

                            <dialog id="book_<?php global $modal_id;
                            echo $modal_id; ?>" class="modal">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg mb-4">Confirm booking for: Room #
                                        <?php echo $room_row['room_id'] ?>
                                    </h3>

                                    <div class="grid grid-cols-2 gap-2">

                                        <div class="badge badge-outline badge-primary">Hotel:
                                            <?php
                                            global $hotel_name_query;

                                            echo $hotel_name_query[0]['h_name'];

                                            ?>
                                        </div>

                                        <div class="badge badge-outline">View type:
                                            <?php echo $room_row['view_type'] ?>
                                        </div>

                                        <div class="badge badge-outline badge-secondary">
                                            <?php

                                                global $hotel_name_query;
                                                echo $hotel_name_query[0]['hotel_addressline1'];

                                            ?>
                                        </div>

                                        <div class="badge badge-outline"> Capacity:
                                            <?php echo $room_row['capacity'] ?>
                                        </div>

                                        <div class="badge badge-outline">$
                                            <?php echo $room_row['price'] ?>/night
                                        </div>
                                    </div>

                                    <p class="py-4"><?php echo date("d-m-Y", $start) ?> to <?php echo date("d-m-Y", $end) ?></p>


                                    <div class="modal-action">
                                        <form method="POST" action="view_bookings.php">
                                            <!-- if there is a button in form, it will close the modal -->

                                            <input type="hidden" name="room_data" value="<?php print_r($room_row) ?>">
                                            <input type="hidden" name="booking_data" value="<?php

                                            global $start;
                                            global $end;
                                            $cust_id = -1;
                                            $employ_id = -1;

                                            $booking_data = array('start' => $start, 'end' => $end, 'employ_id' => $employ_id, 'cust_id' => $cust_id);
                                            //setcookie('booking_data', print_r($booking_data), time() + 86400);
                                
                                            print_r($booking_data) ?>">

                                            <div class="flex space-x-8">
                                                <button name="confirmed" class="btn btn-success text-white">Confirm</button>
                                                <button value="cancelled" type="button" class="btn btn-error text-white"
                                                    onclick="book_<?php global $modal_id;
                                                    echo $modal_id; ?>.close()">
                                                    Cancel</button>
                                                <!-- <button class="btn">Close</button> -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div>
                <h3 class="text-xl text-red text-center">There are currently no rooms available with the above criteria. Please try a different criteria or try again later.</h3>
            </div>

        <?php endif; ?>
    </div>

<?php endif; ?>

<?php require ("./components/footer.php"); ?>
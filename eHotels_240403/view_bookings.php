<?php require ("./components/header.php"); ?>

<?php

include('./utils/reverse_print_r.php');

$current_bookings;

// print_r($_POST);

if (isset($_POST["confirmed"])) {

    // echo "confirm ISSET";

    $booking_data_raw = $_POST['booking_data'];
    // echo $booking_data_raw;

    $booking_data = print_r_reverse($booking_data_raw);

    $cust_id = $booking_data['cust_id'] ?? -1;
    // echo $cust_id.'##########';
    $employ_id = $booking_data['employ_id'] ?? -1;
    $from_date = $booking_data['start'];
    $to_date = $booking_data['end'];

    $room_dat_raw = $_POST['room_data'];
    // echo $room_dat_raw;

    $room_data = print_r_reverse($room_dat_raw);
    $hotel_id = $room_data['hotel_id'];
    $room_id = $room_data['room_id'];

    $paid = 0;

    $duration = $to_date - $from_date;

    $query = "INSERT INTO renting(hotel_id, room_id, cust_id, employ_id, fromDate, toDate, duration, paid) VALUES ('$hotel_id', '$room_id', '$cust_id', '$employ_id', '$from_date', '$to_date', '$duration', '$paid');";

    // echo $query;

    // echo $query;

    if (openDBConnection()) {
        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully created booking at hotel!');

            $_POST['confirmed'] = null;
            // header("Location: create_chain.php");

        } else {

            logErrorToDisplay("Unsuccessful query execution, Room create.");
            // echo "Unsuccessful query execution.";
        }

        closeDBConnection();
    }



}else {
    // echo "No data recieved from confirm."."         |         ";
}

if (isset($_POST["confirm_cancel"])) {

    // echo "cancelled ISSET";

    $renting_data_raw = $_POST['renting_data'];
    // echo $renting_data_raw;
    // echo $booking_data_raw;

    $renting_data = print_r_reverse($renting_data_raw);
    $rent_id = $renting_data['rent_id'];

    $query = "DELETE FROM `renting` WHERE `rent_id`='$rent_id';";

    // echo $query;

    // echo $query;

    if (openDBConnection()) {


        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully cancelled booking!');
            // header("Location: create_chain.php");
            // echo "QUERY RAN";

        } else {

            // echo "QUERY FAILED";
            // header("Location: index.php");
            logErrorToDisplay("Unsuccessful query execution, Booking cancel failed.");
            // echo "Unsuccessful query execution.";
        }

        closeDBConnection();
    }



} else {
   // echo "No data recieved from confirmed_cancel"."        | Data IN POST array is: ";
}

//print_r($_POST);

openDBConnection();
$get_bookings_query = "SELECT * FROM `renting` WHERE `cust_id`='-1'";
// echo $get_bookings_query;

$current_bookings = runSQLQueryAndReturnRows($get_bookings_query);
closeDBConnection();

?>

<div class="search-results">
        <h3 class="text-center text-white text-xl bold py-4">Current Bookings: </h3>

        <div class="grid grid-cols-3 gap-8 px-8 mb-4">

            <?php global $current_bookings; 
            
            if ($current_bookings): ?>

                <?php

            
                foreach ($current_bookings as $booking):
                
                    $room_id = $booking['room_id'];

                    openDBConnection();

                    $room_row;
                    $room_row = runSQLQueryAndReturnRows("SELECT * FROM rooms WHERE room_id='$room_id'")[0];
                ?>


                    <div class="card w-96 bg-base-300 shadow-xl border-white border-1">
                        <figure><img src="https://media.istockphoto.com/id/1198357641/photo/beachfront-bungalow-with-sea-view.jpg?s=612x612&w=0&k=20&c=IzbxGDLBX_Bk-gAth-bo2B6DoecThMDcOkSdiGiXW0w=" alt="Shoes" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">Room #
                                <?php echo $room_row['room_id'] ?> - 
                                <?php echo date("d-m-Y", $booking['fromDate']) ?> to <?php echo date("d-m-Y", $booking['toDate']) ?>
                            </h2>

                            <div class="badge badge-warning">Reserved</div>
                            <p>
                                Ammenities: <?php echo $room_row['amenities'] ?>
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

                            <button class="btn btn-error" onclick="delete_<?php 
                            
                            $modal_id;
                            $modal_id = $room_row['hotel_id'].'_'.$room_row['room_id'];

                            echo $modal_id;
                            ?>.showModal()">Cancel Booking</button>

                            <dialog id="delete_<?php global $modal_id;  echo $modal_id; ?>" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg mb-4">Confirm cancellation for: Room #
                                <?php echo $room_row['room_id'] ?></h3>

                                <div class="grid grid-cols-2 gap-2">

                                <div class="badge badge-outline badge-primary">Hotel: 
                                    <?php 
                                
                                        echo $hotel_name_query[0]['h_name'];

                                    ?>
                                </div>

                                <div class="badge badge-outline">View type: 
                                    <?php echo $room_row['view_type'] ?>
                                </div>

                                <div class="badge badge-outline badge-secondary">
                                <?php 

                                    // global $hotel;
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

                            <p class="py-4"><?php echo date("d-m-Y", $booking['fromDate']) ?> to <?php echo date("d-m-Y", $booking['toDate']) ?></p>
                                
                                <div class="modal-action">
                                <form method="POST" action="view_bookings.php">
                                    <!-- if there is a button in form, it will close the modal -->

                                    <input type="hidden" name="renting_data" value="<?php print_r($booking) ?>">
                                    
                                    <div class="flex space-x-8">
                                    <button name="confirm_cancel" value="confirm" class="btn btn-success text-white">Confirm</button>
                                    
                                    <button name="cancel" value= "cancelled" type="button" class="btn btn-error text-white" onclick="delete_<?php echo $modal_id; ?>.close()">
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

            <?php else: ?>

                <div>
                    <h3 class="text-xl text-red">You do not currently have any bookings.</h3>
                </div>


            <?php endif; ?>
        </div>


    </div>

<?php require ("./components/footer.php"); ?>
<?php

require ("./components/header.php");
require ("./utils/reverse_print_r.php");


$query = '';
$result_data_raw;
$view_type;

if (isset($_POST['view_type'])) {

    $view_type = $_POST['view_type'];

    // echo $type;

    $query;

    if ($view_type == 'rooms') {
        $query = "SELECT hotels.hotel_addressline1 AS Area,
        COUNT(rooms.room_id) AS AvailableRooms
        FROM hotels
        JOIN rooms ON hotels.hotel_id = rooms.hotel_id
        LEFT JOIN renting ON rooms.room_id = renting.rent_id
        WHERE renting.rent_id IS NULL OR renting.fromDate < CURRENT_DATE
        GROUP BY hotels.hotel_addressline1;";
    } else {

        $query = "SELECT hotels.hotel_id,
        hotels.h_name AS HotelName,
        SUM(rooms.capacity
                 -- Add more cases as needed for other capacity types
            ) AS AggregatedCapacity
        FROM hotels
        JOIN rooms ON hotels.hotel_id = rooms.hotel_id
        GROUP BY hotels.hotel_id, hotels.h_name;";

    }

    if (openDBConnection()) {
        $result_data_raw = runSQLQueryAndReturnRows($query);

        // print_r($result_data_raw);

        closeDBConnection();
    }
}
?>

<div class="py-8 px-8">

    <div class="divider divider-info">Select View Type:</div>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w-full flex">
        <label class="input input-bordered flex items-center gap-2">

            <!-- <input name="id_data" type="text" class="grow" placeholder="Enter Booking/Renting ID" /> -->

            <select class="select select-bordered w-full max-w-xs" name="view_type" value="">
                <option disabled selected>View Type</option>
                <option value="rooms">Available Rooms</option>
                <option value="capacity">Aggregated Capacity</option>
            </select>

            <button name="submit" value="confirm" class="btn btn-sm">Create</button>

        </label>
    </form>


    <div class="divider divider-info">View Details:</div>

    <div class="my-4">
        <?php include ("./utils/alert_util.php") ?>
    </div>

    <!-- Results of search query, create form and add save button to update and delete button -->
    <?php global $result_data_raw;
    if ($result_data_raw): ?>

        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <?php if ($view_type == 'rooms'): ?>
                            <th>Hotel Location</th>
                            <th>Available Rooms</th>

                        <?php else: ?>
                            <th>Hotel ID</th>
                            <th>Hotel Name</th>
                            <th>Hotel Capacity</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                
                <tbody>

                    <?php global $view_type; if ($view_type == 'rooms'): ?>

                        <?php
                        $local_index = 1;
                        foreach ($result_data_raw as $result_data): ?>

                            <tr>
                                <th><?php echo $local_index; ?></th>
                                <td><?php echo $result_data['Area']?></td>
                                <td><?php echo $result_data['AvailableRooms']?></td>
                            </tr>
                        <?php $local_index++; endforeach; ?>

                    <?php else: ?>

                        <?php
                        $local_index = 1;
                        foreach ($result_data_raw as $result_data): ?>

                            <tr>
                                <th><?php echo $local_index; ?></th>
                                <td><?php echo $result_data['hotel_id']?></td>
                                <td><?php echo $result_data['HotelName']?></td>
                                <td><?php echo $result_data['AggregatedCapacity']?></td>
                            </tr>
                        <?php $local_index++; endforeach; ?>

                    <?php endif; ?>

                </tbody>
            </table>
        </div>

    <?php else: ?>

    <?php endif; ?>

</div>

<?php require ("./components/footer.php"); ?>
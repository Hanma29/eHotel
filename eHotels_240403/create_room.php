<?php require ("./components/header.php"); ?>

<?php

$all_hotels;

if (openDBConnection()) {

    global $all_hotels;
    $all_hotels = runSQLQueryAndReturnRows("SELECT DISTINCT `hotel_id`,`h_name` FROM `hotels`;");

    closeDBConnection();
}

if (isset($_POST['submit'])) {

    $hotel_id = $_POST['hotel_id'];
    $price = $_POST['room_price'];
    $amenities = $_POST['amenities'];
    $capacity = $_POST['capacity'];
    $view_type = $_POST['view_type'];
    
    $canExtend;
    if($_POST['canExtend'] == 'on'){
        $canExtend = true;
    }else{
        $canExtend = false;
    }

    $damage_notes = $_POST['damage_notes'];

    // $chain_idnumber = $_POST['chain_idnumber'];

    $query = "INSERT INTO rooms(hotel_id, price, amenities, capacity, view_type, canExtend, damage_notes) VALUES ('$hotel_id', '$price', '$amenities', '$capacity', '$view_type', '$canExtend', '$damage_notes');";

    // echo $query;

    if (openDBConnection()) {

        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully created hotel room,');
            // header("Location: create_chain.php");

        } else {

            logErrorToDisplay("Unsuccessful query execution, Room create.");
            // echo "Unsuccessful query execution.";
        }

        closeDBConnection();
    }

}

?>

<div class="w-1/2 flex justify-center">

    <?php include ("./utils/alert_util.php") ?>

    <h1 class="text-xl text-center">Create a New Room</h1>

    <form method="POST" action="create_room.php" class="flex flex-col flex-wrap space-y-4 px-4 my-8">

        <select name="hotel_id" value="" class="select select-bordered w-full max-w-xs">

            <option disabled selected>HotelID - Hotel Name</option>

            <?php foreach ($all_hotels as $hotel_row): ?>
                <option value="<?php echo $hotel_row['hotel_id'] ?>">
                    <?php echo htmlspecialchars($hotel_row['hotel_id'] . ' - ' . $hotel_row['h_name']) ?>
                </option>
            <?php endforeach; ?>

        </select>

        <label class="input input-bordered flex items-center gap-2">
            Price
            <input name="room_price" type="text" class="grow" placeholder="Price Per Night/$" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Amenities
            <input name="amenities" type="text" class="grow" placeholder="Room Ammenities (AC etc.)" />
        </label>

        <h3>Capacity:</h3>
        <input name="capacity" type="range" min="1" max="4" class="range" step="1" />
        <div class="w-full flex justify-between text-xs px-2">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4+</span>
        </div>

        <div class="flex flex-col">
            <div class="form-control w-52">
                <label class="cursor-pointer label">
                    <span class="label-text">Extendable</span>
                    <input name="canExtend" type="checkbox" class="toggle toggle-primary"/>
                </label>
            </div>
        </div>

        <h3>Room View Type</h3>
        <select name="view_type" value="" class="select select-bordered w-full max-w-xs">

            <option disabled selected>View Type:</option>

            <option value="Mountain">Mountain</option>
            <option value="Sea">Sea</option>
            <option value="None">None</option>

        </select>

        <label class="input input-bordered flex items-center gap-2">
            Damage Notes
            <input name="damage_notes" type="text" class="grow" placeholder="Damage Notes" />
        </label>

        <button name="submit" class="btn btn-primary">Create Hotel Room</button>

    </form>
</div>

<?php require ("./components/footer.php"); ?>
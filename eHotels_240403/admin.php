<?php require("./components/header.php"); ?>

<div class="divider divider-primary">Admin Create Functions</div>
<div class="grid grid-cols-3 gap-4 w-full px-32">
    <a href="./create_chain.php"><button class="btn btn-primary w-full">Create a Hotel Chain</button></a>
    <a href="./create_hotel.php"><button class="btn btn-primary w-full">Create a Hotel</button></a>
    <a href="./create_employee.php"><button class="btn btn-primary w-full">Create a Employee</button></a>
    <a href="./create_customer.php"><button class="btn btn-primary w-full">Create a Customer</button></a>
    <a href="./create_room.php"><button class="btn btn-primary w-full">Create a Room</button></a>
    <a href="./create_booking.php"><button class="btn btn-primary w-full">Create a Booking</button></a>
</div>

<div class="divider divider-accent">Admin Edit/Delete Functions</div>
<div class="grid grid-cols-3 gap-4 w-full px-32 my-4">
    <a href="./manage_chain.php"><button class="btn btn-accent w-full">Manage a Hotel Chain</button></a>
    <a href="./manage_hotel.php"><button class="btn btn-accent w-full">Manage a Hotel</button></a>
    <a href="./manage_employee.php"><button class="btn btn-accent w-full">Manage a Employee</button></a>
    <a href="./manage_customer.php"><button class="btn btn-accent w-full">Manage a Customer</button></a>
    <a href="./manage_room.php"><button class="btn btn-accent w-full">Manage a Room</button></a>
    <a href="./manage_booking.php"><button class="btn btn-accent w-full">Manage a Booking</button></a>
</div>

<div class="divider divider-info">Admin View Functions</div>
<div class="grid grid-cols-3 gap-4 w-full px-32 my-4">
    <a href="./view_area.php"><button class="btn btn-info w-full">Display Views</button></a>
   </div>


<?php require("./components/footer.php"); ?>
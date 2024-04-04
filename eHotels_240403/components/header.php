
<?php 

  include("./utils/mysql_util.php");
  include('./utils/error_handler.php');
  include('./utils/alert_util.php');
// Getting data from our db
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eHotels 2024 Group -</title>

    <!-- TailwindCSS + DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.9.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>

<body>

<div class="navbar bg-base-30 px-4">
  <div class="flex-1">
    <a class="btn btn-ghost text-xl" href="index.php">eHotels</a>
  </div>
  <div class="flex-none">
    <ul class="menu menu-horizontal px-1">
      <!-- <li><a>Link</a></li> -->
      <li>
        <details>
          <summary>
            View
          </summary>
          <ul class="p-2 bg-base-100 rounded-t-none">
            <li><a href="search.php">User</a></li>
            <li><a href="admin.php">Admin</a></li>
          </ul>
        </details>
      </li>
    </ul>
  </div>
</div>


<?php require ("./components/header.php"); ?>

<?php

if (isset($_POST['submit'])) {

    $cust_name = $_POST['cust_name'];
    $cust_addressline1 = $_POST['cust_addressline1'];
    $cust_addressline2 = $_POST['cust_addressline2'];
    $cust_idtype = $_POST['cust_idtype'];

    // $cust_idnumber = $_POST['cust_idnumber'];

    $query = "INSERT INTO customers(cust_fname, cust_addressline1, cust_addressline2, id_type) VALUES ('$cust_name', '$cust_addressline1', '$cust_addressline2', '$cust_idtype');";

    // echo $query;

    if (openDBConnection()) {

        if (runSQLUpdate($query)) {

            alertToDisplay('Successfully created customer: '.$cust_name);

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

    <h1 class="text-xl">Create a New Customer</h1>

    <form method="POST" action="create_customer.php" class="flex flex-col flex-wrap space-y-4 px-4 my-8">

        <label class="input input-bordered flex items-center gap-2">
            Name
            <input name="cust_name" type="text" class="grow" placeholder="Customer Name" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 1
            <input name="cust_addressline1" type="text" class="grow"
                placeholder="Address Line 1 (House No., PO Box.)" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 2
            <input name="cust_addressline2" type="text" class="grow" placeholder="" />
            <span class="badge badge-info">Optional</span>
        </label>

        <div>
            <h4>ID Type:</h4>

            <div class="form-control flex">
                <label class="label cursor-pointer">
                    <span class="label-text">SIN</span>
                    <input value="SIN" type="radio" name="cust_idtype" class="radio checked:bg-red-500" checked />
                </label>

                <label class="label cursor-pointer">
                    <span class="label-text">Driver's Licence</span>
                    <input value="License" type="radio" name="cust_idtype" class="radio checked:bg-red-500" />
                </label>

                <label class="label cursor-pointer">
                    <span class="label-text">Passport</span>
                    <input value="Passport" type="radio" name="radio-10" class="radio checked:bg-red-500" />
                </label>
            </div>

            <label class="input input-bordered flex items-center gap-2">
                ID Number:
                <input name="cust_idnumber" type="text" class="grow" placeholder="ID Number" />
            </label>
        </div>


        <button name="submit" class="btn btn-primary">Create Customer</button>

    </form>
</div>

<?php require ("./components/footer.php"); ?>
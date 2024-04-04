<?php require ("./components/header.php"); ?>

<?php 
    
    if (isset($_POST['submit'])) {

        $chain_name = $_POST['chain_name'];
        $chain_addressline1 = $_POST['chain_addressline1'];
        $chain_addressline2 = $_POST['chain_addressline2'];

        // $chain_idnumber = $_POST['chain_idnumber'];

        $query = "INSERT INTO hotel_chain(chain_name, chain_addressline1, chain_addressline2) VALUES ('$chain_name', '$chain_addressline1', '$chain_addressline2');";

        // echo $query;

        if(openDBConnection()){
            
            if(runSQLUpdate($query)){

                alertToDisplay('Successfully created chain: '.$chain_name);
                // header("Location: create_chain.php");

            }else{

                logErrorToDisplay("Unsuccessful query execution, chain create.");
                // echo "Unsuccessful query execution.";
            }

            closeDBConnection();
        }
        
    }

?>

<div>


    <?php include("./utils/alert_util.php") ?>

    <h1 class="text-xl">Create a New Chain</h1>

    <form method="POST" action="create_chain.php" class="flex flex-col flex-wrap space-y-4 px-4 my-8">

        <label class="input input-bordered flex items-center gap-2">
            Chain Name
            <input name="chain_name" type="text" class="grow" placeholder="Chain Name" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 1
            <input name="chain_addressline1" type="text" class="grow"
                placeholder="Address Line 1 (House No., PO Box.)" />
        </label>

        <label class="input input-bordered flex items-center gap-2">
            Address Line 2
            <input name="chain_addressline2" type="text" class="grow" placeholder="" />
            <span class="badge badge-info">Optional</span>
        </label>
        
        <button name="submit" class="btn btn-primary">Create Chain</button>

    </form>
</div>

<?php require ("./components/footer.php"); ?>
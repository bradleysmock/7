<?php

	// configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("deposit_form.php", ["title" => "Deposit Funds"]);
    }    
    else
    {
	// get values needed
	$id = $_SESSION["id"];
	$cash = query("SELECT cash FROM users WHERE id = $id");
	
	$deposit = $_POST["deposit"];

	// check for bad deposit
	if ($deposit <= 0)
	{
		apologize("Invalid deposit amount.");
	}
	
	query("UPDATE users SET cash = cash + $deposit WHERE id = $id");


	redirect("/");
    }

    
?>

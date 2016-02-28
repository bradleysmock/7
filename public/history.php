<?php

    // configuration
    require("../includes/config.php"); 

    // load user and portfolio 
    $rows = query("SELECT * FROM transactions WHERE id = ?", $_SESSION["id"]);
    
	// render transactions
	render("transactions.php", [
        	"title" => "History",
        	"stocks" => $rows,
    	]);

?>

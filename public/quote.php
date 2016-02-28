<?php

    // configuration
    require("../includes/config.php"); 

// if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("stock_form.php", ["title" => "Get Quote"]);
    }

    else
    {
	// display stocks latest price
	// lookup returns array of symbol, name, price
	$stock = lookup($_POST["symbol"]);

	if ($stock === false)
	{
		apologize("Couldn't find stock quote!");
	}
	
	else
	{		
        	// return stock price
		render("stockprice.php", [
        		"title" => "Stock Price",
 			"symbol" => $stock["symbol"],
			"price" => number_format($stock["price"], 4)
    		]);
	}
   }

?>

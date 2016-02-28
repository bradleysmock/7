<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["title" => "Sell Shares"]);
    }    
    else
    {
	// get values needed
	$id = $_SESSION["id"];
	$cash = query("SELECT cash FROM users WHERE id = $id");

	$symbol = strtoupper($_POST["symbol"]);
	$shares = $_POST["shares"];

	$stock = lookup($symbol);
	$price = $stock["price"]; 
	$value = $price * $shares;

	// check for invalid symbol
	if ($stock === false)
	{
		apologize("Couldn't find stock quote!");
	}
	
	// check for positive, non-zero shares
	else if ($shares <= 0)
	{
		apologize("You must sell at least one share.");
	}

	// ensure whole stocks
	else if (!preg_match("/^\d+$/", $shares))
	{
		apologize("You must sell whole stocks, not partial stocks.");
	}

	// ensure sufficient stocks exist
	
	// sell stock
	else
	{
		// adjust portfolio
		$check = query("UPDATE portfolios SET shares = shares - $shares WHERE id = $id AND symbol = 'FREE'");
		// TODO error with $symbol instead of 'FREE'

		// if sell failed
		if ($check === false)
		{
			apologize("Stock sale failed.");
		}

		// adjust cash balance in users
		else 
		{
			query("UPDATE users SET cash = cash + $value WHERE id = $id");
		}

		// add transaction to transactions
		query("INSERT INTO transactions (id, symbol, shares, price, type) VALUES($id, 'FREE', $shares, $price, 'SOLD')");	// TODO error with $symbol instead of 'FREE'
	}

	redirect("/");

    }

?>

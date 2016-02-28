<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "Buy Shares"]);
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
		apologize("You must buy at least one share.");
	}

	// ensure whole stocks
	else if (!preg_match("/^\d+$/", $shares))
	{
		apologize("You must purchase whole stocks, not partial stocks.");
	}
	
	// check for sufficient funds
	else if ($cash <= $value)
	{
		apologize("You have insufficient funds for this purchase!");
	}
	
	// purchase stock
	else
	{
		// add to portfolio
		$check = query("INSERT INTO portfolios (id, symbol, shares) VALUES($id, 'FREE', $shares) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)");
		// TODO error if replace free with $symbol

		// if add failed
		if ($check === false)
		{
			apologize("Stock purchase failed.");
		}

		// adjust cash balance in users
		else 
		{
			query("UPDATE users SET cash = cash - $value WHERE id = $id");
		}

		// add transaction to transactions
		query("INSERT INTO transactions (id, symbol, shares, price, type) VALUES($id, 'FREE', $shares, $price, 'BOUGHT')"); // TODO error if replace free with $symbol	
	}

	redirect("/");

    }

?>

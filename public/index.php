<?php

    // configuration
    require("../includes/config.php"); 

    // load user and portfolio 
    $user = query("SELECT * FROM users WHERE id = ?",$_SESSION["id"]);
    $rows = query("SELECT * FROM portfolios WHERE id = ?", $_SESSION["id"]);
    
    $stocks = [];
    foreach($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $stocks[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"]
            ];
        }
    }
    
    // render portfolio
    render("portfolio.php", [
        "title" => "Portfolio",
 	"user" => $user[0],
        "stocks" => $stocks,
    ]);

?>

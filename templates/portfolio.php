<ul class="nav nav-pills">
    <li><strong>Welcome, <?= $user["username"] ?>.<br>Cash: $<?= number_format($user["cash"], 2) ?></strong></li>
    <li><a href="deposit.php">Deposit</a></li>
    <li><a href="quote.php">Quote</a></li>
    <li><a href="buy.php">Buy</a></li>
    <li><a href="sell.php">Sell</a></li>
    <li><a href="history.php">History</a></li>
    <li><a href="logout.php"><strong>Log Out</strong></a></li>
</ul>

<table class="table table-striped">
    <thead>
	<tr>
       	    <td>Symbol</td>
	    <td>Name</td>
            <td>Shares</td>
            <td>Price</td>
	    <td>Value</td>
    	</tr>
    </thead>
    <tbody>
    <?php foreach($stocks as $stock): ?>    
        <tr>
            <td><?= $stock["symbol"] ?></td>
	    <td><?= $stock["name"] ?></td>
            <td><?= $stock["shares"] ?></td>
            <td><?= $stock["price"] ?></td>
	    <td>$<?= number_format($stock["price"] * $stock["shares"], 2) ?></td>
        </tr> 
    <?php endforeach ?>
    </tbody>
</table>

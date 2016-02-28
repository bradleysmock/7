<table class="table table-striped">
    <thead>
	<tr>
       	    <td>Date</td>
	    <td>Type</td>
	    <td>Symbol</td>
            <td>Shares</td>
            <td>Price</td>
	    <td>Total</td>
    	</tr>
    </thead>
    <tbody>
    <?php foreach($stocks as $stock): ?>    
        <tr>
            <td><?= $stock["datetime"] ?></td>
	    <td><?= $stock["type"] ?></td>
	    <td><?= $stock["symbol"] ?></td>
            <td><?= $stock["shares"] ?></td>
            <td><?= $stock["price"] ?></td>
	    <td>$<?= number_format($stock["price"] * $stock["shares"], 2) ?></td>
        </tr> 
    <?php endforeach ?>
    </tbody>
</table>

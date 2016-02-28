<?php

	// configuration
	require("../includes/config.php");

	// if user reached page via GET (as by clicking a link or via redirect)
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		// else render form
		render("register_form.php", ["title" => "Register"]);
	}

	// else if user reached page via POST (as by submitting a form via POST)
	else if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// error! POST undefined
		if ($_POST["username"] == NULL || $_POST["password"] == NULL)
		{
			// Username/Password not entered
			apologize("Username/Password not entered!");
		}

		if ($_POST["password"] != $_POST["confirmation"])
		{
			// Passwords don't match
			apologize("Passwords don't match!");
		}

		$result = query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 0.00)",
			$_POST["username"], crypt($_POST["password"]));
		// if query returns false, e.g. username taken
		if ($result === false)
		{
			apologize("Username already taken!");
		}

		// log in new user
		$rows = query("SELECT LAST_INSERT_ID() AS id");
		$id = $rows[0]["id"];
		$_SESSION["id"] = $id;

		redirect("index.php");
	}

?>

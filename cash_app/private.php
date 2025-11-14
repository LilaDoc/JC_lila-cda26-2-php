<?php
  require 'header.php';
 if ($_SESSION['loggedin'] !== true) {
    header('Location: index.php');
 }else{
    echo "<h1>Welcome to the Private Page</h1>";
    echo "<p>Your role is: " . $_SESSION['role'] . "</p>";
    echo "<p>Your name is: " . $_SESSION['email'] . "</p>";
    echo "welcome to the cash management system.";
    echo '
    <form action=private.php method=post>
        <label for="montantTotal">Montant Total</label>
        <input type="number" id="montantTotal" name="montantTotal" required>
        <br>
        <label for="montantPaye">Montant Payé</label>
        <input type="number" id="montantPaye" name="montantPaye" required>
        <br>
        <button type="submit">Log In</button>
        ';
 }
?>
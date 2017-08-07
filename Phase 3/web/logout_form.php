<form action="/logout.php">
  <?php echo "Welcome ". $_SESSION['username'] . " to " . $_SESSION['siteshortname'];?>
  <input type="submit" value="Logout">
</form>
<br><br>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Client</title>
</head>
<body>

<form action="./result/" method="get">
<?php
  $is_enroll_or_edit = false;
  include '../user_form.php';
?>
</form><br>

<br>
<br>
<a href=/main-menu/view-reports/view-client-search-report/index.php>Back</a>
<br>
<br>
</body>
</html>

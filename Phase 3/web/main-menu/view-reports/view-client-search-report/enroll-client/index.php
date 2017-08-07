<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Enroll Client</title>
</head>
<body>

<form action="./result/" method="post">
<?php
  $is_enroll_or_edit = true;
  include '../user_form.php';
?>
</form><br>

</body>
<br>
<br>
<a href=/main-menu/view-reports/view-client-search-report/index.php>Back</a>
<br>
<br>
</html>

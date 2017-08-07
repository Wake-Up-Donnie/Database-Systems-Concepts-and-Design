<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
$conn = getConn();
?>

<!DOCTYPE html>
<html>
<head>
<title> View Meal Remaining Report </title>
</head>
<body>

<h1> Meal Remaining Report Report </h1>

<?php
 
$query = "
SELECT SUM(NumberOfUnits) AS totalUnits, CASE SubCategory
    WHEN 'Meat/seafood' THEN 'Meat/seafood/Dairy/eggs'
    WHEN 'Dairy/eggs' THEN 'Meat/seafood/Dairy/eggs'
    WHEN 'Vegetables' THEN 'Vegetables'
    WHEN 'Nuts/grains/beans' THEN 'Nuts/grains/beans'
    ELSE 'Other'
    END AS mealComponents
From Item
WHERE SubCategory IN ('Meat/seafood','Dairy/eggs', 'Vegetables', 'Nuts/grains/beans')
Group By mealComponents
";

$result = $conn->query($query);
?>

<?php 

if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
    echo "No report available.";
}


if ($result->num_rows > 0) {

    echo "All meals remainging in inventory in all foodbanks." . "<br><br>";

    echo '<table width=50% border=1>';
        echo '<tr style="font-weight:bold">';
        echo '<td>MealComponents</td>';
        echo '<td>Quantity</td>'; 
        echo '</tr>';
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['mealComponents'] . "</td>";
        echo "<td>" . $row['totalUnits'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "No meal remainging report";
}

echo "</table>";
?>

<br><br>


<?php 
/*
$query = "
SELECT MIN(totalUnits) AS totalUnits, mealComponents 
FROM (
    SELECT SUM(NumberOfUnits) AS totalUnits, CASE SubCategory
        WHEN 'Meat/seafood' THEN 'Meat/seafood/Dairy/eggs'
        WHEN 'Dairy/eggs' THEN 'Meat/seafood/Dairy/eggs'
        WHEN 'Vegetables' THEN 'Vegetables'
        WHEN 'Nuts/grains/beans' THEN 'Nuts/grains/beans'
        ELSE 'Other'
        END AS mealComponents
    From Item
    WHERE SubCategory IN ('Meat/seafood','Dairy/eggs', 'Vegetables', 'Nuts/grains/beans')
    Group By mealComponents
)
";
*/

$query = "
SELECT SUM(NumberOfUnits) AS totalUnits, CASE SubCategory
    WHEN 'Meat/seafood' THEN 'Meat/seafood/Dairy/eggs'
    WHEN 'Dairy/eggs' THEN 'Meat/seafood/Dairy/eggs'
    WHEN 'Vegetables' THEN 'Vegetables'
    WHEN 'Nuts/grains/beans' THEN 'Nuts/grains/beans'
    ELSE 'Other'
    END AS mealComponents
From Item
WHERE SubCategory IN ('Meat/seafood','Dairy/eggs', 'Vegetables', 'Nuts/grains/beans')
Group By mealComponents
ORDER BY totalUnits ASC
LIMIT 1
";

$result = $conn->query($query);
?>

<?php 

if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
    echo "No report available.";
}

if ($result->num_rows > 0) {

echo '<table width=100% >';
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . "The most needed food type is : " . $row['mealComponents'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "No most needed food type.";
}

echo "</table>";

$conn->close();
?>

<br><br>
<form action="http://localhost:8888/web-reports"><input type="submit" value="Back" /></form>

</body>
</html>
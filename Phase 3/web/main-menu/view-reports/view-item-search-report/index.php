<?php
// Start the session

session_start();
?>
<!DOCTYPE html>
<head>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/b-1.2.4/r-2.1.1/se-1.2.0/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/b-1.2.4/r-2.1.1/se-1.2.0/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "server_processing.php",
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( this.value ).draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            } );
        } );


    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "server_processing1.php",
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( this.value ).draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            } );
        } );


    </script>
</head>
<SCRIPT language=JavaScript>
    function reload(form)
    {
        var val=form.dropdownitemss.options[form.dropdownitemss.options.selectedIndex].value;
        self.location='index.php?dropdownitemss=' + val ;
    }
    function reload2(form)
    {
        var val2=form.dropdownitemsremove.options[form.dropdownitemsremove.options.selectedIndex].value;
        self.location='index.php?dropdownitemsremove=' + val2 ;
    }

</script>

<?Php

@$dropdownitemss =$_GET['dropdownitemss']; // Use this line or below line if register_global is off
if(strlen($dropdownitemss) > 0 and !is_numeric($dropdownitemss)){ // to check if $cat is numeric data or not.
    echo "Data Error";
    exit;
}
@$dropdownitemsremove =$_GET['dropdownitemsremove']; // Use this line or below line if register_global is off
if(strlen($dropdownitemsremove) > 0 and !is_numeric($dropdownitemsremove)) { // to check if $cat is numeric data or not.
    echo "Data Error";
    exit;
}



$username = $_SESSION['username'];
$pdo = new PDO("mysql:host=127.0.0.1;dbname=acacs;port=8889", 'root', 'root');

$sql = "SELECT ItemID
FROM Item";
$stmt = $pdo->prepare($sql);
//Execute the statement.
$stmt->execute();
//Retrieve the rows using fetchAll.
$users = $stmt->fetchAll();

if(isset($dropdownitemss) and strlen($dropdownitemss) > 0){
    $sql2="SELECT SUM(DISTINCT (NumberOfUnits))
	FROM Item WHERE ItemID =  " . $dropdownitemss;
}else{$sql2="SELECT SUM(DISTINCT (NumberOfUnits))
	FROM Item"; }

echo "<h4> Select the ItemID along with the number of units you want to request.</h4>";
echo "<h4> Note: If you are associated with a foodbank, you will receive an error if you try to request an item owned by your foodbank.</h4>";
echo "<form method=post name=f1 action='dd-check.php'>";

echo "<select name='dropdownitemss' onchange=\"reload(this.form)\"><option value=''>Select ItemID to Request </option>";
foreach ($users as $user) {
    if($user['ItemID']==@$dropdownitemss){echo "<option selected value='$user[ItemID]'>$user[ItemID]</option>"."<BR>";}
    else{echo  "<option value='$user[ItemID]'>$user[ItemID]</option>";}
}
echo "</select>";


if(isset($dropdownitemss) and strlen($dropdownitemss) > 0) {
    echo "<p>";
    echo "ItemID: " . $dropdownitemss . " Is Currently Selected";
    echo "</p>";
}


$stmt2 = $pdo->prepare($sql2);
//Execute the statement.
$stmt2->execute();
//Retrieve the rows using fetchAll.
$users2 = $stmt2->fetchColumn();
#$var = var_dump($users5);
$range = range(1, $users2);



echo "</select>";
//////////////////  This will end the first drop down list ///////////

//////////        Starting of second drop downlist /////////
echo "<select name='subcat'><option value=''>Select Number of Units to Request</option>";
foreach ($range as $numberofitems) {
    echo  "<option value='$numberofitems'>$numberofitems Items</option>";
}
echo "</select>";


//////////////////  This will end the second drop down list ///////////
//// Add your other form fields as needed here/////
echo "<input type=submit value=Submit>";
echo "</form>";
?>
<br><br>
<a href=index.php>Reset and start again</a>
<br><br>



<body>



<table id="example" class="display" cellspacing="0" width="100%">

    <thead>
    <tr>
        <th>Item ID</th>
        <th>Service ID</th>
        <th>Item Name</th>
        <th>Number Of Units</th>
        <th>Expiration Date</th>
        <th>Storage Type</th>
        <th>Category</th>
        <th>SubCategory</th>
        <th>Facility Name</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Item ID</th>
        <th>Service ID</th>
        <th>Item Name</th>
        <th>Number Of Units</th>
        <th>Expiration Date</th>
        <th>Storage Type</th>
        <th>Category</th>
        <th>SubCategory</th>
        <th>Facility Name</th>

    </tr>
    </tfoot>
</table>

<h4> If you are associated with a foodbank the items you can reduce will appear below, if you are not associated with a foodbank, the message: "No matching records found" will show. </h4>
<table id="example1" class="display" cellspacing="0" width="100%">

    <thead>
    <tr>
        <th>Item ID</th>
        <th>Service ID</th>
        <th>Item Name</th>
        <th>Number Of Units</th>
        <th>Expiration Date</th>
        <th>Storage Type</th>
        <th>Category</th>
        <th>SubCategory</th>
        <th>Facility Name</th>
        <th>Username</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Item ID</th>
        <th>Service ID</th>
        <th>Item Name</th>
        <th>Number Of Units</th>
        <th>Expiration Date</th>
        <th>Storage Type</th>
        <th>Category</th>
        <th>SubCategory</th>
        <th>Facility Name</th>
        <th>Username</th>

    </tr>
    </tfoot>
</table>

</body>
<?php
$sql = "SELECT Item.ItemID FROM Item INNER JOIN FoodBank ON FoodBank.ServiceID = Item.ServiceID INNER JOIN 
User ON FoodBank.SiteID = User.SiteID WHERE User.Username = \"$username\"";
$stmt = $pdo->prepare($sql);
//Execute the statement.
$stmt->execute();
//Retrieve the rows using fetchAll.
$usersremove = $stmt->fetchAll();

if(isset($dropdownitemsremove) and strlen($dropdownitemsremove) > 0){
$sql2="SELECT SUM(DISTINCT (NumberOfUnits))
FROM Item WHERE ItemID =  " . $dropdownitemsremove;
}else{$sql2="SELECT SUM(DISTINCT (NumberOfUnits))
FROM Item"; }

echo "<h4> Select the ItemID along with the number you want to reduce it to. If you set an Item to 0 it will be removed. <h4>";
echo "<form method=post name=f2 action='dd-check2.php'>";

    echo "<select name='dropdownitemsremove' onchange=\"reload2(this.form)\"><option value=''>Select ItemID to Reduce</option>";
        foreach ($usersremove as $user) {
        if($user['ItemID']==@$dropdownitemsremove){echo "<option selected value='$user[ItemID]'>$user[ItemID]</option>"."<BR>";}
        else{echo  "<option value='$user[ItemID]'>$user[ItemID]</option>";}
        }
        echo "</select>";



$stmt2 = $pdo->prepare($sql2);
//Execute the statement.
$stmt2->execute();
//Retrieve the rows using fetchAll.
$users2 = $stmt2->fetchColumn();
#$var = var_dump($users5);
$range = range(0, $users2);


echo "</select>";
//////////////////  This will end the first drop down list ///////////

//////////        Starting of second drop downlist /////////
echo "<select name='sub'><option value=''>Select Number Of Units to Reduce</option>";
    foreach ($range as $numberofitems) {
    echo  "<option value='$numberofitems'>$numberofitems Items</option>";
    }
    echo "</select>";
echo "<input type=submit value=Submit>";
echo "</form>";
?>
<br><br>
<a href=index.php>Reset and start again</a>
<br><br>

<a href=/main-menu/view-reports/index.php>Back</a>


</html>
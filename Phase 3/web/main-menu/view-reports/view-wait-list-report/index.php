<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

?>
<!DOCTYPE html>
<head>
    <title>Wait List Report</title>

    <h1> Wait List Report </h1>

    <link href="../style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
    <style>
        ul {
            padding:0px;
            margin: 0px;
        }
        #response {
            padding:10px;
            background-color:#9F9;
            border:2px solid #396;
            margin-bottom:20px;
        }
        #list li {
            margin: 0 0 3px;
            padding:8px;
            background-color:#333;
            color:#fff;
            list-style: none;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            function slideout(){
                setTimeout(function(){
                    $("#response").slideUp("slow", function () {
                    });

                }, 2000);}

            $("#response").hide();
            $(function() {
                $("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {

                    var order = $(this).sortable("serialize") + '&update=update';
                    $.post("updateList.php", order, function(theResponse){
                        $("#response").html(theResponse);
                        $("#response").slideDown('slow');
                        slideout();
                    });
                }
                });
            });

        });
    </script>
</head>
<body>

<div id="container">
    <div id="list">

        <div id="response"> </div>
        <ul>
            <?php
            $conn = getConn();

            if (!$conn) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            $SiteID = $_SESSION['siteid'];
            #$ServiceID = $_SESSION['serviceid'];
            $sql = "SELECT ClientID FROM WaitlistEntry JOIN 
            Shelter on WaitlistEntry.ServiceID = Shelter.ServiceID WHERE Shelter.SiteID = $SiteID";

            $result = $conn->query($sql);
            if ($result->fetch_row()[0] > 0) {
                echo "<h3> Instructions: Drag and drop client to move them up or down the wait list. </h3>";
                echo "<h3> After reordering click \"Submit Waitlist Change\" button to view changes. </h3>";

            $query  = "SELECT Client.FirstName, Client.LastName, Client.IDNumber,Client.IDDescription, Client.Phone, WaitlistEntry.OrderIndex, WaitlistEntry.ClientID 
                    FROM WaitlistEntry, Client, Shelter
                    WHERE WaitlistEntry.ClientID = Client.ClientID AND Shelter.SiteID = $SiteID AND WaitlistEntry.ServiceID = Shelter.ServiceID
                    ORDER BY OrderIndex ASC";
            $result = $conn->query($query);
            while($row = $result->fetch_assoc())
            {
                $ClientID = stripslashes($row['ClientID']);
                $FirstName = stripslashes($row['FirstName']);
                $LastName = stripslashes($row['LastName']);
                $IDDescription = stripslashes($row['IDDescription']);
                $Phone = stripslashes($row['Phone']);
                $Rank = stripslashes($row['OrderIndex']);

                ?>
                <li id="arrayorder_<?php echo $ClientID ?>"><?php echo "Client ID" . ": " . $ClientID?>
                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Name: " . $FirstName . " " . $LastName; ?>
                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "ID Description: " . $IDDescription; ?>
                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Contact Phone Number: " . $Phone; ?>
                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Rank: " . $Rank; ?>
                    <div class="clear"></div>
                </li>

            <?php }
                echo "<form method=\"POST\">";
                echo  "<input type=\"submit\" name=\"submit2\" value=\"Submit and Save Waitlist Change\" />";
                echo "</form>";
                $conn = getConn();
                $sql = "SELECT ClientID FROM WaitlistEntry";

                $result = $conn->query($sql);

                if ($result->fetch_row()[0] > 0) {


                    echo "<h2> Delete Client from Waitlist</h2>";
                    echo "<h3> Enter one ClientID you want deleted at a time.</h3>";
                    echo "<form id=\"myform\" action=\"delete_waitlist_sql.php\" method=\"post\">";
                    echo "ClientID<br> <input type=\"text\" name=\"clientID\"><br><br>";

                    echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";
                }
            }else{
                echo "<h2>Waitlist is EMPTY!</h2>";
            } ?>
        </ul>
    </div>
</div>



<br>
<br>
<a href=/main-menu/view-reports/index.php>Back</a>
<br>
<br>
</body>


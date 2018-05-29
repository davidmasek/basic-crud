<?php
// redirect on missing value; invalid value results in empty table
if(!isset($_GET["code"]) || empty(trim($_GET["code"]))){
    header("location: error.php");
    exit();
}

function echoResults() {
    require_once 'config.php';
    
    $sql = "SELECT Id, Name, District, Population FROM city WHERE CountryCode = :code";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':code', $_GET["code"]);
    
    try {
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            echo '<td colspan="4">No cities found.</td>';
        }
        while ($row = $stmt->fetch()) {
            echo '<tr>';
            echo '<td>'.$row['Name'].'</td>';
            echo '<td>'.$row['District'].'</td>';
            echo '<td class="number">'.$row['Population'].'</td>';
            echo '<td><a href="delete.php?id=';
            echo $row['Id'];
            echo '" title="Delete Country" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a></td>';
            echo '</tr>';
        }
    } catch (Exception $e) {
        echo "Something went wrong, please try again later.";
    } finally {
        unset($stmt);
        unset($pdo);
    }
}
?>                             
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./static/index.css">
    <script type="text/javascript" src="./tooltip.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Cities</h1>
                    </div>
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>District</th>
                                <th>Population</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echoResults() ?>
                        </tbody>
                    </table>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
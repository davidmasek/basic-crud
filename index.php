<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>World - CRUD Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="./static/index.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script type="text/javascript" src="./tooltip.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h1 class="pull-left">Countries</h1>
                        <a href="create.php" class="btn btn-success pull-right">Add New City</a>
                    </div>
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Continent</th>
                                <th>Population</th>
                                <th>GNP</th>
                                <th>Cities</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    require_once 'config.php';
                    
                    $sql = "SELECT * FROM country";
                    try{
                        $result = $pdo->query($sql);
                        
                        while($row = $result->fetch()){
                            echo "<tr>";
                                echo "<td>" . $row['Code'] . "</td>";
                                echo "<td>" . $row['Name'] . "</td>";
                                echo "<td>" . $row['Continent'] . "</td>";
                                echo "<td class='number'>" . $row['Population'] . "</td>";
                                echo "<td class='number'>" . $row['GNP'] . "</td>";
                                echo "<td>";
                                    echo "<a href='read.php?code=". $row['Code'] ."' title='View Cities' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    } catch (Exception $e) {
                        echo "Something went wrong, please try again later.";
                    } finally {
                        // close connection
                        unset($pdo);
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
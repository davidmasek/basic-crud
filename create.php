<?php
require_once 'config.php';
 
$name = $code = $district = $population = "";
$name_err = $code_err = $district_err = $population_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } else{
        $name = $input_name;
    }

    // selected via <select>
    $input_code = $_POST["code"];
    $sql = "SELECT Count(*) FROM country WHERE Code=:code";
    $stmt = $pdo->prepare($sql);
    // s = string
    $stmt->bindParam(":code", $input_code);
    // execute the prepared statement
    try {
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result["Count(*)"] === "1") {
            $code = $input_code;
        } else {
            $code_err = "Invalid country code.";
        }
    } catch (Exception $e) {
        echo "ERROR: Could not execute $sql. " . $e;
    }
    // close statement
    unset($stmt);

    $input_district = trim($_POST["district"]);
    if(empty($input_district)){
        $district_err = 'Please enter an address.';     
    } else{
        $district = $input_district;
    }
    
    $input_population = trim($_POST["population"]);
    if(empty($input_population)){
        $population_err = "Please enter population value.";     
    } elseif(!ctype_digit($input_population)){
        $population_err = 'Please enter a positive integer.';
    } else{
        $population = $input_population;
    }
    
    // add to db
    if(empty($name_err) && empty($code_err) && empty($district_err) && empty($population_err)){
        // prepare statement
        $sql = "INSERT INTO city (Name, CountryCode, District, Population) VALUES (:name, :code, :district, :population)";
 
        $stmt = $pdo->prepare($sql);
        // s = string
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':population', $population);
        
        // execute the prepared statement
        try {
            $stmt->execute();
            // success; redirect
            header("location: index.php");
            exit();
        } catch (Excpetion $e) {
            echo "Something went wrong. Please try again later.";
        }
        
         
        // close statement
        unset($stmt);
    }
    
    // db connection closed later
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add City</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./static/create.css">
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Add City</h1>
                    </div>
                    <p>Fill this form and submit to add a city to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
                            <label for="code">Country Code</label>
                            <select name="code" class="form-control">
                                <?php
                                    $sql = "SELECT DISTINCT Code, Name FROM country";
                                    try {
                                        $result = $pdo->query($sql);
                                        while($row = $result->fetch()){
                                            if ($row['Code'] === $code) {
                                                echo "<option value='".$row['Code']."' selected='selected'>" . $row['Code'] . " (" . $row['Name'] . ")</option>";
                                            } else {
                                                echo "<option value='".$row['Code']."'>" . $row['Code'] . " (" . $row['Name'] . ")</option>";
                                            }
                                        }
                                    } catch (Exception $e){
                                        echo "ERROR: Could not execute $sql. " . $e;
                                    }

                                // close connection
                                unset($pdo);
                                ?>
                            </select>
                            <span class="help-block"><?php echo $code_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($district_err)) ? 'has-error' : ''; ?>">
                            <label for="district">District</label>
                            <input type="text" name="district" class="form-control" value="<?php echo htmlspecialchars($district); ?>">
                            <span class="help-block"><?php echo $district_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($population_err)) ? 'has-error' : ''; ?>">
                            <label for="population">Population</label>
                            <input type="number" name="population" class="form-control" value="<?php echo htmlspecialchars($population); ?>">
                            <span class="help-block"><?php echo $population_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php
// delete
if(isset($_POST["id"]) && !empty($_POST["id"])){

    require_once 'config.php';
    
    $sql = "DELETE FROM city WHERE Id = :id";
    
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $_POST["id"]);
    
    try {
        $stmt->execute();
        // success, redirect
        header("location: index.php");
        exit();
    } catch (Exception $e) {
        echo 'Something went wrong, please try again later.';
    } finally {
        unset($stmt);
        unset($pdo);
    }
} else{
    // id set?
    if(!isset($_GET["id"]) || empty(trim($_GET["id"]))){
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./static/create.css">
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this record?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">Cancel</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
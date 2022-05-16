<?php
require_once './php/config/Logic.php';

$Logic = new Logic();
$queryString = "SELECT 
    product_id, category_id, product_name, quantity 

    FROM products
    ORDER BY product_name ASC
            
    ";
print_r($_SESSION);

$categoryQuery = "SELECT 
    category_id, category_name 

    FROM categories
    ORDER BY category_name ASC
            
    ";

if (!$_SESSION["isLogged"] || !$_SESSION["user"]) {
    echo "<script> alert('Please Login') </script>";
    sleep(2);
    header("Location: http://localhost/WarehouseManagement/index.php");
    
}
$user = $_SESSION["user"];

$products = $DB->Query($queryString);
$categories = $DB->Query($categoryQuery);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel ="stylesheet" href ="css/bootstrap.min.css"/>
        <script src="js/bootstrap.bundle.min.js"></script>

        <title>Document</title>
    </head>
    <body>

        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Warehouse Management</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- 
                           
                           
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link disabled">Disabled</a>
                            </li>
                        
                        
                        -->
                        </ul>
                        <div class="d-flex">

                            
                            <a href="addProduct.php"> 
                            <button class="btn btn-sm btn-outline-success me-2"  type="button">Add Product</button>
                            </a>
                            <a href="addCategory.php"> 
                            <button class="btn btn-sm btn-outline-success me-2"  type="button">Add Category</button>
                            </a>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $user->name; ?>
                                </a>
                                <ul class="dropdown-menu pull-right" role="menu" position="relative" aria-labelledby="navbarDropdown">
                                    <form action = 'editProfile.php' method = "get" >
                                    <li>
                                        <input class="dropdown-item" type="hidden" name ="profile-email" value ="<?php echo $user->email?>"/>
                                        <button class="dropdown-item" type='submit' name='edit-profile'>Edit</button>
                                    </li>
                                    </form>
                                    <li><hr class="dropdown-divider"></li>
                                    <form method="get"><li><input class="dropdown-item" type ="submit" name = "logout" value="Log out"/></li></form>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </nav>
            <div class="row justify-content-around">
                <div class="col-sm-6">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($products as $item) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $item["product_id"]; ?></th>
                                    <td><?php echo $item["product_name"]; ?></td>
                                    <td><?php
                                        foreach ($categories as $value) {
                                            if ($value["category_id"] === $item["category_id"]) {
                                                echo $value["category_name"];
                                            }
                                        }
                                        ?></td>
                                    <td><?php echo $item["quantity"]; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" type="button">Edit</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" type="button">Delete</button>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                        ?>
                    </table>

                </div>


                <div class="col-sm-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Name</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($categories as $item) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $item["category_id"]; ?></th>
                                    <td><?php echo $item["category_name"]; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" type="button">Edit</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" type="button">Delete</button>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                        ?>
                    </table>
                </div>

            </div>


        </div>

    </body>
</html>

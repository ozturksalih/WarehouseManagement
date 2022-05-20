<?php
require_once './php/config/Logic.php';

$Logic = new Logic();

if (!isset($_SESSION["isLogged"]) || !$_SESSION["isLogged"] || !$_SESSION["user"]) {
    header("Location: http://localhost/WarehouseManagement/index.php");
}
$user = $_SESSION["user"];
$products= $Logic->getAllProducts();
$categories = $Logic ->getAllCategories();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel ="stylesheet" href ="css/bootstrap.min.css"/>
        <script src="js/bootstrap.bundle.min.js"></script>

        <title>Warehouse Table</title>
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

                            <form action="addProduct.php" method="get">
                                <a href="addProduct.php"> 
                                    <button type="submit" name='add-product' class="btn btn-sm btn-outline-success me-2"  type="button">Add Product</button>
                                </a>
                            </form>
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

                                            <button class="dropdown-item" type='submit' >Edit</button>
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

                                        <form action="editProduct.php" method="get">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>" />
                                            <button type="submit" class="btn btn-sm btn-outline-warning" name="edit-product">Edit</button>
                                        </form>

                                    </td>
                                    <td>
                                        <form action="warehouse_tables.php" method="get">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>" />
                                            <button type="submit" class="btn btn-sm btn-outline-danger" name="delete-product">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                        ?>
                    </table>

                </div>
                <div class="col-sm-2"></div>

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
                                        <form action="editCategory.php" method="get">
                                            <input type="hidden" name="category_id" value="<?php echo $item['category_id']; ?>" />
                                            <button type="submit" class="btn btn-sm btn-outline-warning" name="edit-category">Edit</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="warehouse_tables.php" method="get">
                                            <input type="hidden" name="category_id" value="<?php echo $item['category_id']; ?>" />
                                            <button type="submit" class="btn btn-sm btn-outline-danger" name="delete-category">Delete</button>
                                        </form>
                                       
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

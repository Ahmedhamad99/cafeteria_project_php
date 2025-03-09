<?php
    require_once("db_class.php");
    $connection=new db();
?>
<?php include("../nav_footer/header.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

    <link rel="stylesheet" href="./css/master.css">
    <title>Document</title>
</head>

<body>
<div style="margin-top:50px">

</div>

    <div class="bg-light min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row g-4">
                <!-- Left Section -->
                <div class="col-lg-7 col-md-12">
                    <p class="fs-4 mt-3 fw-bold text-warning-emphasis">Add to user</p>
                    <select class="user form-select mb-4 w-75 mx-auto">
                        <option selected disabled>Select User</option>
                        <?php
                        $stm=$connection->get_users("users","role = 'user'");
                        $data=$stm->fetchAll(PDO::FETCH_ASSOC);
                        if($data){
                            foreach($data as $user){
                                echo "<option value='{$user["id"]}' >{$user["username"]}</option>";
                            }
                        }
                    ?>
                    </select>
                    <hr>
                    <div class="container mt-3">
                        <div class="row overflow-auto p-3" style="max-height: 400px;">
                            <?php
                            $stm=$connection->get_all_data("products");
                            $data=$stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach($data as $product){
                                echo "<div class='col-md-4 col-sm-6 col-12 mb-3'>";
                                echo "<div product-id='{$product['id']}' product-name='{$product['name']}' product-price='{$product['price']}' 
                                class='product card shadow-sm border-0' style='cursor: pointer; transition: 0.3s;'>";

                                echo "<img src='../ahmed/images/{$product['image']}' class='card-img-top img-fluid rounded' 
                                style='height: 150px; object-fit: cover;'>";

                                echo "<div class='card-body p-2 text-center'>";
                                echo "<p class='text-warning-emphasis fw-medium'>{$product['name']}</p>";
                                echo "</div></div></div>";
                            }
                        ?>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-lg-5 col-md-12">
                    <form
                        class="h-100 d-flex flex-column justify-content-between bg-warning-subtle p-3 rounded shadow-sm">
                        <div class="selectedProduct p-2 bg-white rounded shadow-sm overflow-auto"
                            style="max-height: 200px; border: 1px solid #ddd;">
                        </div>

                        <div>
                            <label class="fw-bold text-secondary fs-6 mt-2" for="notes">Notes</label>
                            <textarea class="form-control" style="resize: none;" name="Notes" id="notes"></textarea>

                            <label class="fw-bold text-secondary fs-6 mt-2" for="room">Room</label>
                            <select class="form-select mb-3" id="room">
                                <option selected disabled>Select Room</option>
                                <?php
                            $stm=$connection->get_all_data("rooms");
                            $data=$stm->fetchAll(PDO::FETCH_ASSOC);
                            if($data){
                                foreach($data as $room){
                                    echo "<option value='{$room["room_number"]}' >{$room["room_number"]}</option>";
                                }
                            }
                            ?>
                            </select>
                            <hr>

                            <p class="total-price fs-4 fw-medium text-end text-secondary">
                                Price: <span class="fw-bold ms-2">00.0 EGP</span>
                            </p>

                            <button type="button" class="btn btn-success w-100 fw-bold" onclick="sendToSave()">
                                Confirm Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="./js/main.js"></script>
</body>

</html>

<?php include("../nav_footer/footer.php")?>
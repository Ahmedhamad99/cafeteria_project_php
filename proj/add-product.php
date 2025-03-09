<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <a href="./style.css"></a>
    <style>
       
        .btn-upload {
            display: inline-block;
            background-color: #d8cfc4;
            color: #fff;
            padding: 12px 20px; 
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-upload:hover {
            background-color:#f5e1a4;
            transform: scale(1.05);
        }

       
        #image:active + .btn-upload {
            background-color: #f1c27d;
            transform: scale(0.98);
        }
    </style>
</head>
<?php

include("../nav_footer/header.php")
?>

<body>
<section class="h-auto" style="background-color: #493628; color:#fff; padding: 80px 0; min-height: 500px; border-radius: 15px; display: flex; justify-content: center; align-items: center;">
        <div class="container py-5 h-100 ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-8 col-xl-6">
                    <div class="card rounded-3">

                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 text-center">Add Product </h3>

                            <form class="px-md-2" method="POST" action="dbproduct.php" enctype="multipart/form-data">

                               
                                <div class="form-outline mb-4">
                                    <input type="text" name="productname" id="productname" class="form-control" required />
                                    <label class="form-label" for="productname">product name </label>
                                </div>

                            
                                <div class="form-outline mb-4">
                                    <input type="text" name="price" id="price" class="form-control" required />
                                    <label class="form-label" for="price">Price</label>
                                </div>


                                <div class="form-outline mb-4">
                                    <input type="text" name="category" id="category" class="form-control" required />
                                    <label class="form-label" for="category">Category</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label btn-upload" for="image">Upload Image</label>
                                    <input type="file" name="image" id="image" style="display:none;" />
                                </div>

                                <button type="submit" class="btn btn-lg w-100" style="
                                    background-color: #493628; 
                                    color: #fff; 
                                    border: none; 
                                    transition: background-color 0.3s ease, transform 0.2s ease;"
                                    onmouseover="this.style.backgroundColor='#35271d'; this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.backgroundColor='#493628'; this.style.transform='scale(1)'"
                                    onmousedown="this.style.backgroundColor='#2a1f18'; this.style.transform='scale(0.98)'"
                                    onmouseup="this.style.backgroundColor='#35271d'; this.style.transform='scale(1.05)'"
                                >
                                    Save
                                </button>


                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- تضمين Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- تضمين MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>

</html>

<?php 
include("../nav_footer/footer.php")
?>
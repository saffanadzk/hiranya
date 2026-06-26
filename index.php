<?php 
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="assets/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="container-fluid bg-light sticky-top p-0">
        <div class="container-fluid bg-white sticky-top p-0 shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light py-2 px-4">
        <a href="index.php" class="navbar-brand bg-primary py-4 px-5 me-0">
                <h1 class="mb-0">
                    <i class="bi bi-palette"></i>Hiranya
                </h1>
            </a>
            <a href="index.php" class="navbar-brand me-5">
        </a>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="index.php" class="nav-item nav-link text-dark mx-2">AUCTIONS</a>
                <a href="#" class="nav-item nav-link text-dark mx-2">PRIVATE SALES</a>
                <a href="#" class="nav-item nav-link text-dark mx-2">ARTWORKS</a>
                <a href="#" class="nav-item nav-link text-dark mx-2">SERVICES</a>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <form class="d-flex me-4">
                <input class="form-control me-2" type="search" placeholder="Search by keyword" aria-label="Search" style="width: 150px; border: none; border-bottom: 1px solid #ccc; border-radius: 0;">
                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
            </form>

            <?php if(isset($_SESSION['login'])) : ?>
                <a href="logout.php" class="text-dark text-decoration-none fw-bold">
                    <i class="fa fa-user me-1"></i> LOGOUT
                </a>
            <?php else : ?>
                <a href="login.php" class="text-dark text-decoration-none fw-bold">
                    <i class="fa fa-user me-1"></i> SIGN IN
                </a>
            <?php endif; ?>
        </div>
    </nav>
</div>
            </div>
        </nav>
    </div>
    <div class="container-fluid p-0 hero-header bg-light mb-5">
        <div class="container p-0">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 hero-header-text py-5">
                    <div class="py-5 px-3 ps-lg-0">
                        <h1 class="font-dancing-script text-primary animated slideInLeft">Welcome to</h1>
                        <h1 class="display-1 mb-4 animated slideInLeft">Hiranya House</h1>
                        <p class="fs-5 text-dark mb-4 animated slideInLeft">Hiranya Art House Management System. Manage Gallery Data, Artist, and Collector Information.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="owl-carousel header-carousel animated fadeIn">
                        <img class="img-fluid" src="assets/img/hero-slider-1.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">
                    <h1 class="font-dancing-script text-primary">Data Kelola</h1>
                    <h1 class="mb-5">Artworks List</h1>
                    
                    <a href="add.php" class="btn btn-primary mb-4"><i class="fas fa-plus me-2"></i>Add New Data</a>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Artwork Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $query = mysqli_query($conn, "SELECT * FROM artworks");
                                while($row = mysqli_fetch_array($query)) {
                                    echo "<tr>";
                                    echo "<td>".$no++."</td>";
                                    echo "<td>".$row['judul_karya']."</td>";
                                    echo "<td>".$row['deskripsi']."</td>";
                                    echo "<td>
                                            <a href='edit.php?id=".$row['id']."' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='delete.php?id=".$row['id']."' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                                    <td>Watercolor Painting</td>
                                    <td>
                                        <a href="edit.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete.php?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-12 text-center">
                    <p>&copy; Hiranya Art House. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/lightbox/js/lightbox.min.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>
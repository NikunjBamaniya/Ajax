<!-- <?php
        include("connection.php");
        ?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #home,
        #gallery,
        #about-us {
            display: none;
        }
    </style>
    <script>

    </script>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
            <div class="container-fluid">
                <img src="./image/chpl.png" alt="" style="height: 100px; width: 120px;">
                <div class="collapse navbar-collapse justify-content-end bg-dark text-white" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gallery">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about-us">About Us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Our_Product</a>
                            <ul class="dropdown-menu" id="product-list">
                                <li><a class="dropdown-item" href="#">My-Co</a></li>
                                <li><a class="dropdown-item" href="#">My Association</a></li>
                                <li><a class="dropdown-item" href="#">Smart Society</a></li>
                                <li><a class="dropdown-item" href="#">CRM</a></li>
                                <li><a class="dropdown-item" href="#">Land MIS</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



        <!-- HOME CONTENT -->
        <div class="container pt-5 pb-5 text-danger" id="home">
            <h2 id="home-heading"></h2>
            <h1 id="home-subheading"></h1>
            <p id="home-description"></p>
            <button id="contact-button" type="button" class="btn btn-primary">Contact Us</button>
        </div>


        <!-- GALLERY CONTENT -->

        <div id="gallery" class="carousel slide pt-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                // SQL query to select image data
                $query = "SELECT img_id, img_path, img_title, img_description FROM images";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    $indicatorIndex = 0;
                    while ($row = $result->fetch_assoc()) {

                        $img_path = $row['img_path'];
                        $img_title = $row['img_title'];
                        $img_description = $row['img_description'];

                        echo "<button type='button' data-bs-target='#gallery' data-bs-slide-to='{$indicatorIndex}' class='" . ($indicatorIndex == 0 ? 'active' : '') . "' aria-current='true' aria-label='Slide " . ($indicatorIndex + 1) . "'></button>";

                        $indicatorIndex++;
                    }
                }
                ?>
            </div>

            <div class="carousel-inner">
                <?php
                // Reset query to get the images again for carousel items
                $result = $conn->query($query);
                $itemIndex = 0; // To track the first item
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $img_path = $row['img_path'];
                        $img_title = $row['img_title'];
                        $img_description = $row['img_description'];
                        echo "
            <div class='carousel-item " . ($itemIndex == 0 ? 'active' : '') . "'>
                <img src='./image/{$img_path}' class='d-block w-100' alt='{$img_title}' style='height:400px; object-fit:cover;'>
                <div class='carousel-caption d-md-block'>
                    <h5>{$img_title}</h5>
                    <p>{$img_description}</p>
                </div>
            </div>";
                        $itemIndex++;
                    }
                } else {
                    echo "<p>No images found!</p>";
                }
                ?>
            </div>


            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#gallery" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#gallery" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


        <!-- ---------------- ABOUT US -------------- -->



        <!-- ABOUT US CONTENT -->
        <div class="container mt-3" id="about-us">
            <div class="card" style="width:400px">
                <div class="card-body">
                    <h4 id="title" class="card-title"></h4>
                    <p id="text" class="card-text"></p>
                    <a href="https://google.com" class="btn btn-primary disabled">See More</a>
                </div>
                <img id="img" class="card-img-bottom" src="" alt="Card image" style="width:100%">
            </div>
        </div>




    </div>

    <script>
        $(document).ready(function() {

            $('#home').show();

            $("a[href='#home']").click(function(e) {
                e.preventDefault();
                $('#home').show();
                $('#gallery').hide();
                $('#about-us').hide();
            });

            $("a[href='#gallery']").click(function(e) {
                e.preventDefault();
                $('#home').hide();
                $('#gallery').show();
                $('#about-us').hide();
                loadGallery();
            });

            $("a[href='#about-us']").click(function(e) {
                e.preventDefault();
                $('#home').hide();
                $('#gallery').hide();
                $('#about-us').show();

            });
            HomeContent();
            AboutUsContent();


            function HomeContent() {
                console.log("Fetching home content...");

                $.ajax({
                    url: 'fetch_home_content.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        // console.log(response[0].heading);

                        if (!response.error) {
                            $("#home-heading").text(response[0].heading);
                            $("#home-subheading").html(response[0].subheading);
                            $("#home-description").html(response[0].description);
                            $("#contact-button").text(response[0].contact_button_text);
                        } else {
                            console.log("Error: " + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + ", " + error);
                    }
                });
            }


            function AboutUsContent() {
                console.log("Fetching About Us data...");

                // Make sure jQuery is loaded correctly
                if (typeof $ === 'undefined') {
                    console.log('jQuery is not loaded!');
                    return;
                }

                $.ajax({
                    url: 'fetch_about_us.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('About Us Data:', response);
                        console.log(response[0].card_title);

                        if (response.error) {
                            console.log("Error: " + response.error);
                            return;
                        }

                        $("#title").text(response[0].card_title);
                        $("#text").text(response[0].card_text);
                        $("#img").attr("src", "./image/" + response[0].photo);
                        // $("a.btn").attr("href", response[0].profile_url); 
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + ", " + error);
                    }
                });
            }


            function Gallery() {
                $.ajax({
                    url: 'fetch_image.php',
                    type: 'GET',
                    success: function(response) {
                        // console.log(response);
                        var images = JSON.parse(response);
                        var carouselIndicators = '';
                        var carouselItems = '';

                        images.forEach(function(image, index) {
                            carouselIndicators += `<button type="button" data-bs-target="#gallery" data-bs-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></button>`;
                            carouselItems += `
                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="./image/+${images.img_path}" alt="${images.img_title}" class="d-block w-100">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>${images.img_title}</h5>
                                        <p>${images.img_description}</p>
                                    </div>
                                </div>
                            `;
                        });

                        $('.carousel-indicators').html(carouselIndicators);
                        $('.carousel-inner').html(carouselItems);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + ", " + error);
                    }
                });
            }

        });
    </script>


</body>

</html>
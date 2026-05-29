<?php include '../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Optimized Responsive Slider</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Slick Slider -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Titillium+Web:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <div class="container py-4">
        <!-- BUTTONS -->
        <div class="mb-4 d-flex gap-2">
            <a class="btn btn-primary" href="../index.php">
                Add Slide
            </a>

            <a class="btn btn-primary" href="slide_list.php">
                Show Slide List
            </a>

        </div>
        <!-- ================= DESKTOP ================= -->
        <div class="desktop-layout">
            <div class="slider-section">

                <div class="section-heading">
                    <h2>DelphianLogic in Action</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                </div>

                <div class="slider-wrapper">
                    <div class="row g-0 custom-slider-row">
                        <!-- LEFT -->
                        <div class="col-left">
                            <div class="nav flex-column nav-pills left-tabs">

                                <?php
                                $tabs = $conn->query("SELECT second_image, tab_name FROM sliders");
                                $first = true;

                                while ($tab = $tabs->fetch_assoc()) {
                                ?>

                                    <button
                                        class="nav-link <?= $first ? 'active' : '' ?>"
                                        data-bs-toggle="pill"
                                        data-bs-target="#<?= str_replace(' ', '_', strtolower($tab['tab_name'])) ?>">

                                        <img src="../assets/uploads/<?php echo $tab['second_image']; ?>" style="height: 42px;">
                                        <?= $tab['tab_name'] ?>

                                    </button>
                                <?php $first = false;
                                } ?>

                            </div>
                        </div>

                        <!-- CENTER -->
                        <div class="col-middle">
                            <div class="tab-content h-100">
                                <?php
                                $tabs2 = $conn->query("SELECT DISTINCT tab_name FROM sliders");
                                $first2 = true;

                                while ($tab2 = $tabs2->fetch_assoc()) {

                                    $tabName = $tab2['tab_name'];
                                ?>

                                    <div
                                        class="tab-pane fade h-100 <?= $first2 ? 'show active' : '' ?>"
                                        id="<?= str_replace(' ', '_', strtolower($tabName)) ?>">

                                        <div class="desktop-slider center-content">

                                            <?php
                                            $slides = $conn->query("SELECT * FROM sliders WHERE tab_name='$tabName'");

                                            while ($slide = $slides->fetch_assoc()) {

                                                $imagePath = '../assets/uploads/' . $slide['image'];
                                            ?>

                                                <div
                                                    class="slide-item"
                                                    data-image="<?= $imagePath ?>">

                                                    <span class="slide-tag">
                                                        DIGITAL LEARNING INFRASTRUCTURE
                                                    </span>

                                                    <h3><?= $slide['title'] ?></h3>

                                                    <p><?= $slide['description'] ?></p>

                                                    <a href="#" class="learn-btn">
                                                        Learn More →
                                                    </a>
                                                </div>

                                            <?php } ?>

                                        </div>
                                    </div>

                                <?php $first2 = false;
                                } ?>

                            </div>
                        </div>

                        <!-- RIGHT -->
                        <div class="col-right">
                            <div class="image-column">
                                <img
                                    id="desktop-preview"
                                    src=""
                                    class="preview-image">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ================= MOBILE ================= -->

        <div class="mobile-layout">
            <div class="accordion" id="mobileAccordion">

                <?php

                $mobileTabs = $conn->query("SELECT DISTINCT tab_name FROM sliders");

                $firstMobile = true;
                $count = 0;

                while ($mobileTab = $mobileTabs->fetch_assoc()) {

                    $mobileTabName = $mobileTab['tab_name'];

                ?>

                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">

                            <button
                                class="accordion-button <?= $firstMobile ? '' : 'collapsed' ?>"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $count ?>">

                                <?= $mobileTabName ?>

                            </button>

                        </h2>
                        <div
                            id="collapse<?= $count ?>"
                            class="accordion-collapse collapse <?= $firstMobile ? 'show' : '' ?>"
                            data-bs-parent="#mobileAccordion">

                            <div class="accordion-body">
                                <div class="mobile-slider">

                                    <?php

                                    $mobileSlides = $conn->query("SELECT * FROM sliders WHERE tab_name='$mobileTabName'");

                                    while ($mobileSlide = $mobileSlides->fetch_assoc()) {

                                        $mobileImage = '../assets/uploads/' . $mobileSlide['image'];

                                    ?>

                                        <div>
                                            <div
                                                class="mobile-slide"
                                                style="background-image:url('<?= $mobileImage ?>')">

                                                <div class="mobile-overlay">
                                                    <h4><?= $mobileSlide['title'] ?></h4>
                                                    <p><?= $mobileSlide['description'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php

                    $firstMobile = false;
                    $count++;
                } ?>

            </div>
        </div>
    </div>
    <!-- JS -->

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>
</html>
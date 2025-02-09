<?php
include 'config.php';
$query = new Database();
$banners = $query->select('banners');
$features = $query->select('features');
$aboutData = $query->select('about');
$serviceItems  = $query->select('about_ul_items');
$services = $query->select('services');

$aboutItems = [];
foreach ($aboutData as $about) {
  $aboutItems[$about['id']] = [
    'title' => $about['title'],
    'p1' => $about['p1'],
    'p2' => $about['p2'],
    'image' => $about['image'],
    'list_items' => []
  ];
}

foreach ($serviceItems as $item) {
  $aboutItems[$item['about_id']]['list_items'][] = $item['list_item'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home Page</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <?php include 'includes/header.php' ?>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <?php foreach ($banners as $banner): ?>
          <div class="carousel-item <?php echo ($banner === reset($banners)) ? 'active' : ''; ?>">
            <img src="assets/img/banners/<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
            <div class="carousel-container">
              <h2><?php echo '<span>' . explode(' ', $banner['title'])[0] . '</span> ' . implode(' ', array_slice(explode(' ', $banner['title']), 1)); ?></h2>
              <p><?php echo $banner['description']; ?></p>
              <a href="<?php echo $banner['button_link']; ?>" class="btn-get-started"><?php echo $banner['button_text']; ?></a>
            </div>
          </div><!-- End of Carousel Item -->

        <?php endforeach; ?>

        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

      </div>

      <div class="featured container">
        <div class="row gy-4">
          <?php
          $i = 0;
          foreach ($features as $feature):
            $delay = $i * 100;
          ?>
            <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
              <div class="featured-item position-relative">
                <div class="icon"><i class="<?php echo $feature['icon']; ?> icon"></i></div>
                <h4><a href="" class="stretched-link"><?php echo $feature['title']; ?></a></h4>
                <p><?php echo $feature['description']; ?></p>
              </div>
            </div>
          <?php
            $i++;
          endforeach;
          ?>
        </div>
      </div>

    </section><!-- End of Hero Section -->

    <!-- About Section -->
    <section id="about" class="section about">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <?php foreach ($aboutItems as $about): ?>
            <div class="col-lg-6 order-1 order-lg-2">
              <?php if (!empty($about['image'])): ?>
                <img src="<?= htmlspecialchars($about['image']) ?>" class="img-fluid" alt="About Us">
              <?php endif; ?>
            </div>
            <div class="col-lg-6 order-2 order-lg-1 content">
              <h3><?= htmlspecialchars($about['title']) ?></h3>
              <p class="fst-italic"><?= htmlspecialchars($about['p1']) ?></p>
              <h4><?= htmlspecialchars($about['title']) ?></h4>
              <ul>
                <?php foreach ($about['list_items'] as $item): ?>
                  <li><i class="bi bi-check2-all"></i> <?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
              </ul>
              <p><?= htmlspecialchars($about['p2']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section><!-- End of About Section -->

    <!-- Services Section -->
    <section id="services" class="services section">
      <div class="container">
        <div class="row gy-4">
          <?php foreach ($services as $service): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($service['id'] - 1) * 100; ?>">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="<?= htmlspecialchars($service['icon']) ?>"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3><?= htmlspecialchars($service['title']) ?></h3>
                </a>
                <p><?= htmlspecialchars($service['description']) ?></p>
              </div>
            </div><!-- End of Service Item -->
          <?php endforeach; ?>
        </div>
      </div>
    </section><!-- End of Services Section -->

  </main>

  <?php include 'includes/footer.php' ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
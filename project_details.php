<?php
include './config.php';
$query = new Database();

$id = $_GET['id'] ?? 1;
$project = $query->select('projects', '*', 'id = ?', [$id], 'i');

if ($project) {
  $project = $project[0];
  $category = $query->select('category', '*', 'id = ?', [$project['category_id']], 'i')[0]['category_name'] ?? 'Unknown';
  $project_images = $query->select('project_images', '*', 'project_id = ?', [$id], 'i');
  $project_images = !empty($project_images) ? array_column($project_images, 'image_url') : [];

  $title = $project['project_name'];
  $description = $project['description'];
  $keywords = 'web, development, project, IT, business, software, ' . $title;
  $image = !empty($project_images) ? "assets/img/projects/" . $project_images[0] : 'https://templates.uz/assets/img/iqbolshoh.jpg';
  $project_link = $project['link'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= htmlspecialchars($title) ?> - Templates.uz</title>
  <link href="favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Meta teglar -->
  <meta name="description" content="<?= htmlspecialchars($description) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
  <meta name="author" content="Templates.uz">
  <meta name="robots" content="index, follow">

  <!-- Open Graph (Ijtimoiy tarmoqlar uchun) -->
  <meta property="og:title" content="<?= htmlspecialchars($title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($description) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($image) ?>">
  <meta property="og:url" content="https://templates.uz/project.php?id=<?= $id ?>">
  <meta property="og:type" content="website">
</head>

<body class="portfolio-details-page">
  <?php include 'includes/header.php'; ?>

  <main class="main">
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="./">Home</a></li>
            <li class="current">Project Details</li>
          </ol>
        </nav>
        <h1><?= htmlspecialchars($title) ?></h1>
      </div>
    </div>

    <section id="portfolio-details" class="portfolio-details section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <?php if ($project): ?>
            <div class="col-lg-8">
              <div class="portfolio-details-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
                          {
                            "loop": true,
                            "speed": 600,
                            "autoplay": { "delay": 5000 },
                            "slidesPerView": "auto",
                            "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true }
                          }
                        </script>
                <div class="swiper-wrapper align-items-center">
                  <?php foreach ($project_images as $image): ?>
                    <div class="swiper-slide">
                      <img src="<?= htmlspecialchars("assets/img/projects/" . $image) ?>" alt="Project Image">
                    </div>
                  <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                <h3>Project Information</h3>
                <ul>
                  <li><strong>Category</strong>: <?= htmlspecialchars($category) ?></li>
                  <li><strong>Project Name</strong>: <?= htmlspecialchars($title) ?></li>
                  <li>
                    <strong>Link</strong>:
                    <a href="<?= htmlspecialchars($project_link) ?>" style="color: #007BFF; font-weight: 600;"
                      target="_blank">
                      <?= htmlspecialchars(str_replace(['https://', 'http://', 'www.'], '', $project_link)) ?>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                <h2>Project Description</h2>
                <p><?= htmlspecialchars($title) ?> – <?= htmlspecialchars($description) ?></p>
              </div>
            </div>
          <?php else: ?>
            <div class="col-12 project-not-found">
              <div>
                <h3>Project not found</h3>
                <p>The project you are looking for does not exist.</p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <?php include 'includes/footer.php'; ?>

  <!-- Scroll to top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
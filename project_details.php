<?php
include './config.php';
$query = new Database();

$id = $_GET['id'] ?? 1;

$project = $query->getById('projects', $id);

if ($project) {
  $category = isset($project['category_id']) ? $query->getById('category', $project['category_id'])['category_name'] : 'Unknown';
  $project_images = $query->executeQuery("SELECT image_url FROM project_images WHERE project_id = $id")->fetch_all(MYSQLI_ASSOC);
  $project_images = !empty($project_images) ? array_column($project_images, 'image_url') : [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Project Details</title>
  <link href="favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<style>
  .project-not-found {
    min-height: 30vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
  }

  .project-not-found h3 {
    font-size: 24px;
    color: #dc3545;
    margin-bottom: 10px;
  }

  .project-not-found p {
    font-size: 18px;
    color: #6c757d;
  }
</style>

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
        <h1>Project Details</h1>
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
                      <img src="assets/img/projects/<?php echo $image; ?>" alt="project Image">
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
                  <li><strong>Category</strong>: <?php echo $category; ?></li>
                  <li><strong>Project Name</strong>: <?php echo $project['project_name']; ?></li>
                  <li>
                    <strong>Link</strong>:
                    <a href="<?php echo $project['link']; ?>" style="color: #007BFF; font-weight: 600;" target="_blank">
                      <?php echo str_replace(['https://', 'http://', 'www.'], '', $project['link']); ?>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                <h2>Project Description</h2>
                <p><?php echo $project['project_name']; ?> – <?php echo $project['description']; ?></p>
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
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
<?php
include './config.php';
$query = new Database();

// Fetch categories, projects, and project images from the database
$categories = $query->select('category', '*');
$projects = $query->select('projects', '*', "1 ORDER BY id DESC;");

$project_images = $query->select('project_images', '*');

// Group projects by their category ID
$grouped_projects = [];
foreach ($projects as $project) {
  $grouped_projects[$project['category_id']][] = $project;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Projects - Templates.uz</title>

  <meta name="description"
    content="Check out our latest projects at Templates.uz. We specialize in web development, IT solutions, and custom software development.">
  <meta name="keywords"
    content="projects, templates.uz, portfolio, case studies, web development projects, mijozlar loyihalari, IT solutions, real work examples">
  <meta name="author" content="Templates.uz">
  <meta name="robots" content="index, follow">

  <meta property="og:title" content="Projects - Templates.uz">
  <meta property="og:description"
    content="Explore Templates.uz projects: web development, IT solutions, and custom software.">
  <meta property="og:image" content="https://templates.uz/assets/img/templates.png">
  <meta property="og:image:width" content="1920">
  <meta property="og:image:height" content="1080">
  <meta property="og:image:type" content="image/image/png">
  <meta property="og:url" content="https://templates.uz/projects.php">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Templates.uz - Web Development & IT Services">
  <meta name="twitter:description" content="Web development, bot creation, and IT services for businesses.">
  <meta name="twitter:image" content="https://templates.uz/assets/img/templates.png">

  <link href="favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="portfolio-page">

  <?php include 'includes/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="./">Home</a></li>
            <li class="current">Projects</li>
          </ol>
        </nav>
        <h1>Project</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- projects Section -->
    <section id="portfolio" class="portfolio section">
      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <!-- projects Category -->
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <?php foreach ($categories as $category): ?>
              <li data-filter=".filter-category-<?= $category['id'] ?>"><?= $category['category_name'] ?></li>
            <?php endforeach; ?>
          </ul><!-- End projects Category -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($grouped_projects as $category_id => $projects): ?>
              <?php foreach ($projects as $project): ?>
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-category-<?= $category_id ?>">
                  <div class="portfolio-content h-100">
                    <a href="project_details.php?id=<?= $project['id'] ?>">
                      <?php
                      $image_url = '';
                      // Fetch the image URL for the current project
                      foreach ($project_images as $image) {
                        if ($image['project_id'] == $project['id']) {
                          $image_url = $image['image_url'];
                          break;
                        }
                      }
                      ?>
                      <img src="assets/img/projects/<?= $image_url ?>" class="img-fluid"
                        alt="<?= $project['project_name'] ?>">
                      <div class="portfolio-info">
                        <h4><?= $project['project_name'] ?></h4>
                        <p>
                          <a href="<?php echo $project['link']; ?>" style="color: #007BFF; font-weight: 600;"
                            target="_blank">
                            <?php echo str_replace(['https://', 'http://', 'www.'], '', $project['link']); ?>
                          </a>
                        </p>
                      </div>
                    </a>
                  </div>
                </div><!-- End Portfolio Item -->
              <?php endforeach; ?>
            <?php endforeach; ?>

          </div><!-- End Portfolio Container -->

        </div>
      </div>
    </section><!-- /Portfolio Section -->

  </main>

  <?php include 'includes/footer.php'; ?>

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
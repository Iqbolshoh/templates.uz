<?php
session_start();

include './config.php';
$query = new Database();

$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

if (
  $_SERVER["REQUEST_METHOD"] === "POST" &&
  isset($_POST['submit']) &&
  isset($_POST['csrf_token']) &&
  isset($_SESSION['csrf_token']) &&
  hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
  $name = $query->validate($_POST['name']);
  $email = $query->validate($_POST['email']);
  $subject = $query->validate($_POST['subject']);
  $message = $query->validate($_POST['message']);

  $data = [
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
    'created_at' => date('Y-m-d H:i:s')
  ];

  $result = $query->insert('messages', $data);
  ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php
  if ($result) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    ?>
    <script>
      window.onload = function () { Swal.fire({ icon: 'success', title: 'Success!', text: 'Your message has been sent successfully.', timer: 1500, showConfirmButton: false }).then(() => { window.location.replace("./contact.php"); }); }; 
    </script>
    <?php
  } else {
    ?>
    <script>
      window.onload = function () { Swal.fire({ icon: 'error', title: 'Error!', text: 'An error occurred while sending the message. Please try again!', timer: 2000, showConfirmButton: true }); }; 
    </script>
    <?php
  }
} elseif (isset($_POST['submit'])) {
  ?>
  <script>
    window.onload = function () { Swal.fire({ icon: 'error', title: 'Invalid CSRF Token', text: 'Please refresh the page and try again.', showConfirmButton: true }); };
  </script>
  <?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
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

<body class="contact-page">

  <?php include 'includes/header.php' ?>

  <main class="main">

    <!-- Page title -->
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="./">Home</a></li>
            <li class="current">Contact</li>
          </ol>
        </nav>
        <h1>Contact</h1>
      </div>
    </div><!-- End of Page title -->

    <!-- Contact section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <?php foreach ($contact_boxData as $contact): ?>
            <div class="col-lg-<?php echo ($contact['id'] == 1) ? '6' : '3'; ?> col-md-6">
              <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
                data-aos-delay="100">
                <i class="<?php echo $contact['icon']; ?>"></i>
                <h3><?php echo $contact['title']; ?></h3>
                <p><?php echo $contact['value']; ?></p>
              </div>
            </div><!-- End of Info Item -->
          <?php endforeach; ?>

        </div>

        <div class="row gy-4 mt-1">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <<iframe
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3072.5298862417435!2d66.96820727777097!3d39.637787762516005!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f4d1f8bc8499255%3A0x7d89646ab179a0fe!2sSamarqand%20davlat%20universiteti%20IT%20markazi!5e0!3m2!1sen!2s!4v1739087509983!5m2!1sen!2s"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div><!-- End of Google Map -->

          <div class="col-lg-6">

            <form method="post" class="php-email-form" id="contactForm" data-aos="fade-up" data-aos-delay="100">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required=""
                    maxlength="255">
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required=""
                    maxlength="255">
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required=""
                    maxlength="255">
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>
                <div class="col-md-12">
                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" name="submit">Send Message</button>
                  <div class="sent-message" style="display: none;">Your message has been sent successfully!</div>
                  <div class="error-message" style="display: none;"></div>
                </div>
              </div>
            </form>

          </div><!-- End of Contact Form -->

        </div>

      </div>

    </section><!-- End of Contact section -->

  </main>

  <?php include 'includes/footer.php' ?>

  <!-- Scroll to Top -->
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
  <script src="assets/js/main.js"></script>
</body>

</html>
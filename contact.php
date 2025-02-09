<?php
include 'config.php';
$query = new Database();
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
  <link href="assets/vendor/glightboFx/css/glightbox.min.css" rel="stylesheet">
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
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2974.8813426551865!2d67.01298087569626!3d39.58263960598262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f4d21d3f20f2e7d%3A0x65da282d59cb1b22!2sUy!5e1!3m2!1sen!2s!4v1738728573422!5m2!1sen!2s"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div><!-- End of Google Map -->

          <div class="col-lg-6">
            <form action="send_message.php" method="post" class="php-email-form" id="contactForm" data-aos="fade-up"
              data-aos-delay="100">
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
                <div class="col-md-12 text-center">

                  <button type="submit">Send Message</button>
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

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
      e.preventDefault();

      // Ensure the form submission happens only once
      const submitButton = e.target.querySelector('button[type="submit"]');
      submitButton.disabled = true;

      const formData = new FormData(this);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'send_message.php', true);
      xhr.onload = function () {
        if (this.status === 200) {
          const response = JSON.parse(this.responseText);
          if (response.status === 'success') {
            document.querySelector('.sent-message').style.display = 'block';
            document.querySelector('.error-message').style.display = 'none';
            setTimeout(() => {
              document.querySelector('.sent-message').style.display = 'none';
            }, 3000);
            document.getElementById('contactForm').reset();
          } else {
            document.querySelector('.error-message').textContent = response.message;
            document.querySelector('.error-message').style.display = 'block';
            document.querySelector('.sent-message').style.display = 'none';
          }
        }
        submitButton.disabled = false;
      };
      xhr.send(formData);
    });
  </script>

</body>

</html>
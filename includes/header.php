<?php $contact_boxData = $query->select('contact_box'); ?>
<?php $contactData = $query->select('contact'); ?>

<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center dark-background">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center">
                    <a href="mailto:<?php echo  $contact_boxData[2]['value']; ?>">
                        <?php echo  $contact_boxData[2]['value']; ?>
                    </a>
                </i>
                <i class="bi bi-phone d-flex align-items-center ms-4">
                    <span>
                        <a href="tel:<?php echo trim($contact_boxData[2]['value']); ?>">
                            <?php echo $contact_boxData[1]['value']; ?>
                        </a>
                    </span>
                </i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="https://twitter.com/<?php echo  $contactData[0]['twitter']; ?>" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="https://facebook.com/<?php echo  $contactData[0]['facebook']; ?>" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://instagram.com/<?php echo  $contactData[0]['instagram']; ?>" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://linkedin.com/in/<?php echo  $contactData[0]['linkedin']; ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>

    <div class="branding">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="./" class="logo d-flex align-items-center">
                <h1 class="sitename">Templates.uz<br></h1>
            </a>

            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="./" class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about.php" class="<?= ($current_page == 'about.php') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="services.php" class="<?= ($current_page == 'services.php') ? 'active' : ''; ?>">Services</a></li>
                    <li><a href="projects.php" class="<?= ($current_page == 'projects.php') ? 'active' : ''; ?>">Projects</a></li>
                    <li><a href="contact.php" class="<?= ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </div>

</header>

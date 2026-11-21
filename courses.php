<?php
// 1. Database Connection (ഡാറ്റാബേസ് കണക്ഷൻ)
$conn = new mysqli("localhost", "root", "", "inetinfotech");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 2. Fetch published courses from the database
$sql = "SELECT * FROM courses WHERE status = 'published' ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#0c0a0d">
<title>Courses | I-Net Infotech</title>
<meta name="description" content="IT courses in Cochin: Cisco networking, Red Hat Linux, Microsoft, web, programming, data, cloud and digital marketing.">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="icon" type="image/png" href="assets/logo2.png">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/poster.css">
<link rel="stylesheet" href="css/carousel.css">
<link rel="stylesheet" href="css/motion.css"><script>try{if(sessionStorage.getItem('inet.nav')){document.documentElement.classList.add('pt-in');sessionStorage.removeItem('inet.nav')}}catch(e){}</script></head>
<body>

<header>
  <div class="w nav">
    <a href="index.php" aria-label="I-Net Infotech home"><img src="assets/logo.png" alt="I-Net Infotech"></a>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="courses.php" class="on">Courses</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="placements.php">Placements</a></li>
      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
    <a class="btn" href="contact.php">Enrol now</a>
    <button class="tg" aria-label="Menu" aria-expanded="false"><span></span><span></span></button>
  </div>
</header>

<main>
  <section class="phero">
    <div class="w">
      <div>
        <h1>Our<em>courses</em></h1>
        <p>Pick a track. Build real work.</p>
        <a class="btn" href="contact.php">Talk to a counsellor</a>
      </div>
      <div class="pimgs" aria-hidden="true">
        <img src="assets/it-programming.jpg" alt="" loading="lazy">
        <img src="assets/digital-marketing.jpg" alt="" loading="lazy">
      </div>
    </div>
  </section>

  <div class="sub">
    <div class="w">
      <strong>Course topics</strong>
      <!-- PHP-യിൽ നിന്ന് ലോഡ് ചെയ്യുന്നതിനാൽ, ഇവിടെ ഫിൽട്ടർ ചെയ്യാൻ ഞാൻ ഒരു ചെറിയ JS ഉപയോഗിക്കുന്നു -->
      <button class="on" data-f="all">All</button>
      <button data-f="net">Networking</button>
      <button data-f="ops">Cloud &amp; Security</button>
      <button data-f="web">Web &amp; Digital</button>
      <button data-f="code">Programming</button>
      <button data-f="data">Data &amp; AI</button>
      <button data-f="car">Careers</button>
    </div>
  </div>

  <section class="sec">
    <div class="w gcs" id="courseGrid">
      
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <?php 
            // Category Code mapping (For filtering)
            $catCode = !empty($row['category']) ? $row['category'] : 'all'; 
            
            // Image or Icon logic
            $imgSrc = !empty($row['image']) ? $row['image'] : 'assets/placeholder.jpg';
            $icon = !empty($row['icon']) ? $row['icon'] : 'fa-solid fa-graduation-cap';
            $feeText = !empty($row['fee']) ? $row['fee'] : 'Call for fees';
          ?>
          
          <!-- Course Card -->
          <a class="gc" href="course.php?id=<?= $row['id'] ?>" data-cat="<?= htmlspecialchars($catCode) ?>">
            <div class="ph2">
              <?php if(!empty($row['image'])): ?>
                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($row['alt_text']) ?>" style="object-fit:<?= htmlspecialchars($row['fit']) ?>;object-position:<?= htmlspecialchars($row['position']) ?>;">
              <?php else: ?>
                <i class="<?= htmlspecialchars($icon) ?>"></i>
              <?php endif; ?>
            </div>
            <i class="dash"></i>
            <small><i class="<?= htmlspecialchars($icon) ?>"></i> <?= htmlspecialchars($row['tag']) ?></small>
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <span class="meta"><?= htmlspecialchars($row['meta']) ?></span>
            <span class="meta"><b><?= htmlspecialchars($feeText) ?></b></span>
          </a>
          
        <?php endwhile; ?>
      <?php else: ?>
        <p style="grid-column: 1/-1; text-align: center; padding: 40px;">No courses found in the database. Please add courses from the Admin Panel.</p>
      <?php endif; ?>

    </div>
  </section>

  <section class="sec info-sec">
    <div class="w">
      <h2>How it works</h2>
      <p class="say-p">From first call to first job, in three clear stages.</p>
      <ol class="steps">
        <li><b>01</b><h3>Counselling</h3><p>Tell us your background and goal. We suggest the right course and batch timing.</p></li>
        <li><b>02</b><h3>Hands-on training</h3><p>Lab and project based classes with trainers who work in the industry.</p></li>
        <li><b>03</b><h3>Certify and get placed</h3><p>Exam preparation for Cisco, Microsoft and Red Hat, then resume and interview support.</p></li>
      </ol>
    </div>
  </section>
</main>

<footer class="slim">
  <div class="w">
    <div class="row">
      <img src="assets/logo.png" alt="I-Net Infotech">
      <nav>
        <a href="courses.php">Courses</a>
        <a href="placements.php">Placements</a>
        <a href="gallery.php">Gallery</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
      </nav>
      <div>
        <a href="tel:+919846233339">+91 98462 33339</a><br>
        <a href="tel:+919633233339">+91 96332 33339</a>
      </div>
    </div>
    <small>VBM Bava Chamber, Paramara Road, Ernakulam North, Cochin 682018 · © 2026 I-Net Infotech</small>
  </div>
</footer>

<a class="wa" href="https://wa.me/919846233339" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <i class="fa-brands fa-whatsapp" style="font-size:32px;color:#fff"></i>
</a>

<script src="js/carousel.js"></script>
<script src="js/motion.js"></script>

<!-- ഫിൽട്ടർ ബട്ടണുകൾ പ്രവർത്തിപ്പിക്കാനുള്ള ചെറിയ സ്ക്രിപ്റ്റ് -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const filterButtons = document.querySelectorAll('.sub button');
  const courseCards = document.querySelectorAll('.gcs .gc');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Remove active class from all
      filterButtons.forEach(b => b.classList.remove('on'));
      // Add active class to clicked
      btn.classList.add('on');

      const filterValue = btn.getAttribute('data-f');

      courseCards.forEach(card => {
        if (filterValue === 'all' || card.getAttribute('data-cat') === filterValue) {
          card.style.display = ''; // Show
        } else {
          card.style.display = 'none'; // Hide
        }
      });
    });
  });
});
</script>
</body>
</html>
<?php
// 1. ഡാറ്റാബേസ് കണക്ഷൻ
$conn = new mysqli("localhost", "root", "", "inetinfotech");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 2. കോഴ്സുകൾ ഡാറ്റാബേസിൽ നിന്ന് എടുക്കുക
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
<link rel="stylesheet" href="css/motion.css">
<script>try{if(sessionStorage.getItem('inet.nav')){document.documentElement.classList.add('pt-in');sessionStorage.removeItem('inet.nav')}}catch(e){}</script>

<style>
/* --- ഇമേജിലെ പോലെയുള്ള കാർഡ് ഡിസൈൻ --- */
.gcs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 24px;
}

.gc {
    display: flex;
    flex-direction: column;
    background: #070709;
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    position: relative;
    height: 100%;
}

.gc:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 34px rgba(0, 0, 0, 0.65);
    border-color: rgba(255, 255, 255, 0.18);
}

/* മുകളിലെ ഇമേജ് & ഓവർലേ ഭാഗം */
.gc-media {
    position: relative;
    height: 295px;
    width: 100%;
    background: #121216;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 16px;
}

.gc-media img.gc-bg-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
    transition: transform 0.45s ease;
}

.gc:hover .gc-media img.gc-bg-img {
    transform: scale(1.05);
}

/* താഴത്തെ ടൈറ്റിൽ വ്യക്തമായി കാണാനുള്ള ഡാർക്ക് ഗ്രേഡിയന്റ് */
.gc-media::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0.12) 0%,
        rgba(0, 0, 0, 0.08) 45%,
        rgba(5, 5, 7, 0.82) 82%,
        #070709 100%
    );
    z-index: 1;
    pointer-events: none;
}

.gc-fallback-icon {
    position: relative;
    z-index: 1;
    margin: auto;
    font-size: 54px;
    color: rgba(255, 255, 255, 0.35);
}

/* ടോപ്പ് ലെഫ്റ്റ് Cream/Off-White Pill Tag */
.card-tag {
    position: relative;
    z-index: 2;
    align-self: flex-start;
    background: #f2efe9;
    color: #111111;
    padding: 7px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
}

.card-tag i {
    font-size: 12px;
    color: #111111;
}

/* ഇമേജിന് താഴെ വരുന്ന വലിയ Bold White Title */
.gc-title-wrap {
    position: relative;
    z-index: 2;
    margin-top: auto;
    padding-top: 20px;
}

.gc-title-wrap h3 {
    margin: 0;
    color: #ffffff;
    font-size: 25px;
    line-height: 1.06;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: -0.2px;
    text-shadow: 0 2px 12px rgba(0, 0, 0, 0.65);
}

/* താഴത്തെ Dark Footer (Meta + View details + Red Circle Arrow) */
.card-bottom {
    background: #070709;
    padding: 12px 16px 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-top: auto;
}

.gc-meta-row {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 18px;
}

.gc-meta-bar {
    width: 2px;
    height: 15px;
    background: #22c55e;
    border-radius: 2px;
    flex-shrink: 0;
}

.gc-meta-text {
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.42);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.view-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #ff6a1a;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.1px;
    width: fit-content;
}

.view-btn .arrow-circle {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e11d48;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    transition: transform 0.25s ease, background-color 0.25s ease;
}

.gc:hover .view-btn .arrow-circle {
    transform: translateX(4px);
    background: #f43f5e;
}
</style>
</head>
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

      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <?php
            $catCode = !empty($row['category']) ? $row['category'] : 'all';
            $imgSrc  = !empty($row['image']) ? $row['image'] : '';
            $altText = !empty($row['alt_text']) ? $row['alt_text'] : ($row['title'] ?? 'Course');
            $icon    = !empty($row['icon']) ? $row['icon'] : 'fa-solid fa-laptop-code';
            $tagText = !empty($row['tag']) ? $row['tag'] : strtoupper($catCode);
          ?>

          <!-- Course Card (Image Reference UI) -->
          <a class="gc" href="course.php?id=<?= (int)$row['id'] ?>" data-cat="<?= htmlspecialchars($catCode) ?>">

            <div class="gc-media">
              <?php if (!empty($imgSrc)): ?>
                <img class="gc-bg-img" src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($altText) ?>" loading="lazy">
              <?php else: ?>
                <i class="<?= htmlspecialchars($icon) ?> gc-fallback-icon" aria-hidden="true"></i>
              <?php endif; ?>

              <!-- Top Pill Tag -->
              <div class="card-tag">
                <i class="<?= htmlspecialchars($icon) ?>" aria-hidden="true"></i>
                <span><?= htmlspecialchars($tagText) ?></span>
              </div>

              <!-- Bold Title Over Lower Image -->
              <div class="gc-title-wrap">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
              </div>
            </div>

            <div class="card-bottom">
              <?php if (!empty($row['meta'])): ?>
                <div class="gc-meta-row">
                  <span class="gc-meta-bar" aria-hidden="true"></span>
                  <span class="gc-meta-text"><?= htmlspecialchars($row['meta']) ?></span>
                </div>
              <?php endif; ?>

              <span class="view-btn">
                <span>View details</span>
                <span class="arrow-circle" aria-hidden="true">
                  <i class="fa-solid fa-chevron-right"></i>
                </span>
              </span>
            </div>

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

<!-- ഫിൽട്ടർ ബട്ടണുകൾ പ്രവർത്തിപ്പിക്കാനുള്ള സ്ക്രിപ്റ്റ് -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const filterButtons = document.querySelectorAll('.sub button');
  const courseCards = document.querySelectorAll('.gcs .gc');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      filterButtons.forEach(b => b.classList.remove('on'));
      btn.classList.add('on');

      const filterValue = btn.getAttribute('data-f');

      courseCards.forEach(card => {
        if (filterValue === 'all' || card.getAttribute('data-cat') === filterValue) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});
</script>
</body>
</html>
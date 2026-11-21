<?php
// 1. ഡാറ്റാബേസ് കണക്ഷൻ
$conn = new mysqli("localhost", "root", "", "inetinfotech");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 2. സർവീസുകൾ ഡാറ്റാബേസിൽ നിന്ന് എടുക്കുക
$sql = "SELECT * FROM services WHERE status = 'published' ORDER BY id ASC";
$result = $conn->query($sql);
$services = [];
while ($row = $result->fetch_assoc()) {
    // pts എന്നത് ഒരു JSON അല്ലെങ്കിൽ newline ആയി സേവ് ചെയ്തിട്ടുണ്ടെങ്കിൽ അത് array ആക്കുക
    $row['pts_array'] = !empty($row['pts']) ? explode("\n", $row['pts']) : [];
    $services[] = $row;
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Products &amp; Services | I-Net Infotech</title><meta name="description" content="Network solutions, software, website and app development, digital marketing and IT training from I-Net Infotech, Cochin.">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="icon" type="image/png" href="assets/logo2.png">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/poster.css"><link rel="stylesheet" href="css/motion.css"><script>try{if(sessionStorage.getItem('inet.nav')){document.documentElement.classList.add('pt-in');sessionStorage.removeItem('inet.nav')}}catch(e){}</script></head><body>
<header><div class="w nav"><a href="index.php" aria-label="  home"><img src="assets/logo.png" alt="I-Net Infotech"></a><ul><li><a href="index.php">Home</a></li><li><a href="about.php">About</a></li><li><a href="courses.php">Courses</a></li><li><a href="services.php" class=on>Services</a></li><li><a href="placements.php">Placements</a></li><li><a href="gallery.php">Gallery</a></li><li><a href="contact.php">Contact</a></li></ul>
<a class="btn" href="contact.php">Enrol now</a><button class="tg" aria-label="Menu" aria-expanded="false"><span></span><span></span></button></div></header>
<main><section class="phero"><div class="w"><div><h1>Our<em>services</em></h1><p>Network, software and growth, from one Cochin team.</p><a class="btn" href="contact.php">Request a quote</a></div><div class="pimgs" aria-hidden="true"><img class="solo" src="assets/project-management.webp" alt="" loading="lazy"></div></div>
</div></section>

<section class="sec ps" id="services"><div class="w">
  <div class="rack">
    <!-- ഇടതുവശത്തെ ടാബുകൾ -->
    <div class="rack-list" role="tablist" aria-label="Services" aria-orientation="vertical" id="psTabs">
      <?php foreach($services as $index => $s): ?>
        <button class="rack-tab <?= $index === 0 ? 'on' : '' ?>" data-target="pane-<?= $s['id'] ?>" role="tab" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
          <i class="<?= htmlspecialchars($s['icon']) ?>"></i>
          <div>
            <strong><?= htmlspecialchars($s['name']) ?></strong>
            <span><?= htmlspecialchars($s['short']) ?></span>
          </div>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- വലതുവശത്തെ കണ്ടന്റ് -->
    <div class="rack-view" id="psView">
      <?php foreach($services as $index => $s): ?>
        <div class="rack-pane <?= $index === 0 ? 'on' : '' ?>" id="pane-<?= $s['id'] ?>" role="tabpanel">
          <h2><?= htmlspecialchars($s['title']) ?></h2>
          <p><?= htmlspecialchars($s['desc']) ?></p>
          
          <ul class="ticks">
            <?php foreach($s['pts_array'] as $pt): ?>
              <?php if(trim($pt) !== ''): ?>
                <li><?= htmlspecialchars(trim($pt)) ?></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
          
          <?php if(!empty($s['fit'])): ?>
            <p class="fit"><b><?= htmlspecialchars($s['fit']) ?></b></p>
          <?php endif; ?>
          
          <?php if(!empty($s['course'])): ?>
            <a class="btn" href="<?= htmlspecialchars($s['href'] ?: 'courses.php') ?>"><?= htmlspecialchars($s['course']) ?> <i class="fa-solid fa-arrow-right"></i></a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div></section>

<section class="sec info-sec"><div class="w"><h2>How we work</h2><p class="say-p">A simple process so you always know what happens next.</p><ol class="steps s4"><li><b>01</b><h3>Consult</h3><p>We visit or call, understand your needs and note what you already have.</p></li><li><b>02</b><h3>Plan</h3><p>You get a clear scope, timeline and quote before any work starts.</p></li><li><b>03</b><h3>Deliver</h3><p>Our engineers build, install and test, then walk your team through it.</p></li><li><b>04</b><h3>Support</h3><p>Maintenance plans and a direct phone line for when something needs fixing.</p></li></ol></div></section>
</main>

<footer class="slim"><div class="w"><div class="row"><img src="assets/logo.png" alt="I-Net Infotech"><nav><a href="courses.php">Courses</a><a href="placements.php">Placements</a><a href="gallery.php">Gallery</a><a href="about.php">About</a><a href="contact.php">Contact</a></nav><div><a href="tel:+919846233339">+91 98462 33339</a><br><a href="tel:+919633233339">+91 96332 33339</a></div></div><small>VBM Bava Chamber, Paramara Road, Ernakulam North, Cochin 682018 · © 2026 I-Net Infotech</small></div></footer>
<a class="wa" href="https://wa.me/919846233339" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="fa-brands fa-whatsapp" style="font-size:32px;color:#fff"></i></a>
<script src="js/courses-data.js"></script><script src="js/main.js"></script><script src="js/motion.js"></script>

<!-- ടാബുകൾ ക്ലിക്ക് ചെയ്യുമ്പോൾ പാനൽ മാറാൻ വേണ്ടിയുള്ള ചെറിയ സ്ക്രിപ്റ്റ് -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.rack-tab');
    const panes = document.querySelectorAll('.rack-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // എല്ലാ ടാബുകളിൽ നിന്നും 'on' ക്ലാസ് ഒഴിവാക്കുക
            tabs.forEach(t => t.classList.remove('on'));
            panes.forEach(p => p.classList.remove('on'));

            // ക്ലിക്ക് ചെയ്ത ടാബിന് 'on' ക്ലാസ് നൽകുക
            tab.classList.add('on');
            const targetId = tab.getAttribute('data-target');
            document.getElementById(targetId).classList.add('on');
        });
    });
});
</script>
</body></html>
<?php
/**
 * Modularized Homepage View for VinFast
 * Imports scoped CSS/JS assets and includes sections from home-sections/
 */

// Scope page-specific scripts into layout footer
$GLOBALS['footer_js_files'][] = 'assets/js/homepage-custom.js';
?>
<main>
  <!-- DYNAMIC JSON-LD GRAPH SCHEMA FOR 2026 SEO ADVANTAGES -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "AutoDealer",
        "@id": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"; ?>#dealer",
        "name": "<?php echo htmlspecialchars($agencyName); ?>",
        "image": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"; ?>assets/favicon/favicon.ico",
        "telephone": "<?php echo htmlspecialchars($agencyPhone); ?>",
        "priceRange": "$$$$",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "<?php echo htmlspecialchars($agencyAddress); ?>",
          "addressLocality": "TP. Hồ Chí Minh",
          "addressCountry": "VN"
        }
      },
      {
        "@type": "WebSite",
        "@id": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"; ?>#website",
        "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"; ?>",
        "name": "VinFast Việt Nam",
        "description": "<?php echo htmlspecialchars($siteDesc); ?>"
      }
    ]
  }
  </script>

  <?php
  // Load modular homepage sections sequentially
  $sections = [
      '01_hero',
      '02_catalog',
      '04_ev_tech',
      '05_privileges',
      '06_why_dealer',
      '07_trade_in',
      '08_exclusive_offers',
      '09_counselors',
      '10_faq'
  ];

  foreach ($sections as $sec) {
      $secPath = dirname(__DIR__) . "/components/home-sections/{$sec}/{$sec}.php";
      if (file_exists($secPath)) {
          include $secPath;
      }
  }
  ?>
</main>

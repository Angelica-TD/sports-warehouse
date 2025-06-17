<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title><?= $title ?? "NO TITLE" ?> | <?= COMPANY_NAME ?></title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'" media="print">

  <link rel="stylesheet" href="./assets/styles/style.css">

  <!-- Page-specific styles : begin -->

  <?php
    // Normalise styles to array
    $styles = isset($styles)
        ? (is_array($styles) ? $styles : [$styles])
        : [];

    foreach ($styles as $src) :
    ?>
      <link rel="stylesheet" href="./assets/styles/<?= htmlspecialchars($src) ?>">
    <?php endforeach; ?>

  <!-- Page-specific styles : end -->

  <link rel="icon" type="image/x-icon" href="./assets/images/logos/sw-favicon.png">

  <script src="https://kit.fontawesome.com/fbcec5cfed.js" crossorigin="anonymous"></script>
  <meta name="description" content="<?= $metaDescription ?? '' ?>">

</head>

<body class="flex-column gap">
  
  <?php include BLOCK_TEMPLATES_DIR . "_header.html.php"; ?>

  <div class="section-wrapper flex-column gap-smaller">

    <main class="flex-column gap">

    <?= $content ?? 'NO CONTENT - $content not defined' ?>

    </main>

  </div>

  <?php include BLOCK_TEMPLATES_DIR . "_footer.html.php"; ?>

</body>
</html>
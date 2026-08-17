<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kos Application</title>
    
    <!-- Load Bootstrap CSS Offline pakai base_url() -->
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>"><strong>E-Kos</strong></a>
        </div>
    </nav>

    <!-- Area Dinamis -->
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- Load Bootstrap JS Offline pakai base_url() -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>
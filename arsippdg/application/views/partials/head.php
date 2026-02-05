<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'E-Arsip PDG'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Bootstrap 5 CSS -->
    <link href="{% static 'bootstrap/css/bootstrap.min.css' %}" rel="stylesheet">
    
    <!-- file cdn -->
     <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/LogoPoltek.png'); ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/custom/style_base.css'); ?>">

    <!-- SweetAlert -->
    <link rel="stylesheet" href="<?= base_url('assets/sweetalert/sweetalert2.css'); ?>">

    
</head>
<body>

<?php require_once dirname(dirname(__DIR__)) . '/helpers/languages.php'; ?>

<!DOCTYPE html>
<html lang="bg-BG">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="/src/assets/css/styles.css">
    <title><?= !empty($title) ? $title . ' - ' . __('website_title') : __('website_title') ?></title>
</head>

<body class="bg-gray-100">
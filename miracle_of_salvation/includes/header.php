
<?php
if (!isset($pageTitle)) {
    $pageTitle = "Miracle of Salvation Church | Kampala, Uganda";
}

// URL of the site root, whether served from this folder or a parent web root.
$basePath = rtrim(str_replace('\\', '/', substr(realpath(dirname(__DIR__)), strlen(realpath($_SERVER['DOCUMENT_ROOT'])))), '/') . '/';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>

    <meta name="description" content="Welcome to Miracle of Salvation Church, Kampala, Uganda. Join us for worship, prayer, fellowship and spiritual growth.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $basePath ?>assets/css/style.css">
</head>

<body>

<?php require_once __DIR__ . '/navigation.php'; ?>

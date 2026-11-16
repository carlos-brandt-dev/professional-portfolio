<?php
// Build a base URL that works even if the project is inside a folder like /portfolio
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($baseUrl === '') { $baseUrl = '/'; }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Professional portfolio showcasing coursework, projects, and web development skills.">

  <title>Carlos Brandt | Professional Portfolio</title>

  <!-- Main stylesheet -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/style.css?v=15">
</head>
<body>


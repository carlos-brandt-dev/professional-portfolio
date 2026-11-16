<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: evaluations_view.php");
    exit;
}
$password = getenv('PORTFOLIO_ADMIN_PASSWORD') ?: '';

if (isset($_POST['password'])) {
    if (($password !== '' && hash_equals($password, (string) $_POST['password']))) {
        $_SESSION['evaluation_access'] = true;
    } else {
        $error = "Incorrect password.";
    }
}

$authorized = $_SESSION['evaluation_access'] ?? false;

?>

<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>

<main>
<section class="page-section">
<h1>Evaluation Submissions</h1>

<div class="about-content">

<?php if (!$authorized): ?>

<form method="post" class="contact-form">
    <label for="password">Enter Password</label>
    <input type="password" name="password" required>
    <button class="btn-submit" type="submit">Access</button>

    <?php if (isset($error)): ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>
</form>

<?php else: ?>
<form method="post">
  <button class="btn-submit" name="logout" type="submit">Logout</button>
</form>
<?php
$file = __DIR__ . '/data/evaluations.txt';

if (!file_exists($file)) {
    echo "<p>No evaluations have been submitted yet.</p>";
} else {

    $lines = file($file);

    if (empty($lines)) {
        echo "<p>No evaluations available.</p>";
    } else {

        echo '<div class="submissions-list">';

        foreach (array_reverse($lines) as $line) {
            echo '<div class="submission-card">';
            echo nl2br(htmlspecialchars($line));
            echo '</div>';
        }

        echo '</div>';
    }
}
?>

<?php endif; ?>

</div>
</section>
</main>

<?php include "includes/footer.php"; ?>
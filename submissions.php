<?php
// submissions.php (private page)

// CHANGE THIS PASSWORD
$PASSWORD = getenv('PORTFOLIO_ADMIN_PASSWORD') ?: '';

session_start();

function clean($v) {
  return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}

// Handle login
$login_error = "";
if (isset($_POST['pass'])) {
  if (($PASSWORD !== '' && hash_equals($PASSWORD, (string) $_POST['pass']))) {
    $_SESSION['submissions_ok'] = true;
  } else {
    $login_error = "Incorrect password.";
  }
}

// Handle logout
if (isset($_GET['logout'])) {
  unset($_SESSION['submissions_ok']);
  header("Location: submissions.php");
  exit;
}

$is_authed = !empty($_SESSION['submissions_ok']);

$logPath = __DIR__ . '/data/contact_submissions.txt';
$lines = [];
if ($is_authed && file_exists($logPath)) {
  // Read newest last; we'll reverse to show newest first.
  $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $lines = array_reverse($lines);
}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>

<main>
  <section class="page-section">
    <h1>Message Submissions</h1>

    <div class="contact-wrap">

      <?php if (!$is_authed): ?>
        <div class="alert error">
          <strong>Private Page:</strong> Enter the password to view submissions.
        </div>

        <?php if ($login_error): ?>
          <div class="alert error">
            <strong><?php echo clean($login_error); ?></strong>
          </div>
        <?php endif; ?>

        <form class="contact-form" method="post" action="submissions.php">
          <label for="pass">Password</label>
          <input type="password" id="pass" name="pass" placeholder="Enter password" required>
          <button class="btn-submit" type="submit">Unlock</button>
        </form>

      <?php else: ?>
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
          <p style="color: var(--muted); margin: 0;">
            Showing saved form submissions from <code>/data/contact_submissions.txt</code>.
          </p>
          <a class="resume-link" href="submissions.php?logout=1">Log out</a>
        </div>

        <?php if (!file_exists($logPath)): ?>
          <div class="alert error">
            <strong>No log file found.</strong> Make sure the <code>data</code> folder exists and the contact form has been submitted at least once.
          </div>
        <?php elseif (empty($lines)): ?>
          <div class="alert">
            <strong>No submissions yet.</strong> Submit the contact form to create entries.
          </div>
        <?php else: ?>
          <div class="submissions-list">
            <?php foreach ($lines as $line): ?>
              <div class="submission-card">
                <?php echo clean($line); ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      <?php endif; ?>

    </div>
  </section>
</main>

<?php include "includes/footer.php"; ?>
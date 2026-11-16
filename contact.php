<?php
// contact.php
$errors = [];
$success = false;

// Default values (so the form can "remember" what user typed)
$name = '';
$email = '';
$message = '';

function clean($value) {
  return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = clean($_POST['name'] ?? '');
  $email = clean($_POST['email'] ?? '');
  $message = clean($_POST['message'] ?? '');

  // Validation
  if ($name === '' || strlen($name) < 2) {
    $errors[] = "Please enter your name (at least 2 characters).";
  }

  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  }

  if ($message === '' || strlen($message) < 10) {
    $errors[] = "Please enter a message (at least 10 characters).";
  }

  // If no errors, mark as success
  if (empty($errors)) {
    $success = true;

    // Optional (Week 4): Save to a local file (no database needed)
    // Create a folder called "data" and ensure it can write on hosting if needed.
    $logLine = date('Y-m-d H:i:s') . " | Name: $name | Email: $email | Message: " . str_replace(["\r", "\n"], ' ', $message) . PHP_EOL;

    // If the data folder doesn't exist, the code won't crash the page; it just won't log.
    $logPath = __DIR__ . '/data/contact_submissions.txt';
    @file_put_contents($logPath, $logLine, FILE_APPEND);

    // Reset fields after success (optional)
    $name = '';
    $email = '';
    $message = '';
  }
}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>

<main>
  <section class="page-section">
    <h1>Contact</h1>

    <div class="contact-wrap">

      <?php if ($success): ?>
        <div class="alert success">
          <strong>Message sent!</strong> Thank you for reaching out. A response will be provided as soon as possible.
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="alert error">
          <strong>Please fix the following:</strong>
          <ul>
            <?php foreach ($errors as $e): ?>
              <li><?php echo $e; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="contact-form" method="post" action="contact.php" novalidate>

        <label for="name">Full Name</label>
        <input
          type="text"
          id="name"
          name="name"
          value="<?php echo $name; ?>"
          placeholder="Enter your name"
          required
        >

        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?php echo $email; ?>"
          placeholder="Enter your email"
          required
        >

        <label for="message">Message</label>
        <textarea
          id="message"
          name="message"
          rows="6"
          placeholder="Write your message..."
          required
        ><?php echo $message; ?></textarea>

        <button class="btn-submit" type="submit">Send Message</button>
      </form>
	  <div class="contact-direct">
		<p class="social-label">OTHER WAYS TO REACH ME</p>

		<div class="social-links">
			<!-- Email -->
			<a href="mailto:brandt.c.carlos@gmail.com" aria-label="Email">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
				</svg>
			</a>

			<!-- LinkedIn -->
			<a href="https://www.linkedin.com/in/carlos-brandt-cevallos-341212299" target="_blank" rel="noopener" aria-label="LinkedIn">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0.5 8.5h4V23h-4V8.5zM8.5 8.5h3.8v2h.05c.53-1 1.83-2.05 3.76-2.05 4.02 0 4.77 2.65 4.77 6.1V23h-4v-6.95c0-1.66-.03-3.8-2.32-3.8-2.32 0-2.67 1.81-2.67 3.68V23h-4V8.5z"/>
				</svg>
			</a>
		</div>
	  </div>
    </div>
  </section>
</main>

<?php include "includes/footer.php"; ?>


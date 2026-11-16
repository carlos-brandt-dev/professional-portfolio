<?php
// evaluation.php
$errors = [];
$success = false;

// Default values (so the form remembers what the user typed)
$name = '';
$rating = '';
$comments = '';

function clean($value) {
  return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = clean($_POST['name'] ?? '');
  $rating = clean($_POST['rating'] ?? '');
  $comments = clean($_POST['comments'] ?? '');

  // Validation
  if ($name === '' || strlen($name) < 2) {
    $errors[] = "Please enter your name (at least 2 characters).";
  }

  if (!in_array($rating, ['1','2','3','4','5'], true)) {
    $errors[] = "Please select a rating between 1 and 5.";
  }

  if ($comments === '' || strlen($comments) < 10) {
    $errors[] = "Please enter a comment (at least 10 characters).";
  }

  if (empty($errors)) {
    $success = true;

    $logLine =
      date('Y-m-d H:i:s') .
      " | Name: $name" .
      " | Rating: $rating" .
      " | Comment: " . str_replace(["\r", "\n"], ' ', $comments) .
      PHP_EOL;

    $logPath = __DIR__ . '/data/evaluations.txt';
    @file_put_contents($logPath, $logLine, FILE_APPEND);

    $name = '';
    $rating = '';
    $comments = '';
  }
}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>

<main>
  <section class="page-section">
    <h1>Evaluation</h1>

    <div class="contact-wrap">

      <?php if ($success): ?>
        <div class="alert success">
          <strong>Thank you!</strong> Your feedback has been submitted successfully.
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

      <form class="eval-form" method="post" action="evaluation.php" novalidate>

        <label for="name">Full Name</label>
        <input
          type="text"
          id="name"
          name="name"
          value="<?php echo $name; ?>"
          placeholder="Enter your name"
          required
        >

        <label>Rating</label>
        <div class="rating-group" role="radiogroup" aria-label="Rating">
          <?php
            for ($i = 5; $i >= 1; $i--) {
              $checked = ($rating === (string)$i) ? 'checked' : '';
              echo '
                <label class="rating-item">
                  <input type="radio" name="rating" value="'.$i.'" '.$checked.'>
                  <span>'.$i.'</span>
                </label>
              ';
            }
          ?>
        </div>

        <label for="comments">Comments</label>
        <textarea
          id="comments"
          name="comments"
          rows="6"
          placeholder="Write your feedback..."
          required
        ><?php echo $comments; ?></textarea>

        <button class="btn-submit" type="submit">Submit Evaluation</button>

      </form>

      <p class="contact-note">
        Feedback is used to improve usability, clarity, and overall presentation of the portfolio.
      </p>

    </div>
  </section>
</main>

<?php include "includes/footer.php"; ?>
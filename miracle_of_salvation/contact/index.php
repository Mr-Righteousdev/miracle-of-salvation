
<?php
$pageTitle = "Contact Us | Miracle of Salvation Church";

$messageSent = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || $subject === '' || $message === '') {
        $errorMessage = 'Please complete all fields using a valid email address.';
    } else {
        // Message processing will be connected to the database/email later.
        $messageSent = true;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="contact-hero">
    <div class="contact-hero-content">
        <span>WE WOULD LOVE TO HEAR FROM YOU</span>
        <h1>Contact Us</h1>
        <p>Connect with Miracle of Salvation Church. We are here to pray with you, support you and welcome you.</p>
    </div>
</section>

<section class="contact-section">

    <div class="contact-intro">
        <h2>Get in Touch</h2>
        <p>
            Whether you have a question, need prayer, want to visit our church
            or would like to learn more about our ministry, please reach out.
        </p>
    </div>

    <div class="contact-layout">

        <div class="contact-information">
            <h3>Contact Information</h3>

            <div class="contact-info-item">
                <div class="contact-icon">⌖</div>
                <div>
                    <h4>Our Church</h4>
                    <p>Miracle of Salvation Church</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">⌂</div>
                <div>
                    <h4>Postal Address</h4>
                    <p>P.O. Box 30501, Kampala, Uganda</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">♡</div>
                <div>
                    <h4>Prayer and Support</h4>
                    <p>Reach out to us for prayer and spiritual support.</p>
                </div>
            </div>

            <div class="contact-quote">
                "For where two or three gather in my name, there am I with them."
                <strong>Matthew 18:20</strong>
            </div>
        </div>

        <div class="contact-form-container">
            <h3>Send Us a Message</h3>
            <p>Fill in the form below and share your message with us.</p>

            <?php if ($messageSent): ?>
                <div class="form-success">
                    Thank you for contacting Miracle of Salvation Church.
                    Your message has been received on this page.
                </div>
            <?php endif; ?>

            <?php if ($errorMessage !== ''): ?>
                <div class="form-error">
                    <?= htmlspecialchars($errorMessage) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name"
                           placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           placeholder="Enter your email address" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject"
                           placeholder="What is your message about?" required>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="6"
                              placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" class="contact-submit">
                    SEND MESSAGE
                </button>
            </form>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

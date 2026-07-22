<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load composer autoloader if it exists
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// SMTP Settings - user can configure these on VPS deployment
define('SMTP_HOST', ''); 
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_FROM_EMAIL', 'noreply@hiranya.com');
define('SMTP_FROM_NAME', 'Hiranya Art House');

/**
 * Sends HTML Email. Falls back to logging to logs/mail_log.txt if SMTP is unconfigured.
 */
function send_email($to_email, $subject, $body_html) {
    if (empty(SMTP_HOST) || empty(SMTP_USER)) {
        $log_dir = __DIR__ . '/logs';
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0777, true);
        }
        $log_file = $log_dir . '/mail_log.txt';
        $log_content = sprintf(
            "[%s] To: %s\nSubject: %s\nBody:\n%s\n--------------------------------------------------\n\n",
            date('Y-m-d H:i:s'),
            $to_email,
            $subject,
            $body_html
        );
        file_put_contents($log_file, $log_content, FILE_APPEND);
        return true;
    }

    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        return false;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to_email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body_html;
        $mail->AltBody = strip_tags($body_html);

        $mail->send();
        return true;
    } catch (Exception $e) {
        $log_dir = __DIR__ . '/logs';
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0777, true);
        }
        $log_file = $log_dir . '/mail_error.txt';
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - SMTP Error to $to_email: " . $mail->ErrorInfo . "\n", FILE_APPEND);
        return false;
    }
}
?>

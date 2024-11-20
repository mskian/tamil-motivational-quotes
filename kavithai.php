<?php

require_once('./includes/config.php');
require_once('./includes/functions.php');
require_once('./includes/header.php');

if (isset($_GET['slug'])) {
    $slug = filter_var($_GET['slug'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if (!preg_match('/^[a-zA-Z0-9\-]+$/', $slug)) {
        echo "<h2 class='title'>Invalid slug format.</h2>";
        require_once('./includes/footer.php');
        exit;
    }

    try {
        $quote = getQuoteBySlug($slug);

        if (!$quote) {
            throw new Exception('Quote not found.');
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "<h2 class='title'>An error occurred. Please try again later.</h2>";
        require_once('./includes/footer.php');
        exit;
    }
} else {
    echo "<h2 class='title'>Invalid request.</h2>";
    require_once('./includes/footer.php');
    exit;
}

$title = escapeHtml($quote['title']);
$content = escapeHtml($quote['content']);

?>

<div id="quotes-container" class="quotes-container" style="margin-top: 120px;">
        <div class="quote-box">
        <button id="copy-button" class="is-small copy-btn" onclick="copyToClipboard()">
        <i class="fas fa-copy"></i>
        </button>
            <p class="content quote-text" id="quote-content"><?php echo nl2br($content); ?></p>
        </div>
            <br />
            <a href="/" class="button is-rounded is-danger read-more">
               🏠
            </a>
</div>

<?php require_once('./includes/footer.php'); ?>
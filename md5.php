<?php
    $md5 = null;
    $input = "";
    if (isset($_GET['encode'])) {
        $input = $_GET['encode'];
        $md5 = hash('md5', $input);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CIPHR · Hash Maker</title>
</head>
<body>

<div class="shell">

    <nav class="nav">
        <a href="index.php" class="brand">
            <span class="brand-dot"></span>
            CIPHR
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Cracker</a></li>
            <li><a href="md5.php">Hash Maker</a></li>
            <li><a href="makecode.php">Key Encoder</a></li>
            <li><a href="#">Docs</a></li>
        </ul>
        <a href="index.php" class="nav-cta">Back to Cracking</a>
    </nav>

    <div class="page-body">
        <span class="page-eyebrow">Hash Generation Suite</span>
        <h1 class="page-title">Forge an<br><em>MD5 Digest</em></h1>
        <p class="page-lede">
            Encode any string into its 128-bit fingerprint. Useful for testing
            the cracker against custom payloads or seeing why MD5 collisions
            make this algorithm unsuitable for modern integrity checks.
        </p>

        <form class="form" method="GET" action="md5.php">
            <div class="field">
                <input
                    type="text"
                    name="encode"
                    class="field-input"
                    placeholder="enter any string to hash"
                    value="<?= htmlentities($input) ?>"
                    autocomplete="off"
                />
            </div>
            <button type="submit" class="btn">Compute MD5</button>
        </form>

        <?php if ($md5 !== null): ?>
        <div class="section-label" style="margin-top: 30px;">Digest Output</div>
        <div class="result-card success" style="margin-bottom: 0;">
            <div style="flex: 1; min-width: 0;">
                <span class="result-label">128-bit MD5 Hash</span>
                <div class="result-value cracked" style="font-family: var(--font-mono); font-size: 1.15rem; word-break: break-all; line-height: 1.4;">
                    <?= htmlentities($md5) ?>
                </div>
            </div>
            <div class="result-meta">
                <span class="result-label">Length</span>
                <div class="num">32 chars</div>
            </div>
        </div>
        <?php endif; ?>

        <div class="button-row">
            <button type="button" class="btn-sm" onclick="window.location.href='md5.php'"><span class="icon">↻</span> Reset</button>
            <button type="button" class="btn-sm" onclick="window.location.href='index.php'"><span class="icon">←</span> Back to Cracking</button>
            <button type="button" class="btn-sm" onclick="window.location.href='makecode.php'"><span class="icon">→</span> Key Encoder</button>
        </div>
    </div>

</div>

</body>
</html>
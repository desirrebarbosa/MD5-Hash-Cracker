<?php
    $error = null;
    $md5 = null;
    $code = "";

    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        if (strlen($code) !== 2) {
            $error = "Input must be exactly two characters.";
        } elseif ($code[0] < "a" || $code[0] > "z" ||
                  $code[1] < "a" || $code[1] > "z") {
            $error = "Input must be two lower-case letters.";
        } else {
            $md5 = hash('md5', $code);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CIPHR · Key Encoder</title>
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
            <li><a href="docs.php">Docs</a></li>
        </ul>
        <a href="index.php" class="nav-cta">Back to Cracking</a>
    </nav>

    <div class="page-body">
        <span class="page-eyebrow">Two-Letter Key Encoder</span>
        <h1 class="page-title">Generate a<br><em>Challenge PIN</em></h1>
        <p class="page-lede">
            Provide exactly two lowercase letters. The encoder rejects everything
            else and returns a digest you can paste into the cracker to verify
            a complete brute-force round-trip.
        </p>

        <?php if ($error): ?>
            <div class="error-banner"><?= htmlentities($error) ?></div>
        <?php endif; ?>

        <form class="form" method="GET" action="makecode.php">
            <div class="field">
                <input
                    type="text"
                    name="code"
                    class="field-input"
                    placeholder="two lowercase letters · e.g. xq"
                    value="<?= htmlentities($code) ?>"
                    maxlength="2"
                    autocomplete="off"
                />
            </div>
            <button type="submit" class="btn">Compute MD5</button>
        </form>

        <?php if ($md5 !== null): ?>
        <div class="section-label" style="margin-top: 30px;">Digest Output</div>
        <div class="result-card success" style="margin-bottom: 0;">
            <div style="flex: 1; min-width: 0;">
                <span class="result-label">MD5 of "<?= htmlentities($code) ?>"</span>
                <div class="result-value cracked" style="font-family: var(--font-mono); font-size: 1.15rem; word-break: break-all; line-height: 1.4;">
                    <?= htmlentities($md5) ?>
                </div>
            </div>
            <div class="result-meta">
                <span class="result-label">Crack Time</span>
                <div class="num">~10 ms</div>
            </div>
        </div>
        <?php endif; ?>

        <div class="button-row">
            <button type="button" class="btn-sm" onclick="window.location.href='makecode.php'"><span class="icon">↻</span> Reset</button>
            <button type="button" class="btn-sm" onclick="window.location.href='index.php'"><span class="icon">←</span> Back to Cracking</button>
            <button type="button" class="btn-sm" onclick="window.location.href='md5.php'"><span class="icon">→</span> Hash Maker</button>
        </div>
    </div>

</div>

</body>
</html>
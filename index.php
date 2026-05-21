<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CIPHR | MD5 Cracker</title>
</head>
<body>
<?php
    $goodtext = null;
    $attempts = 0;
    $elapsed  = null;
    $debug    = [];

    if (isset($_GET['md5']) && $_GET['md5'] !== '') {
        $time_pre = microtime(true);
        $md5 = $_GET['md5'];

        $txt = "abcdefghijklmnopqrstuvwxyz";
        $show = 15;

        for ($i = 0; $i < strlen($txt); $i++) {
            $ch1 = $txt[$i];
            for ($j = 0; $j < strlen($txt); $j++) {
                $ch2 = $txt[$j];
                $try = $ch1 . $ch2;
                $attempts++;

                $check = hash('md5', $try);
                if ($check === $md5) {
                    $goodtext = $try;
                    break 2;
                }
                if ($show > 0) {
                    $debug[] = ['hash' => $check, 'try' => $try];
                    $show--;
                }
            }
        }

        $elapsed = microtime(true) - $time_pre;
    }
?>

<div class="shell">

    <!-- NAVIGATION -->
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
        <a href="#" class="nav-cta">Get Started</a>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <span class="eyebrow">Brute-force Reversal Engine</span>

            <h1 class="headline">
                Cracking the<br>
                Code of <em>Digital Trust</em>
            </h1>

            <p class="lede">
                Submit any 128-bit MD5 digest of a two-character lowercase key.
                Our engine walks the full 676-permutation search space in
                milliseconds — a hands-on demonstration of why short hashes are
                no longer secrets.
            </p>

            <!-- INPUT FORM -->
            <form class="form" method="GET" action="index.php">
                <div class="field">
                    <input
                        type="text"
                        name="md5"
                        class="field-input"
                        placeholder="paste md5 hash · 32 hex characters"
                        value="<?= isset($_GET['md5']) ? htmlentities($_GET['md5']) : '' ?>"
                        autocomplete="off"
                    />
                </div>
                <button type="submit" class="btn">Initialize Crack</button>
            </form>

            <!-- STAT CARD -->
            <div class="stat-card">
                <div class="stat-icons">
                    <span>A</span><span>B</span><span>C</span>
                </div>
                <div>
                    <div class="stat-number">676</div>
                    <p class="stat-text">Total search permutations<br>across the lowercase keyspace.</p>
                </div>
            </div>
        </div>

        <!-- 3D VISUAL -->
        <div class="visual" aria-hidden="true">
            <div class="orb-stage">
                <div class="orb petal petal-top"></div>
                <div class="orb petal petal-right"></div>
                <div class="orb petal petal-bottom"></div>
                <div class="orb petal petal-left"></div>
                <div class="orb orb-center"></div>

                <div class="annotation ann-1">Hash Engine</div>
                <div class="annotation ann-2">Search Vector</div>
                <div class="annotation ann-3">676 Keyspace</div>
            </div>
        </div>
    </section>

    <!-- RESULTS (only after submission) -->
    <?php if (isset($_GET['md5']) && $_GET['md5'] !== ''): ?>
    <section class="results-section">
        <div class="section-label">Execution Trace</div>

        <!-- result summary -->
        <?php if ($goodtext !== null): ?>
            <div class="result-card success">
                <div>
                    <span class="result-label">Plaintext Recovered</span>
                    <div class="result-value cracked"><?= htmlentities($goodtext) ?></div>
                </div>
                <div class="result-meta">
                    <span class="result-label">Attempts</span>
                    <div class="num"><?= $attempts ?> / 676</div>
                </div>
                <div class="result-meta">
                    <span class="result-label">Elapsed</span>
                    <div class="num"><?= number_format($elapsed * 1000, 3) ?> ms</div>
                </div>
            </div>
        <?php else: ?>
            <div class="result-card notfound">
                <div>
                    <span class="result-label">No Match Found</span>
                    <div class="result-value failed">Not in Keyspace</div>
                </div>
                <div class="result-meta">
                    <span class="result-label">Attempts</span>
                    <div class="num"><?= $attempts ?> / 676</div>
                </div>
                <div class="result-meta">
                    <span class="result-label">Elapsed</span>
                    <div class="num"><?= number_format($elapsed * 1000, 3) ?> ms</div>
                </div>
            </div>
        <?php endif; ?>

        <!-- terminal-style debug output -->
        <div class="terminal">
            <div class="terminal-header">
                <span class="terminal-dot r"></span>
                <span class="terminal-dot y"></span>
                <span class="terminal-dot g"></span>
                <span class="terminal-title">ciphr · trace.log</span>
            </div>
            <div class="terminal-body">
            <?php foreach ($debug as $row): ?><span class="terminal-line"><span class="hash"><?= $row['hash'] ?></span>  <span class="try"><?= $row['try'] ?></span></span>
            <?php endforeach; ?>
            <?php if ($goodtext): ?><span class="terminal-line" style="color:var(--emerald)">→ match · plaintext = <?= htmlentities($goodtext) ?></span>
            <?php endif; ?>
            </div>
        </div>

        <div class="button-row">
            <button type="button" class="btn-sm" onclick="window.location.href='index.php'"><span class="icon">↻</span> Reset</button>
            <button type="button" class="btn-sm" onclick="window.location.href='md5.php'"><span class="icon">→</span> Hash Maker</button>
            <button type="button" class="btn-sm" onclick="window.location.href='makecode.php'"><span class="icon">→</span> Key Encoder</button>
        </div>
    </section>
    <?php endif; ?>

</div>

</body>
</html>
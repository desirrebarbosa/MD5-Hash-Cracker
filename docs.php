<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CIPHR · Documentation</title>
</head>
<body>

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
        <a href="index.php" class="nav-cta">Back to Cracking</a>
    </nav>

    <!-- DOCS LAYOUT -->
    <div class="docs-layout">

        <!-- SIDEBAR -->
        <aside class="docs-sidebar">
            <div class="docs-sidebar-label">On this page</div>
            <ul class="docs-nav">
                <li><a href="#overview">Overview</a></li>
                <li><a href="#install">Quick Start</a></li>
                <li><a href="#tools">The Tools</a></li>
                <li><a href="#cracker" class="docs-nav-sub">→ Cracker</a></li>
                <li><a href="#hash-maker" class="docs-nav-sub">→ Hash Maker</a></li>
                <li><a href="#key-encoder" class="docs-nav-sub">→ Key Encoder</a></li>
                <li><a href="#how-it-works">How It Works</a></li>
                <li><a href="#math">The Math</a></li>
                <li><a href="#extending">Extending</a></li>
                <li><a href="#security">Security Notes</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </aside>

        <!-- CONTENT -->
        <main class="docs-content">

            <header class="docs-header">
                <span class="page-eyebrow">Documentation</span>
                <h1 class="page-title" style="margin-top: 18px;">
                    The <em>CIPHR</em> Handbook
                    <span class="docs-version">v1.0</span>
                </h1>
                <p class="page-lede">
                    Everything you need to know about running, understanding,
                    and extending the MD5 brute-force cracker — from a
                    one-line install to the cryptography behind why this
                    attack is trivially fast.
                </p>
            </header>

            <!-- OVERVIEW -->
            <section class="docs-section" id="overview">
                <h2><span class="hash">#</span> Overview</h2>
                <p>
                    <strong>CIPHR</strong> is a small PHP web app that demonstrates
                    how brute-force attacks work against short, unsalted
                    cryptographic hashes. It accepts a 32-character MD5 digest
                    and walks the entire two-letter lowercase keyspace —
                    676 permutations — to find the original plaintext.
                </p>
                <p>
                    It exists as a teaching tool, not a production utility.
                    The point is to make tangible something most security
                    courses describe only in the abstract: <em>a hash is not
                    encryption, and a small keyspace is no secret at all.</em>
                </p>

                <div class="callout info">
                    <div class="callout-icon">i</div>
                    <div class="callout-body">
                        <strong>Built for learning</strong>
                        Every file is short, dependency-free, and intentionally
                        readable. Open them in any editor and trace the loop —
                        there's no framework magic to wade through.
                    </div>
                </div>
            </section>

            <!-- INSTALL -->
            <section class="docs-section" id="install">
                <h2><span class="hash">#</span> Quick Start</h2>
                <p>
                    CIPHR requires PHP 7.4 or newer. No database, no Composer,
                    no build step.
                </p>

                <div class="code-block">
                    <div class="code-block-header">
                        <span>terminal</span>
                        <span>bash</span>
                    </div>
<pre><code><span class="com"># clone the repository</span>
<span class="fn">git</span> clone https://github.com/&lt;you&gt;/MD5-Hash-Cracker.git
<span class="kw">cd</span> MD5-Hash-Cracker

<span class="com"># start a local server</span>
<span class="fn">php</span> -S localhost:<span class="num">8000</span>

<span class="com"># open in your browser</span>
<span class="com"># → http://localhost:8000/index.php</span></code></pre>
                </div>

                <p>
                    Prefer Apache or Nginx? Drop the folder into your web root
                    (<code>htdocs</code>, <code>www</code>, or
                    <code>/var/www/html</code>) and visit the path directly.
                </p>
            </section>

            <!-- TOOLS -->
            <section class="docs-section" id="tools">
                <h2><span class="hash">#</span> The Tools</h2>
                <p class="subtitle">
                    CIPHR ships with three small pages, each focused on one job.
                </p>

                <div class="endpoint-grid">
                    <a href="#cracker" class="endpoint-card">
                        <span class="method">GET</span>
                        <div class="path">/index.php</div>
                        <div class="desc">Reverse an MD5 hash back to its 2-letter plaintext.</div>
                    </a>
                    <a href="#hash-maker" class="endpoint-card">
                        <span class="method">GET</span>
                        <div class="path">/md5.php</div>
                        <div class="desc">Generate an MD5 digest from any input string.</div>
                    </a>
                    <a href="#key-encoder" class="endpoint-card">
                        <span class="method">GET</span>
                        <div class="path">/makecode.php</div>
                        <div class="desc">Validated 2-letter input → guaranteed crackable hash.</div>
                    </a>
                </div>

                <!-- CRACKER -->
                <h3 id="cracker">Cracker — <code>index.php</code></h3>
                <p>
                    The main attraction. Paste any 32-character MD5 hash;
                    if its plaintext is two lowercase letters, you'll see
                    it appear along with the elapsed time and attempt count.
                </p>

                <table class="param-table">
                    <thead>
                        <tr><th>Parameter</th><th>Type</th><th>Description</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>md5</td>
                            <td><span class="type">string · 32</span></td>
                            <td>The hex-encoded MD5 digest to crack. Passed via query string.</td>
                        </tr>
                    </tbody>
                </table>

                <div class="code-block">
                    <div class="code-block-header">
                        <span>example request</span>
                        <span>url</span>
                    </div>
<pre><code>/index.php?md5=<span class="str">c1a5298f939e87e8f962a5edfc206918</span>
<span class="com"># → plaintext recovered: "aa"</span></code></pre>
                </div>

                <!-- HASH MAKER -->
                <h3 id="hash-maker">Hash Maker — <code>md5.php</code></h3>
                <p>
                    A general-purpose encoder. Feed it any string; it returns
                    the 128-bit MD5 digest. Useful for sanity-checking the
                    cracker or generating arbitrary hashes for unrelated work.
                </p>

                <table class="param-table">
                    <thead>
                        <tr><th>Parameter</th><th>Type</th><th>Description</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>encode</td>
                            <td><span class="type">string</span></td>
                            <td>Any input string — no length or character restrictions.</td>
                        </tr>
                    </tbody>
                </table>

                <!-- KEY ENCODER -->
                <h3 id="key-encoder">Key Encoder — <code>makecode.php</code></h3>
                <p>
                    The "guided" encoder. It strictly validates input as
                    exactly two lowercase letters before hashing, guaranteeing
                    the output is something the cracker can actually solve.
                </p>

                <table class="param-table">
                    <thead>
                        <tr><th>Parameter</th><th>Type</th><th>Description</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>code</td>
                            <td><span class="type">string · 2</span></td>
                            <td>Two lowercase letters (a–z). Anything else returns a validation error.</td>
                        </tr>
                    </tbody>
                </table>

                <div class="callout success">
                    <div class="callout-icon">✓</div>
                    <div class="callout-body">
                        <strong>Closed loop</strong>
                        Encode → copy hash → crack. The whole round-trip
                        completes in roughly 10 milliseconds on a modern laptop.
                    </div>
                </div>
            </section>

            <!-- HOW IT WORKS -->
            <section class="docs-section" id="how-it-works">
                <h2><span class="hash">#</span> How It Works</h2>
                <p>
                    The cracker is a brute-force search — the simplest possible
                    attack against any hash function. The PHP source is
                    deliberately tiny:
                </p>

                <div class="code-block">
                    <div class="code-block-header">
                        <span>index.php — core loop</span>
                        <span>php</span>
                    </div>
<pre><code><span class="var">$txt</span> = <span class="str">"abcdefghijklmnopqrstuvwxyz"</span>;

<span class="kw">for</span> (<span class="var">$i</span> = <span class="num">0</span>; <span class="var">$i</span> &lt; strlen(<span class="var">$txt</span>); <span class="var">$i</span>++) {
    <span class="kw">for</span> (<span class="var">$j</span> = <span class="num">0</span>; <span class="var">$j</span> &lt; strlen(<span class="var">$txt</span>); <span class="var">$j</span>++) {
        <span class="var">$try</span>   = <span class="var">$txt</span>[<span class="var">$i</span>] . <span class="var">$txt</span>[<span class="var">$j</span>];
        <span class="var">$check</span> = <span class="fn">hash</span>(<span class="str">'md5'</span>, <span class="var">$try</span>);

        <span class="kw">if</span> (<span class="var">$check</span> === <span class="var">$md5</span>) {
            <span class="var">$goodtext</span> = <span class="var">$try</span>;
            <span class="kw">break</span> <span class="num">2</span>;
        }
    }
}</code></pre>
                </div>

                <p>
                    Two nested loops, one hash call per iteration, an
                    equality check, and an early exit. That's the entire
                    attack. The UI wraps it in a stat row, a terminal-style
                    trace panel, and a success/failure card — but the
                    cryptographic substance is those nine lines.
                </p>
            </section>

            <!-- MATH -->
            <section class="docs-section" id="math">
                <h2><span class="hash">#</span> The Math</h2>
                <p>
                    Keyspace size for an alphabet of <code>n</code> characters
                    and key length <code>k</code> is <code>n<sup>k</sup></code>.
                    For CIPHR's defaults:
                </p>

                <table class="param-table">
                    <thead>
                        <tr><th>Length</th><th>Lowercase</th><th>+ digits</th><th>+ uppercase</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>2</td><td>676</td><td>1,296</td><td>3,844</td></tr>
                        <tr><td>4</td><td>456,976</td><td>1,679,616</td><td>14,776,336</td></tr>
                        <tr><td>6</td><td>308,915,776</td><td>2,176,782,336</td><td>56,800,235,584</td></tr>
                        <tr><td>8</td><td>~209 billion</td><td>~2.8 trillion</td><td>~218 trillion</td></tr>
                    </tbody>
                </table>

                <p>
                    A modern CPU can compute several hundred million MD5
                    hashes per second; a consumer GPU pushes that into the
                    tens of billions. Even an 8-character lowercase password
                    falls in minutes, not years.
                </p>

                <div class="callout warn">
                    <div class="callout-icon">!</div>
                    <div class="callout-body">
                        <strong>Why length alone isn't enough</strong>
                        Doubling key length squares the keyspace, but doubling
                        attacker hardware halves the time. Length helps;
                        algorithm choice (slow, memory-hard) and salting matter more.
                    </div>
                </div>
            </section>

            <!-- EXTENDING -->
            <section class="docs-section" id="extending">
                <h2><span class="hash">#</span> Extending</h2>
                <p>Some natural next steps if you're using CIPHR as a starting point:</p>

                <h3>Larger keyspace</h3>
                <p>
                    Add uppercase, digits, or symbols to <code>$txt</code> and
                    nest more loops for longer keys. Watch the elapsed time
                    grow from milliseconds to seconds to minutes.
                </p>

                <h3>Try a different algorithm</h3>
                <p>
                    Swap <code>hash('md5', ...)</code> for <code>'sha1'</code>,
                    <code>'sha256'</code>, or — for an honest comparison —
                    PHP's <code>password_hash()</code>. The last one is
                    deliberately slow; you'll feel it immediately.
                </p>

                <h3>Add a salt</h3>
                <p>
                    Concatenate a known string before hashing in both the
                    encoder and cracker. Now your attacker needs the salt
                    too, which kills generic rainbow-table attacks.
                </p>

                <h3>Stream the full trace</h3>
                <p>
                    Remove the <code>$show</code> cap and pipe every attempt
                    into the terminal panel — useful for visualizing how the
                    search progresses, especially with larger keyspaces.
                </p>
            </section>

            <!-- SECURITY -->
            <section class="docs-section" id="security">
                <h2><span class="hash">#</span> Security Notes</h2>

                <div class="callout danger">
                    <div class="callout-icon">!</div>
                    <div class="callout-body">
                        <strong>Do not use MD5 for passwords</strong>
                        MD5 has been considered cryptographically broken since
                        the early 2000s. It's fast — which is the exact opposite
                        of what password hashing needs.
                    </div>
                </div>

                <p>
                    For real authentication, use a slow, salted, memory-hard
                    function. PHP exposes good defaults:
                </p>

                <div class="code-block">
                    <div class="code-block-header">
                        <span>recommended · production hashing</span>
                        <span>php</span>
                    </div>
<pre><code><span class="com">// store</span>
<span class="var">$hash</span> = <span class="fn">password_hash</span>(<span class="var">$password</span>, PASSWORD_ARGON2ID);

<span class="com">// verify</span>
<span class="kw">if</span> (<span class="fn">password_verify</span>(<span class="var">$input</span>, <span class="var">$hash</span>)) {
    <span class="com">// authenticated</span>
}</code></pre>
                </div>

                <p>
                    Argon2id is the current OWASP recommendation. bcrypt is
                    still acceptable. Anything that doesn't include a unique
                    salt and a deliberately slow KDF is not acceptable.
                </p>
            </section>

            <!-- FAQ -->
            <section class="docs-section" id="faq">
                <h2><span class="hash">#</span> FAQ</h2>

                <h3>Why does the cracker say "not in keyspace"?</h3>
                <p>
                    The hash you submitted isn't an MD5 of any two-letter
                    lowercase string. It might be a real password hash, a
                    file checksum, or random data — none of which this
                    676-key search can reverse.
                </p>

                <h3>Is this exploit code?</h3>
                <p>
                    No. It's a self-contained demonstration that only ever
                    operates against hashes you generate yourself. There's
                    no network access, no dictionary, no list of leaked
                    passwords.
                </p>

                <h3>Can I deploy this publicly?</h3>
                <p>
                    Sure — it has no security implications since the entire
                    "attack" can be reproduced in a few lines of any language.
                    Just don't represent it as a real cracking service.
                </p>

                <h3>Why PHP?</h3>
                <p>
                    Because it's the lowest-friction way to ship a working
                    web app: no build step, no framework, runs on every
                    shared host on earth. The whole thing is about 100 lines.
                </p>
            </section>

            <!-- BUTTON ROW -->
            <div class="button-row">
                <button type="button" class="btn-sm" onclick="window.location.href='index.php'"><span class="icon">←</span> Back to Cracking</button>
                <button type="button" class="btn-sm" onclick="window.location.href='md5.php'"><span class="icon">→</span> Hash Maker</button>
                <button type="button" class="btn-sm" onclick="window.location.href='makecode.php'"><span class="icon">→</span> Key Encoder</button>
            </div>

        </main>
    </div>

</div>

<script>
    // smooth-scroll sidebar links
    document.querySelectorAll('.docs-nav a').forEach(link => {
        link.addEventListener('click', e => {
            const id = link.getAttribute('href');
            if (id && id.startsWith('#')) {
                const target = document.querySelector(id);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
</script>

</body>
</html>
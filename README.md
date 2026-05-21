# CIPHR · MD5 Hash Cracker

> A lightweight PHP playground that demonstrates why short, unsalted hashes
> are not secrets. Submit any MD5 digest of a two-character lowercase string
> and watch the engine walk the entire 676-permutation keyspace in
> milliseconds.

Built as a hands-on teaching tool for security fundamentals — hashing,
brute-force, and the difference between *one-way* and *infeasible-to-reverse*.

---

## ✦ Live demo

**v0.0.1 is deployed and live:**
🔗 **[ciphr-md5-hash-cracker.infinityfreeapp.com](https://ciphr-md5-hash-cracker.infinityfreeapp.com/?i=1)**

Try the full round-trip in 30 seconds:

1. Open the **Key Encoder** page, type any two lowercase letters → copy the hash
2. Paste it into the **Cracker** → watch the plaintext recover in milliseconds

> Hosted on InfinityFree. The free tier may sleep briefly if idle —
> first load can take a moment, subsequent navigation is instant.

---

## ✦ What's inside

The app ships as three small PHP pages, all sharing one stylesheet:

| Page | Purpose |
| --- | --- |
| **`index.php`** — Cracker | Paste a 32-character MD5 hash, get the original 2-letter plaintext (or "not in keyspace"), with a live execution trace. |
| **`md5.php`** — Hash Maker | Free-form string → MD5 digest. Useful for generating test inputs. |
| **`makecode.php`** — Key Encoder | A validated two-letter input that produces a digest guaranteed to be crackable by `index.php`. |

A typical demo loop:

```
makecode.php   →   copy hash   →   index.php   →   recovered in ~10 ms
```

---

## ✦ Why this works (the boring math)

The lowercase English alphabet has **26 letters**. A two-character key
therefore has only **26 × 26 = 676** possible values. Every modern laptop
can compute hundreds of millions of MD5 hashes per second, so the entire
keyspace is exhausted faster than the page can paint.

The same attack against a six-character lowercase key would require
~308 million hashes — still trivially fast. Even ten lowercase characters
falls within reach of a single GPU in under a day. **This is the point of
the demo:** length, character class, and *salting* are what make hashes
hard to reverse — not the algorithm alone.

---

## ✦ Quick start

**Requirements:** PHP 7.4+ (8.x recommended). No external dependencies, no
database, no composer.

```bash
# clone & enter
git clone https://github.com/<you>/MD5-Hash-Cracker.git
cd MD5-Hash-Cracker

# serve locally
php -S localhost:8000

# open in your browser
http://localhost:8000/index.php
```

That's it. Drop the folder into any LAMP/XAMPP/MAMP `htdocs` directory if
you'd rather run it under Apache.

---

## ✦ Walkthrough

1. Open **Key Encoder** (`makecode.php`).
2. Type any two lowercase letters — `xq`, `mn`, `zz`.
3. Copy the resulting 32-character hash.
4. Open **Cracker** (`index.php`), paste the hash, hit **Initialize Crack**.
5. Watch the trace: a sample of attempted hashes, then the recovered
   plaintext with the number of attempts and elapsed milliseconds.

The trace deliberately shows only the first 15 attempts to keep the page
readable. Toggle `$show` in `index.php` if you want to see more.

---

## ✦ Design

The UI is a dark, glass-morphic dashboard inspired by modern cybersecurity
product landing pages. Highlights:

- Pure CSS liquid-chrome orb (no images, no JS) as the hero visual
- Pill inputs and CTAs with cyan focus glow
- Terminal-style execution log with traffic-light header
- Success / failure result cards with gradient text accents
- Floating annotation chips around the orb (Hash Engine · Search Vector · Keyspace)
- Subtle film-grain overlay, animated brand pulse, ambient float on the orb

Everything lives in one `style.css` file with CSS variables, so retheming
is a matter of changing the `--cyan` and `--bg-*` tokens at the top.

---

## ✦ File layout

```
.
├── index.php       # the cracker (hero page)
├── md5.php         # general-purpose hash maker
├── makecode.php    # validated 2-letter encoder
├── style.css       # all visual styling, CSS variables, animations
└── README.md       # you are here
```

---

## ✦ Extending it

Some easy starter modifications:

- **Larger keyspace.** Add uppercase, digits, or a third character. Wrap
  the nested loop in `index.php` accordingly and watch the elapsed time grow.
- **Different algorithm.** Swap `hash('md5', ...)` for `sha1`, `sha256`, or
  even the slow `password_hash()` to feel the difference.
- **Add a salt.** Concatenate a known prefix before hashing in both the
  encoder and cracker — this is how real systems blunt rainbow-table attacks.
- **Show full trace.** Remove the `$show` cap and stream every attempt to
  the terminal panel.

---

## ✦ ⚠ Security note

MD5 has been considered cryptographically broken for password storage since
the early 2000s. **Do not use MD5 — or any unsalted fast hash — for real
authentication.** Use a slow, salted, memory-hard function such as
**Argon2id** or **bcrypt** via PHP's built-in `password_hash()`.

This project is for education only.

---

## ✦ License

MIT — do whatever you'd like, including using the UI as a starting point
for your own dashboards.

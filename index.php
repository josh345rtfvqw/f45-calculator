<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<script>try{var t=localStorage.getItem('theme');if(t==='light'||t==='dark')document.documentElement.setAttribute('data-theme',t);}catch(e){}</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>F45 Playoffs Score Calculator</title>
<meta name="description" content="Calculate your F45 Playoffs score in seconds. Enter your result for each station, see your total out of 1,000 instantly, and compare it on the leaderboard." />
<meta name="author" content="Joshua Spires" />
<link rel="canonical" href="https://joshspires.com.au/projects/f45-calculator/" />
<link rel="icon" type="image/svg+xml" href="assets/favicon.svg" />
<link rel="icon" type="image/png" sizes="96x96" href="assets/favicon-96x96.png" />
<link rel="shortcut icon" href="assets/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png" />
<meta property="og:title" content="F45 Playoffs Score Calculator" />
<meta property="og:description" content="Enter your result for each station and see your total out of 1,000 instantly." />
<meta property="og:image" content="https://joshspires.com.au/projects/f45-calculator/assets/f45-playoffs-calculator.avif" />
<meta property="og:url" content="https://joshspires.com.au/projects/f45-calculator/" />
<meta property="og:type" content="website" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700&family=Hanken+Grotesk:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="/style.css" />
<link rel="stylesheet" href="f45.css" />
<script src="assets/scripts.js" defer></script>
<script src="/theme-toggle.js" defer></script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "F45 Playoffs Score Calculator",
  "description": "Calculate your F45 Playoffs score in seconds. Enter your result for each station, see your total out of 1,000 instantly, and compare it on the leaderboard.",
  "url": "https://joshspires.com.au/projects/f45-calculator/",
  "applicationCategory": "SportsApplication",
  "operatingSystem": "Any (web browser)",
  "offers": { "@type": "Offer", "price": "0", "priceCurrency": "AUD" },
  "author": { "@type": "Person", "name": "Joshua Spires", "url": "https://joshspires.com.au" }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How is my F45 Playoffs score calculated?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Each of the 10 stations has a fixed multiplier set by F45. Your result for a station (metres or reps) is multiplied by that value, and the ten results are added together for a final score out of 1,000."
      }
    },
    {
      "@type": "Question",
      "name": "Is this an official F45 tool?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No — this calculator isn't affiliated with, endorsed by, or connected to F45 Training. It's an independent tool built for the F45 community."
      }
    },
    {
      "@type": "Question",
      "name": "Is my data private?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Only your per-station scores and total are stored, to build the leaderboard. No personal data — name, email, or device information — is collected."
      }
    },
    {
      "@type": "Question",
      "name": "Can I calculate my score more than once?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Every calculation is saved to the leaderboard as a new entry, so feel free to recalculate as your training improves."
      }
    }
  ]
}
</script>
</head>
<body>

<header class="nav shell">
  <nav aria-label="Primary">
    <ul>
      <li><a href="/">&larr; Joshua Spires</a></li>
      <li><a href="/projects/f45-calculator/" aria-current="page">Calculator</a></li>
      <li><a href="#how">How it works</a></li>
      <li><a href="#faq">FAQ</a></li>
      <li><a href="stats.php">Season stats</a></li>
      <li><a href="#leaderboard">Leaderboard</a></li>
      <li><button type="button" class="theme-toggle" data-theme-toggle>Dark</button></li>
    </ul>
  </nav>
</header>

<main class="shell">

  <section class="hero" aria-labelledby="h1">
    <h1 id="h1">F45 Playoffs Score Calculator</h1>
    <p class="sub">Enter your result for each station and see your total out of 1,000 — then check where it lands on the leaderboard.</p>
  </section>

  <section id="calculator" aria-labelledby="calc-h">
    <div class="sec-head">
      <span class="kicker">2024&ndash;25 season</span>
      <h2 class="title" id="calc-h">Your score.</h2>
    </div>
    <div class="sheet">
      <div class="f45-form">
        <div class="f45-row">
          <label for="one">1. Rower</label>
          <span class="target">Target: 290 m</span>
          <input class="form-input" id="one" type="number" inputmode="numeric" min="0" max="290" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="two">2. Bench Hops</label>
          <span class="target">Target: 95 reps</span>
          <input class="form-input" id="two" type="number" inputmode="numeric" min="0" max="95" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="three">3. Suspension Trainer Push Up &amp; Knee Tuck</label>
          <span class="target">Target: 57 reps</span>
          <input class="form-input" id="three" type="number" inputmode="numeric" min="0" max="57" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="four">4. 5 Cone Lateral Hop</label>
          <span class="target">Target: 130 reps</span>
          <input class="form-input" id="four" type="number" inputmode="numeric" min="0" max="130" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="five">5. Box Jump Burpee</label>
          <span class="target">Target: 20 reps</span>
          <input class="form-input" id="five" type="number" inputmode="numeric" min="0" max="20" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="six">6. Chin Ups</label>
          <span class="target">Target: 25 reps</span>
          <input class="form-input" id="six" type="number" inputmode="numeric" min="0" max="25" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="seven">7. Barbell Squat Press</label>
          <span class="target">Target: 36 reps</span>
          <input class="form-input" id="seven" type="number" inputmode="numeric" min="0" max="36" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="eight">8. MB Russian Twists</label>
          <span class="target">Target: 87 reps</span>
          <input class="form-input" id="eight" type="number" inputmode="numeric" min="0" max="87" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="nine">9. Dead Ball Drop Over Shoulder</label>
          <span class="target">Target: 27 reps</span>
          <input class="form-input" id="nine" type="number" inputmode="numeric" min="0" max="27" placeholder="0" />
        </div>
        <div class="f45-row">
          <label for="ten">10. Hurdle Hop Sprint</label>
          <span class="target">Target: 15 reps</span>
          <input class="form-input" id="ten" type="number" inputmode="numeric" min="0" max="15" placeholder="0" />
        </div>
      </div>

      <div class="f45-total">
        <span class="label">Total</span>
        <span id="showdata"></span>
        <span id="message"></span>
      </div>

      <div class="f45-rank" id="rankBox" hidden>
        <p id="rankText"></p>
        <button class="btn" type="button" onclick="shareScore()">Share your score</button>
      </div>

      <div class="btn-row">
        <button class="btn" type="button" onclick="calculate()">Calculate score</button>
        <button class="btn secondary" type="button" onclick="resetInputs()">Reset</button>
      </div>

      <p class="f45-note">
        Only your per-station scores and total are stored, to build the leaderboard &mdash;
        no personal data is collected. Not affiliated with F45. &middot; v3.6
      </p>
    </div>
  </section>

  <section id="how" aria-labelledby="how-h">
    <div class="sec-head">
      <span class="kicker">How it works</span>
      <h2 class="title" id="how-h">How the scoring works.</h2>
    </div>
    <div class="sheet prose">
      <p>
        Enter your result for each station &mdash; metres or reps completed. Each is
        multiplied by a value set by F45, and the ten results are added for a final
        score out of 1,000. It&rsquo;s a standardised way to track your performance
        over time.
      </p>
      <table>
        <thead>
          <tr><th scope="col">Station</th><th scope="col">Multiplier</th></tr>
        </thead>
        <tbody>
          <tr><td>1 &middot; Rower</td><td>0.3448</td></tr>
          <tr><td>2 &middot; Bench Hops</td><td>1.0526</td></tr>
          <tr><td>3 &middot; Suspension Trainer Push Up &amp; Knee Tuck</td><td>1.7544</td></tr>
          <tr><td>4 &middot; 5 Cone Lateral Hop</td><td>0.7692</td></tr>
          <tr><td>5 &middot; Box Jump Burpee</td><td>5.0000</td></tr>
          <tr><td>6 &middot; Chin Ups</td><td>4.0000</td></tr>
          <tr><td>7 &middot; Barbell Squat Press</td><td>2.7778</td></tr>
          <tr><td>8 &middot; MB Russian Twists</td><td>1.1494</td></tr>
          <tr><td>9 &middot; Dead Ball Drop Over Shoulder</td><td>3.7037</td></tr>
          <tr><td>10 &middot; Hurdle Hop Sprint</td><td>6.6667</td></tr>
        </tbody>
      </table>
      <p class="f45-note">Multipliers shown rounded; the calculator uses full precision.</p>
    </div>
  </section>

  <section id="faq" aria-labelledby="faq-h">
    <div class="sec-head">
      <span class="kicker">FAQ</span>
      <h2 class="title" id="faq-h">Questions people ask.</h2>
    </div>
    <div class="sheet prose">
      <h3>How is my F45 Playoffs score calculated?</h3>
      <p>Each of the 10 stations has a fixed multiplier set by F45. Your result for a station (metres or reps) is multiplied by that value, and the ten results are added together for a final score out of 1,000.</p>

      <h3>Is this an official F45 tool?</h3>
      <p>No &mdash; this calculator isn&rsquo;t affiliated with, endorsed by, or connected to F45 Training. It&rsquo;s an independent tool built for the F45 community.</p>

      <h3>Is my data private?</h3>
      <p>Only your per-station scores and total are stored, to build the leaderboard. No personal data &mdash; name, email, or device information &mdash; is collected.</p>

      <h3>Can I calculate my score more than once?</h3>
      <p>Yes. Every calculation is saved to the leaderboard as a new entry, so feel free to recalculate as your training improves.</p>
    </div>
  </section>

  <section id="leaderboard" aria-labelledby="lb-h">
    <div class="sec-head">
      <span class="kicker">Leaderboard</span>
      <h2 class="title" id="lb-h">Top 10.</h2>
    </div>
    <div class="sheet prose">
      <?php include __DIR__ . '/leaderboard.php'; ?>
      <p><a href="stats.php">See full season stats &rarr;</a> &mdash; average score per station, the score spread, and which station trips people up most.</p>
    </div>
  </section>

</main>

<footer class="foot shell">
  F45 Playoffs Score Calculator &middot; a project by <a href="/" style="color:inherit;">Joshua Spires</a> &middot; not affiliated with F45
</footer>

</body>
</html>

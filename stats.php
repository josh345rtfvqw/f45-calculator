<?php
// Load database configuration
$config = include('db_config.php');
$conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Each station's raw result is already weighted to a max of 100 before it's
// stored (see assets/scripts.js), so score_one..score_ten are directly
// comparable to each other regardless of the station's own units.
$stationLabels = [
    'score_one'   => 'Rower',
    'score_two'   => 'Bench Hops',
    'score_three' => 'Suspension Trainer Push Up & Knee Tuck',
    'score_four'  => '5 Cone Lateral Hop',
    'score_five'  => 'Box Jump Burpee',
    'score_six'   => 'Chin Ups',
    'score_seven' => 'Barbell Squat Press',
    'score_eight' => 'MB Russian Twists',
    'score_nine'  => 'Dead Ball Drop Over Shoulder',
    'score_ten'   => 'Hurdle Hop Sprint',
];

$avgCols = implode(', ', array_map(fn($c) => "AVG($c) AS avg_$c", array_keys($stationLabels)));

$summary = $conn->query("
    SELECT
        COUNT(*)         AS total,
        AVG(total_score) AS avg_total,
        MAX(total_score) AS max_total,
        MIN(total_score) AS min_total,
        $avgCols
    FROM scores
")->fetch_assoc();

$distribution = $conn->query("
    SELECT
        SUM(total_score >= 800)                              AS b_800,
        SUM(total_score >= 600 AND total_score < 800)        AS b_600,
        SUM(total_score >= 400 AND total_score < 600)        AS b_400,
        SUM(total_score < 400)                               AS b_low
    FROM scores
")->fetch_assoc();

$conn->close();

$total = (int) ($summary['total'] ?? 0);

// Build the per-station rows, sorted from hardest (lowest average) to easiest.
$stationRows = [];
foreach ($stationLabels as $col => $label) {
    $avg = $total > 0 ? (float) $summary['avg_' . $col] : 0.0;
    $stationRows[] = ['label' => $label, 'avg' => $avg];
}
usort($stationRows, fn($a, $b) => $a['avg'] <=> $b['avg']);

function h($v) { return htmlspecialchars((string) $v, ENT_QUOTES); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<script>try{var t=localStorage.getItem('theme');if(t==='light'||t==='dark')document.documentElement.setAttribute('data-theme',t);}catch(e){}</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>F45 Playoffs 2024&ndash;25 Season Stats</title>
<meta name="description" content="Average score per station, the overall score spread, and which F45 Playoffs station trips people up most &mdash; based on every score submitted to this calculator." />
<meta name="author" content="Joshua Spires" />
<link rel="canonical" href="https://joshspires.com.au/projects/f45-calculator/stats.php" />
<link rel="icon" type="image/svg+xml" href="assets/favicon.svg" />
<link rel="icon" type="image/png" sizes="96x96" href="assets/favicon-96x96.png" />
<link rel="shortcut icon" href="assets/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png" />
<meta property="og:title" content="F45 Playoffs 2024&ndash;25 Season Stats" />
<meta property="og:description" content="Average score per station, the score spread, and which station trips people up most." />
<meta property="og:image" content="https://joshspires.com.au/projects/f45-calculator/assets/f45-playoffs-calculator.avif" />
<meta property="og:url" content="https://joshspires.com.au/projects/f45-calculator/stats.php" />
<meta property="og:type" content="website" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700&family=Hanken+Grotesk:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="/style.css" />
<link rel="stylesheet" href="f45.css" />
<script src="/theme-toggle.js" defer></script>
</head>
<body>

<header class="nav shell">
  <nav aria-label="Primary">
    <ul>
      <li><a href="/">&larr; Joshua Spires</a></li>
      <li><a href="/projects/f45-calculator/">Calculator</a></li>
      <li><a href="/projects/f45-calculator/#faq">FAQ</a></li>
      <li><a href="stats.php" aria-current="page">Season stats</a></li>
      <li><a href="/projects/f45-calculator/#leaderboard">Leaderboard</a></li>
      <li><button type="button" class="theme-toggle" data-theme-toggle>Dark</button></li>
    </ul>
  </nav>
</header>

<main class="shell">

  <section class="hero" aria-labelledby="h1">
    <h1 id="h1">2024&ndash;25 season stats</h1>
    <p class="sub">Pulled from every score submitted to this calculator's leaderboard &mdash; not an official F45 statistic, just what people actually enter.</p>
  </section>

  <?php if ($total === 0): ?>
    <section>
      <div class="sheet prose">
        <p>No scores logged yet &mdash; <a href="/projects/f45-calculator/">calculate yours</a> to be the first on the board.</p>
      </div>
    </section>
  <?php else: ?>

  <section id="overview" aria-labelledby="overview-h">
    <div class="sec-head">
      <span class="kicker">Overview</span>
      <h2 class="title" id="overview-h">By the numbers.</h2>
    </div>
    <div class="stats">
      <div class="stat"><div class="n"><?= number_format($total) ?></div><div class="l">Scores logged<br />this season</div></div>
      <div class="stat"><div class="n"><?= number_format((float) $summary['avg_total'], 1) ?></div><div class="l">Average total<br />out of 1,000</div></div>
      <div class="stat"><div class="n"><?= number_format((float) $summary['max_total'], 1) ?></div><div class="l">Highest score<br />logged so far</div></div>
      <div class="stat"><div class="n"><?= number_format((float) $summary['min_total'], 1) ?></div><div class="l">Lowest score<br />logged so far</div></div>
    </div>
  </section>

  <section id="stations" aria-labelledby="stations-h">
    <div class="sec-head">
      <span class="kicker">By station</span>
      <h2 class="title" id="stations-h">Where people lose the most points.</h2>
    </div>
    <div class="sheet">
      <p style="margin-bottom:1.4rem;color:var(--text-dim);">Every station is worth 100 points at its target, so these are directly comparable &mdash; lower means it's costing people more points on average.</p>
      <?php foreach ($stationRows as $i => $row): ?>
        <div class="f45-stat-row">
          <span class="f45-stat-label"><?= h($i + 1) ?>. <?= h($row['label']) ?></span>
          <div class="f45-stat-track"><div class="f45-stat-fill" style="width:<?= number_format(max(0, min(100, $row['avg'])), 1) ?>%"></div></div>
          <span class="f45-stat-value"><?= number_format($row['avg'], 1) ?> / 100</span>
        </div>
      <?php endforeach; ?>
      <p class="f45-note">
        Hardest on average: <strong><?= h($stationRows[0]['label']) ?></strong>.
        Easiest on average: <strong><?= h(end($stationRows)['label']) ?></strong>.
      </p>
    </div>
  </section>

  <section id="spread" aria-labelledby="spread-h">
    <div class="sec-head">
      <span class="kicker">Score spread</span>
      <h2 class="title" id="spread-h">Where scores land.</h2>
    </div>
    <div class="stats">
      <div class="stat"><div class="n"><?= (int) $distribution['b_800'] ?></div><div class="l">Scored<br />800&ndash;1,000</div></div>
      <div class="stat"><div class="n"><?= (int) $distribution['b_600'] ?></div><div class="l">Scored<br />600&ndash;799</div></div>
      <div class="stat"><div class="n"><?= (int) $distribution['b_400'] ?></div><div class="l">Scored<br />400&ndash;599</div></div>
      <div class="stat"><div class="n"><?= (int) $distribution['b_low'] ?></div><div class="l">Scored<br />under 400</div></div>
    </div>
  </section>

  <?php endif; ?>

  <section id="back" aria-labelledby="back-h">
    <div class="sheet prose">
      <p><a href="/projects/f45-calculator/">&larr; Back to the calculator</a> to log your own score, or see the <a href="/projects/f45-calculator/#leaderboard">Top 10 leaderboard</a>.</p>
    </div>
  </section>

</main>

<footer class="foot shell">
  F45 Playoffs Score Calculator &middot; a project by <a href="/" style="color:inherit;">Joshua Spires</a> &middot; not affiliated with F45
</footer>

</body>
</html>

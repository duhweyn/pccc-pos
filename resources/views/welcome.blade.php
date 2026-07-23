<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petron CCC Car Care Center - Biñan</title>
  <link rel="stylesheet" href="{{ asset( 'petron/css/landing.css' ) }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HERO -->
  <section class="hero">
    <img class="hero-logo" src="{{ asset( 'petron/img/logo1-lighter.png' ) }}" alt="Petron CCC Car Care Center logo">
    <p class="hero-eyebrow">Biñan, Laguna</p>
    <h1>Your Car's <span>Pit Stop</span> in Biñan</h1>
    <p>Oil changes, alignment, suspension, tires, aircon, and brakes — handled by the same crew, every visit. Book your slot online in under a minute.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="{{ ns()->route( 'ns.login' ) }}">Member Login</a>
      <a class="btn btn-ghost" href="#services">See services</a>
    </div>
  </section>

  <div class="hazard-divider"></div>

  <!-- SERVICES -->
  <section class="services" id="services">
    <div class="section-head">
      <p class="eyebrow">What we service</p>
      <h2>Everything your car needs, under one roof</h2>
      <p>From routine maintenance to full diagnostics — placeholder copy, swap in your actual service list and pricing when ready.</p>
    </div>

    <div class="service-grid">
      <div class="service-card">
        <span class="service-code">LOF</span>
        <h3>Change Oil / Greasing</h3>
        <p>Engine oil and filter replacement paired with grease points serviced for reduced wear.</p>
      </div>

      <div class="service-card">
        <span class="service-code">ALGN</span>
        <h3>Wheel Alignment &amp; Balancing</h3>
        <p>Precision alignment and balancing for a smoother, safer ride.</p>
      </div>

      <div class="service-card">
        <span class="service-code">SUSP</span>
        <h3>Under Chassis / Suspension</h3>
        <p>Full chassis inspection and suspension repair or replacement.</p>
      </div>

      <div class="service-card">
        <span class="service-code">TIRE</span>
        <h3>Pneumatic Tire Changer</h3>
        <p>Tire mounting, replacement, and pressure checks done right.</p>
      </div>

      <div class="service-card">
        <span class="service-code">T/S</span>
        <h3>Tune-Up / Scanning</h3>
        <p>Full engine tune-up paired with computerized scanning to catch issues early.</p>
      </div>

      <div class="service-card">
        <span class="service-code">BRK</span>
        <h3>Brake System</h3>
        <p>Pad replacement, rotor resurfacing, and full brake inspection.</p>
      </div>

      <div class="service-card">
        <span class="service-code">ATF</span>
        <h3>ATF Exchanger</h3>
        <p>Automatic transmission fluid flush and exchange for smoother, longer-lasting shifts.</p>
      </div>
    </div>

  </section>

  <!-- CTA BAND -->
  <section class="cta-band">
    <h2>Ready to book your next service?</h2>
    <p>Create an account to track your service history and book faster next time.</p>
    <div class="cta-actions">
      <a class="btn btn-light" href="{{ ns()->route( 'ns.login' ) }}">Login</a>
      <a class="btn btn-ghost" href="{{ ns()->route( 'ns.register' ) }}">Create account</a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-inner">
      <div class="footer-brand">
        <img src="{{ asset( 'petron/img/logo1-lighter.png' ) }}" alt="Petron CCC logo">
        <span>PETRON CCC — CAR CARE CENTER<br>Biñan, Laguna</span>
      </div>
      <div class="footer-meta">
        <a href="#">Placeholder address</a>
        <a href="#">Placeholder phone</a>
        <a href="#">Facebook</a>
      </div>
    </div>
  </footer>

</body>
</html>

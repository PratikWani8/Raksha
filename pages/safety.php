<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <title>Safety Tips - Raksha</title>

  <!-- META TAGS -->
<meta name="title" content="Raksha - Women Safety & Emergency Protection System">
<meta name="description" content="Raksha is a smart women safety platform for SOS alerts, emergency support, live location sharing, and nearby police assistance. Stay safe, stay empowered.">

<meta name="keywords" content="women safety, SOS alert system, emergency help for women, Raksha safety app, women security platform">

<meta name="author" content="Raksha Team">
<meta name="robots" content="index, follow">

<meta property="og:type" content="website">
<meta property="og:title" content="Raksha - Women Safety & Emergency Protection System">
<meta property="og:description" content="Smart platform for women's safety with instant SOS alerts, live tracking, and police support.">

<meta name="theme-color" content="#e91e63">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../index.css" />
  <link rel="stylesheet" href="../bot/chatbot.css" />
  <link rel="icon" href="../assets/favicon.jpg" type="image/x-icon" />
 
</head>
<body>

  <!-- Banner -->
  <div class="top-banner">
    <p>🚨 Emergency Helpline: 112 | Women Helpline: 181 | Need Help Urgently?</p>
    <a href="../user/non_reg_sos.php">
    <button>Get Help</button>
    </a>
  </div>

  <!-- Navbar -->
  <header>
    <div class="nav-container">

      <div class="logo">Raksha</div>

      <nav>
        <a href="../index.php">Home</a>
        <a href="safety.php">Safety Tips</a>
        <a href="police.php">Nearby Police</a>
        <a href="../auth/register.php">User</a>
        <a href="../admin/admin_login.php">Admin</a>
      </nav>
      <a href="../auth/register.php">
      <button class="start-btn">Start Protection</button>
      </a>

    </div>
  </header>

  <!-- Safety Tips Section -->
  <section class="hero">

  <div class="hero-left">

    <div class="badge">
      📘 Stay Alert • Stay Safe • Stay Strong
    </div>

    <h1>
      Essential <span style="font-family: 'Audiowide', cursive;">Safety Tips</span><br>
      for Women
    </h1>

    <p>
      Follow these simple safety guidelines to protect yourself
      and stay confident in every situation.
    </p>

      <button class="primary-btn" onclick="document.getElementById('tips').scrollIntoView({ behavior: 'smooth' });">Get Started ➞</button>
      
    <a href="police.php">
      <button class="secondary-btn">Nearby Police</button>
      </a>
      
    </div>

    <div class="hero-right">
      <img src="../assets/safety.png" alt="Safety Tips Illustration">
    </div>

  </section>

  <!-- Tips Cards -->
  <section class="tips-container" id="tips">

    <div class="tip-card">
      <h3>📱 Keep Emergency Contacts</h3>
      <p>
        Save important contacts on speed dial and share
        your location with trusted people.
      </p>
    </div>

    <div class="tip-card">
      <h3>🚶 Stay Aware of Surroundings</h3>
      <p>
        Avoid using headphones or phone excessively
        while walking in public places.
      </p>
    </div>

    <div class="tip-card">
      <h3>🌙 Avoid Isolated Areas</h3>
      <p>
        Choose well-lit routes and crowded places,
        especially at night.
      </p>
    </div>

    <div class="tip-card">
      <h3>🔐 Secure Your Online Presence</h3>
      <p>
        Do not share personal information
        on social media publicly.
      </p>
    </div>

    <div class="tip-card">
      <h3>🗣 Learn Self-Defense</h3>
      <p>
        Basic self-defense training helps build
        confidence and quick response.
      </p>
    </div>

    <div class="tip-card">
      <h3>🚨 Trust Your Instincts</h3>
      <p>
        If something feels wrong, leave immediately
        and seek help.
      </p>
    </div>

  </section>

  <!-- Chatbot -->
   <div id="chat-container" class="chatbot-wrapper">

<div class="chat-header">
<span>🤖 Raksha AI</span>
</div>

<div id="chat-box" class="chat-content" style="display:flex; flex-direction:column;">
<div class="msg bot-msg">
Hello! I am Raksha AI, your Women Safety Assistant. How can I help you?
</div>
</div>

<div class="chat-input-area">

<input type="text" id="user-input"
placeholder="Ask about safety..."
onkeypress="if(event.key==='Enter') sendMessage()">

<button class="mic-btn" onclick="startVoiceInput()">
    <svg viewBox="0 0 24 24" width="22" height="22">
        <path fill="currentColor" d="M12 14a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3zm5-3a5 5 0 0 1-10 0H5a7 7 0 0 0 14 0h-2zm-5 8a7 7 0 0 0 7-7h-2a5 5 0 0 1-10 0H5a7 7 0 0 0 7 7z"/>
    </svg>
</button>

 <button class="send-btn" onclick="sendMessage()">
        <svg viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
        </svg>
    </button>

</div>

</div>

<button class="chat-toggle-btn" onclick="toggleChat()">
    <div class="chat-btn-inner">
        
        <span class="ping"></span>

        <img src="../assets/raksha_ai_pfp.jpg" alt="chatbot" class="bot-img">

        <span class="status-dot"></span>

    </div>
</button>

  <!-- Footer -->
   <footer style="text-align:center; padding:15px; color:#666; background:white; margin-top:30px;">
  © <?php echo date("Y"); ?> Raksha - Women Safety System | Designed for Safety • Security • Empowerment for Women | All Rights Reserved.
</footer>

<script src="https://unpkg.com/lucide@latest"></script>
<script src="../bot/chatbot.js"></script>
<script>
   lucide.createIcons();

  const links = document.querySelectorAll("nav a");
  const currentPage = window.location.pathname.split("/").pop();

  links.forEach(link => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active");
    }
  });

</script>

</body>
</html>

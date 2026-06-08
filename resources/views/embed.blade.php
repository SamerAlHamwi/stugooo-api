<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>عرض الفيديو</title>
  <style>
    :root {
      color-scheme: dark;
      font-family: "Segoe UI", Tahoma, Arial, sans-serif;
      background: #111827;
      color: #f9fafb;
    }

    * {
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      margin: 0;
      display: grid;
      place-items: center;
      padding: 24px;
      background:
        linear-gradient(135deg, rgba(20, 184, 166, 0.18), transparent 36%),
        linear-gradient(315deg, rgba(239, 68, 68, 0.14), transparent 38%),
        #111827;
    }

    main {
      width: min(100%, 960px);
    }

    h1 {
      margin: 0 0 18px;
      font-size: clamp(1.5rem, 4vw, 2.5rem);
      font-weight: 700;
      text-align: center;
    }

    .video-frame {
      position: relative;
      width: 100%;
      aspect-ratio: 16 / 9;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 8px;
      box-shadow: 0 24px 70px rgba(0, 0, 0, 0.42);
      background: #000;
    }

    iframe {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      border: 0;
    }

    .actions {
      display: flex;
      justify-content: center;
      margin-top: 18px;
    }

    .youtube-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 44px;
      padding: 0 18px;
      border-radius: 8px;
      background: #dc2626;
      color: #fff;
      font-weight: 700;
      text-decoration: none;
      transition: background 160ms ease, transform 160ms ease;
    }

    .youtube-link:hover,
    .youtube-link:focus-visible {
      background: #b91c1c;
      transform: translateY(-1px);
    }
  </style>
</head>
<body>
  <main>
    <h1>عرض الفيديو</h1>
    <div class="video-frame">
      <iframe
        id="youtube-player"
        title="YouTube video player"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="origin-when-cross-origin"
        allowfullscreen>
      </iframe>
    </div>
    <div class="actions">
      <a class="youtube-link" href="https://www.youtube.com/watch?v=nT7YCf9uSoY" target="_blank" rel="noopener">
        فتح الفيديو على YouTube
      </a>
    </div>
  </main>
  <script>
    const player = document.getElementById("youtube-player");
    const params = new URLSearchParams({
      rel: "0",
      playsinline: "1"
    });

    if (window.location.origin && window.location.origin !== "null") {
      params.set("origin", window.location.origin);
    }

    player.src = `https://www.youtube.com/embed/nT7YCf9uSoY?${params}`;
  </script>
</body>
</html>

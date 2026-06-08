<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>STUGOOO - Zoho Auth</title>
  <style>
    body {
      margin: 0;
      font-family: "Inter", sans-serif;
      background-color: #0d0d0d;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .card {
      background-color: #1a1a1a;
      padding: 40px;
      border-radius: 12px;
      width: 380px;
      text-align: center;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
    }

    .title {
      font-size: 1.6rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #a0a0a0;
      font-size: 1rem;
      margin-bottom: 25px;
    }

    .success {
      color: #4ade80;
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .error {
      color: #f87171;
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .button {
      background-color: #9333ea;
      border: none;
      color: white;
      padding: 12px;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #7e22ce;
    }

    .fade-in {
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="card fade-in">
    <h1 class="title">STUGOOO</h1>

    <div id="result">
      <p class="info">Durum kontrol ediliyor...</p>
    </div>
  </div>

  <script>
    const params = new URLSearchParams(window.location.search);
    const success = params.get("success");
    const message = params.get("message") || "";
    const locale = params.get("locale") || "en";
    const messages = {
      "en": {
        "success": "Your account is successfully linked to Zoho",
        "error": "Failed to link your account to Zoho",
        "errorMessage": "An error occurred while linking your account to Zoho, please try again later.",
        "subtitle": "Zoho Auth Result",
        "canUseZohoServices": "You can now use Zoho services directly from STUGOOO 🚀",
        "info": "Checking status...",
        "button": "Go Home",
        "tryAgain": "Try Again",
        "noValidResult": "No valid result found",
        "checkYourLink": "Check your link or try again.",
      },
      "tr": {
        "success": "Hesabınız başarıyla Zoho'ya bağlandı",
        "error": "Hesabınızı Zoho'ya bağlamada hata oluştu",
        "errorMessage": "Hesabınızı Zoho'ya bağlamada hata oluştu, lütfen daha sonra tekrar deneyin.",
        "subtitle": "Zoho Auth Sonucu",
        "canUseZohoServices": "Zoho hizmetlerini doğrudan STUGOOO'dan kullanabilirsiniz 🚀",
        "info": "Durum kontrol ediliyor...",
        "button": "Ana Sayfaya Dön",
        "tryAgain": "Tekrar Deneyin",
        "noValidResult": "Geçerli bir sonuç bulunamadı",
        "checkYourLink": "Bağlantınızı kontrol edin veya tekrar deneyin.",
      },
      "ar": {
        "success": "تم ربط حسابك مع Zoho بنجاح",
        "error": "فشل ربط حسابك مع Zoho",
        "errorMessage": "فشل ربط حسابك مع Zoho، يرجى المحاولة لاحقاً.",
        "subtitle": "نتيجة الربط مع Zoho",
        "canUseZohoServices": "يمكنك الآن استخدام خدمات Zoho مباشرة من STUGOOO 🚀",
        "info": "يتم التحقق من الحالة...",
        "button": "العودة إلى الصفحة الرئيسية",
        "tryAgain": "إعادة المحاولة",
        "noValidResult": "لم يتم العثور على نتيجة صالحة",
        "checkYourLink": "تحقق من الرابط أو حاول مجدداً.",
      },
    };
    const resultDiv = document.getElementById("result");

    if (success === "true") {
      resultDiv.innerHTML = `
        <p class="success fade-in">✅ ${messages[locale]["success"]}</p>
        <p class="subtitle fade-in">${messages[locale]["canUseZohoServices"]}</p>
        <button class="button fade-in" onclick="goHome()">${messages[locale]["button"]}</button>
      `;
    } else if (success === "false") {
      resultDiv.innerHTML = `
        <p class="error fade-in">❌ ${messages[locale]["error"]}</p>
        <p class="subtitle fade-in">${messages[locale]["errorMessage"]}</p>
        <button class="button fade-in" onclick="goHome()">${messages[locale]["tryAgain"]}</button>
      `;
    } else {
      resultDiv.innerHTML = `
        <p class="error fade-in">⚠️ ${messages[locale]["noValidResult"]}</p>
        <p class="subtitle fade-in">${messages[locale]["checkYourLink"]}</p>
        <button class="button fade-in" onclick="goHome()">${messages[locale]["button"]}</button>
      `;
    }

    function goHome() {
      window.location.href = "https://pro.stugooo.com";
    }
  </script>

</body>
</html>

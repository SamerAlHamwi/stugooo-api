<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>STUGOOO - Initliaztion Zoho</title>
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
      width: 360px;
      text-align: center;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
    }

    .title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .subtitle {
      color: #a0a0a0;
      font-size: 1rem;
      margin-bottom: 30px;
    }

    .username {
      font-size: 1.2rem;
      color: #c084fc;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .error {
      color: #f87171;
      margin-bottom: 20px;
      font-weight: 500;
    }

    .info {
      color: #a3a3a3;
      font-size: 0.95rem;
      margin-bottom: 20px;
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
    <p class="subtitle">لوحة ربط Zoho</p>

    <div id="content">
      <p class="info">جاري تحميل بيانات المستخدم...</p>
    </div>
  </div>

  <script>
    const contentDiv = document.getElementById("content");

    // 🟣 قراءة userId من رابط الصفحة
    const params = new URLSearchParams(window.location.search);
    const userId = params.get("userId");

    // إذا ما في userId بالرابط
    if (!userId) {
      contentDiv.innerHTML = `
        <p class="error">❌ لم يتم تمرير معرف المستخدم في الرابط</p>
        <p class="info">الرجاء فتح الصفحة مع المعرف مثل:<br>
        <span style="color:#c084fc">?userId=USER_ID</span></p>
      `;
    } else {
      // 🔹 رابط الـ API
      const apiUrl = `https://getpublicuserinfo-ysuk6o3iia-uc.a.run.app/?userId=${encodeURIComponent(userId)}`;

      // 🔹 جلب بيانات المستخدم
      fetch(apiUrl)
        .then(res => res.json())
        .then(data => {
          if (data.success && data.user && data.user.fullname) {
            const name = data.user.fullname;
            contentDiv.innerHTML = `
              <p class="username fade-in">مرحباً ${name} 👋</p>
              <button class="button fade-in" onclick="connectZoho()">ربط مع Zoho</button>
            `;
          } else {
            contentDiv.innerHTML = `
              <p class="error fade-in">⚠️ المستخدم غير موجود أو انتهت صلاحيته</p>
              <p class="info fade-in">تحقق من الرابط أو حاول لاحقاً.</p>
            `;
          }
        })
        .catch(err => {
          console.error(err);
          contentDiv.innerHTML = `
            <p class="error fade-in">🚨 حدث خطأ أثناء الاتصال بالخادم</p>
            <p class="info fade-in">الرجاء المحاولة مرة أخرى لاحقاً.</p>
          `;
        });
    }

    function connectZoho() {
      // 🔗 رابط التكامل الفعلي مع Zoho
      window.location.href = "https://www.zoho.com/";
    }
  </script>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ request()->get('locale', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Authentication Status</title>

    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="referrer" content="no-referrer">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Inter, Arial, sans-serif;
            background: #0f172a;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .background {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at top left, rgba(59,130,246,0.25), transparent 30%),
                radial-gradient(circle at bottom right, rgba(16,185,129,0.18), transparent 30%),
                #0f172a;
            z-index: -1;
        }

        .card {
            width: 100%;
            max-width: 480px;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 42px;
            text-align: center;
            box-shadow:
                0 10px 40px rgba(0,0,0,0.45),
                0 0 0 1px rgba(255,255,255,0.04);
        }

        .icon-wrapper {
            width: 92px;
            height: 92px;
            margin: 0 auto 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: bold;
        }

        .success {
            background: rgba(16,185,129,0.15);
            color: #10b981;
            border: 2px solid rgba(16,185,129,0.35);
        }

        .error {
            background: rgba(239,68,68,0.15);
            color: #ef4444;
            border: 2px solid rgba(239,68,68,0.35);
        }

        h1 {
            font-size: 30px;
            margin-bottom: 14px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        p {
            color: #cbd5e1;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 26px;
        }

        .status-success {
            background: rgba(16,185,129,0.15);
            color: #10b981;
        }

        .status-error {
            background: rgba(239,68,68,0.15);
            color: #ef4444;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            padding: 14px 22px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(37,99,235,0.35);
        }

        .footer {
            margin-top: 28px;
            font-size: 13px;
            color: #64748b;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.25);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .hidden {
            display: none;
        }

        @media (max-width: 640px) {
            .card {
                margin: 20px;
                padding: 32px 24px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="background"></div>

@php
    $success = request()->get('success') === 'true';
    $message = request()->get('message');
@endphp

<div class="card">

    @if($success)

        <div class="icon-wrapper success">
            ✓
        </div>

        <div class="status-badge status-success">
            GOOGLE ACCOUNT CONNECTED
        </div>

        <h1>Authentication Successful</h1>

        <p>
            Your Google account has been securely connected to Stugooo.
            You can now create and manage Google Meet sessions directly from the platform.
        </p>

        <button class="button" id="continueBtn">
            <span id="btnText">Continue</span>
            <span id="btnSpinner" class="spinner hidden"></span>
        </button>

    @else

        <div class="icon-wrapper error">
            ✕
        </div>

        <div class="status-badge status-error">
            AUTHENTICATION FAILED
        </div>

        <h1>Connection Failed</h1>

        <p>
            We could not complete the Google authentication process.
            Please try again or contact support if the issue persists.
        </p>

        @if($message)
            <p style="font-size:13px;color:#94a3b8;word-break:break-word;">
                Error: {{ e($message) }}
            </p>
        @endif

        <button class="button" onclick="window.close()">
            Close Window
        </button>

    @endif

    <div class="footer">
        © {{ date('Y') }} Stugooo. All rights reserved.
    </div>

</div>

<script>
    (() => {

        const success = @json($success);

        if (!success) {
            return;
        }

        const btn = document.getElementById('continueBtn');
        const spinner = document.getElementById('btnSpinner');
        const text = document.getElementById('btnText');

        async function finishAuth() {

            spinner.classList.remove('hidden');
            text.innerText = 'Redirecting...';

            try {

                if (window.opener && !window.opener.closed) {

                    window.opener.postMessage({
                        type: 'GOOGLE_AUTH_SUCCESS'
                    }, '*');

                    setTimeout(() => {
                        window.close();
                    }, 1200);

                    return;
                }

                setTimeout(() => {
                    window.location.href = 'https://pro.stugooo.com';
                }, 1200);

            } catch (e) {

                console.error(e);

                setTimeout(() => {
                    window.location.href = 'https://pro.stugooo.com';
                }, 1200);
            }
        }

        btn.addEventListener('click', finishAuth);

        setTimeout(finishAuth, 1500);

    })();
</script>

</body>
</html>
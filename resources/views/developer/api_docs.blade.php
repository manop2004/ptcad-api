<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTCAD License API Documentation & Botnoi Integration</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1765ff;
            --primary-dark: #0b45b8;
            --primary-light: #e8f0fe;
            --success: #10b981;
            --dark: #0b1f4d;
            --gray-bg: #f8fafc;
            --card-border: #e2e8f0;
            --code-bg: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Prompt', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #334155;
            padding: 30px 20px 80px;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #0b1f4d 0%, #1765ff 100%);
            color: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(23, 101, 255, 0.2);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header-title p {
            font-size: 15px;
            color: #dbeafe;
            font-weight: 300;
        }

        .badge-status {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.5);
            color: #34d399;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .badge-status::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px #10b981;
        }

        .card {
            background: white;
            border-radius: 18px;
            border: 1px solid var(--card-border);
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .card-header h2 {
            font-size: 19px;
            font-weight: 600;
            color: var(--dark);
        }

        .field-group {
            margin-bottom: 20px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copy-box {
            display: flex;
            align-items: stretch;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .copy-box:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 101, 255, 0.15);
        }

        .copy-input {
            flex: 1;
            padding: 12px 16px;
            background: transparent;
            border: none;
            outline: none;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            color: #1e293b;
            font-weight: 500;
            width: 100%;
        }

        .btn-copy {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s ease;
            white-space: nowrap;
        }

        .btn-copy:hover {
            background: var(--primary-dark);
        }

        .btn-copy.copied {
            background: var(--success);
        }

        .interactive-tester {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
        }

        .test-input-row {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .test-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        .test-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 101, 255, 0.15);
        }

        .btn-run {
            background: #0f172a;
            color: white;
            border: none;
            padding: 0 24px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-run:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        .response-container {
            background: var(--code-bg);
            border-radius: 10px;
            padding: 18px;
            color: #f8fafc;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            line-height: 1.6;
            max-height: 280px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .bot-preview {
            background: #e0f2fe;
            border-left: 4px solid var(--primary);
            border-radius: 8px;
            padding: 16px;
            margin-top: 15px;
        }

        .bot-preview-title {
            font-size: 13px;
            font-weight: 600;
            color: #0369a1;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .bot-bubble {
            background: white;
            padding: 14px 18px;
            border-radius: 16px;
            border-top-left-radius: 4px;
            color: #1e293b;
            font-size: 14px;
            line-height: 1.6;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            white-space: pre-line;
        }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #0f172a;
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 9999;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .guide-steps {
            list-style: none;
            counter-reset: step-counter;
        }

        .guide-step {
            position: relative;
            padding-left: 45px;
            margin-bottom: 18px;
            font-size: 15px;
            line-height: 1.6;
        }

        .guide-step::before {
            counter-increment: step-counter;
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 2px;
            width: 30px;
            height: 30px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <h1>🤖 PTCAD Botnoi License API Helper</h1>
            <p>หน้าคัดลอกค่าสำหรับนำไปเชื่อมต่อกับ Botnoi Chatbot ได้ทันทีในคลิกเดียว</p>
        </div>
        <div class="badge-status">
            API พร้อมใช้งาน (Online)
        </div>
    </div>

    <!-- Section 1: Botnoi Add API Values -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon">📋</div>
            <h2>1. ข้อมูลสำหรับกรอกในหน้า Add API ของ Botnoi</h2>
        </div>

        <div class="field-group">
            <label class="field-label">
                <span>Object Name *</span>
                <span style="color: #94a3b8; font-weight: normal;">(ชื่ออ็อบเจ็กต์)</span>
            </label>
            <div class="copy-box">
                <input type="text" class="copy-input" value="API_license" id="input_obj_name" readonly>
                <button class="btn-copy" onclick="copyText('input_obj_name')">📋 ก็อปปี้</button>
            </div>
        </div>

        <div class="field-group">
            <label class="field-label">
                <span>Method</span>
                <span style="color: #94a3b8; font-weight: normal;">(วิธีเรียก)</span>
            </label>
            <div class="copy-box">
                <input type="text" class="copy-input" value="GET" id="input_method" readonly>
                <button class="btn-copy" onclick="copyText('input_method')">📋 ก็อปปี้</button>
            </div>
        </div>

        <div class="field-group">
            <label class="field-label">
                <span>URL สำหรับทดสอบในหน้า Add API (Test Response)</span>
                <span style="color: #10b981; font-weight: 600;">(ใช้กดปุ่ม RUN API)</span>
            </label>
            <div class="copy-box">
                <input type="text" class="copy-input" value="{{ $testUrl }}" id="input_test_url" readonly>
                <button class="btn-copy" onclick="copyText('input_test_url')">📋 ก็อปปี้ URL</button>
            </div>
        </div>

        <div class="field-group">
            <label class="field-label">
                <span>URL สำหรับใส่ในบทสนทนาจริง (Production with Variable)</span>
                <span style="color: var(--primary); font-weight: 600;">(ส่งค่าตามที่ลูกค้าพิมพ์)</span>
            </label>
            <div class="copy-box">
                <input type="text" class="copy-input" value="{{ $prodUrl }}" id="input_prod_url" readonly>
                <button class="btn-copy" onclick="copyText('input_prod_url')">📋 ก็อปปี้ URL</button>
            </div>
        </div>

        <div class="field-group">
            <label class="field-label">
                <span>ตัวแปรแสดงผลข้อความในบอท (Response Variable)</span>
                <span style="color: #94a3b8; font-weight: normal;">(ใส่ในข้อความตอบกลับของบอท)</span>
            </label>
            <div class="copy-box">
                <input type="text" class="copy-input" value="{API_license.message}" id="input_res_var" readonly>
                <button class="btn-copy" onclick="copyText('input_res_var')">📋 ก็อปปี้</button>
            </div>
        </div>
    </div>

    <!-- Section 2: Live Interactive Tester -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon">⚡</div>
            <h2>2. ทดสอบเรียกดูข้อมูล API สด (Live Test)</h2>
        </div>

        <p style="font-size: 14px; color: #64748b; margin-bottom: 15px;">
            พิมพ์เบอร์โทรศัพท์ อีเมล หรือ Serial Number เพื่อทดสอบดูข้อมูลที่จะส่งให้แชทบอท:
        </p>

        <div class="interactive-tester">
            <div class="test-input-row">
                <input type="text" class="test-input" id="search_input" placeholder="เช่น 0998889999 หรือ nonroblox001@gmail.com" value="0998889999">
                <button class="btn-run" onclick="runLiveTest()">
                    <span>🚀 ทดสอบเรียก API</span>
                </button>
            </div>

            <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 6px;">JSON Response ที่ส่งให้ Botnoi:</div>
            <div class="response-container" id="response_box">กดปุ่ม "🚀 ทดสอบเรียก API" เพื่อดูผลลัพธ์...</div>

            <!-- Bot Chat Preview -->
            <div class="bot-preview" id="bot_preview_box" style="display: none;">
                <div class="bot-preview-title">
                    <span>💬 ตัวอย่างข้อความที่ลูกค้าจะเห็นในแชท:</span>
                </div>
                <div class="bot-bubble" id="bot_message_text"></div>
            </div>
        </div>
    </div>

    <!-- Section 3: Quick Setup Guide -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon">📖</div>
            <h2>3. สรุปวิธีตั้งค่าใน Botnoi ให้เสร็จใน 3 นาที</h2>
        </div>

        <ol class="guide-steps">
            <li class="guide-step">
                ไปที่หน้าต่าง <b>Add API</b> ใน Botnoi ➡️ วาง <b>Object Name</b> และ <b>URL สำหรับทดสอบ</b> จากข้อ 1 ด้านบน
            </li>
            <li class="guide-step">
                กดปุ่ม <b>RUN API</b> ➡️ จะได้ <b>Status: 200</b> สีเขียว ➡️ จากนั้นกดปุ่ม <b>Save</b>
            </li>
            <li class="guide-step">
                ไปที่เมนู <b>บทสนทนา (Conversation)</b> ➡️ สร้างคำถามให้บอทถามลูกค้า: <i>"กรุณากรอกอีเมลหรือเบอร์โทรศัพท์ที่ใช้สั่งซื้อสินค้าครับ"</i>
            </li>
            <li class="guide-step">
                ตั้งค่าให้บอทเรียกใช้ API โดยส่ง <b>URL สำหรับใส่ในบทสนทนาจริง</b> แล้วตอบกลับลูกค้าด้วย <code>{API_license.message}</code> ได้ทันที!
            </li>
        </ol>
    </div>

</div>

<!-- Toast Notification -->
<div class="toast" id="toast">
    <span>✅ คัดลอกลง Clipboard เรียบร้อยแล้ว!</span>
</div>

<script>
    function copyText(elementId) {
        const input = document.getElementById(elementId);
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(input.value).then(() => {
            showToast();
            
            // Visual feedback on button
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '✅ ก็อปแล้ว!';
            btn.classList.add('copied');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('copied');
            }, 1500);
        });
    }

    function showToast() {
        const toast = document.getElementById('toast');
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2000);
    }

    async function runLiveTest() {
        const query = document.getElementById('search_input').value.trim();
        const resBox = document.getElementById('response_box');
        const botBox = document.getElementById('bot_preview_box');
        const botText = document.getElementById('bot_message_text');

        if (!query) {
            alert('กรุณากรอกเบอร์โทรหรืออีเมลเพื่อทดสอบครับ');
            return;
        }

        resBox.innerHTML = 'กำลังดึงข้อมูล...';

        try {
            const res = await fetch(`/api/botnoi/license?search=${encodeURIComponent(query)}`);
            const data = await res.json();

            resBox.innerHTML = JSON.stringify(data, null, 2);

            if (data.message) {
                botBox.style.display = 'block';
                botText.innerText = data.message;
            } else {
                botBox.style.display = 'none';
            }
        } catch (err) {
            resBox.innerHTML = 'Error: ' + err.message;
            botBox.style.display = 'none';
        }
    }

    // Auto run test once when page loads
    window.addEventListener('DOMContentLoaded', () => {
        runLiveTest();
    });
</script>

</body>
</html>

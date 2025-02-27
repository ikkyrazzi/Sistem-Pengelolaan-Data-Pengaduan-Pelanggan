<!DOCTYPE html>
<html>

<head>
    <title>Pembaruan Status Keluhan Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .status {
            font-weight: bold;
            color: #007bff;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .button:hover {
            background-color: #218838;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Halo {{ $complaint->customer->name }},</h2>
        <p>Terima kasih telah menghubungi layanan kami. Kami ingin menginformasikan bahwa status keluhan Anda dengan
            subjek <strong>{{ $complaint->subject }}</strong> telah diperbarui.</p>
        <p>Status terbaru: <span class="status">{{ $complaint->status }}</span></p>
        <p>Silakan masuk ke akun Anda untuk melihat detail lebih lanjut mengenai keluhan Anda.</p>

        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdkmmRN7Fm7UzTe_x4633AehhBe353DPHbBt5kq_6KPFQ9bXg/viewform?usp=dialog"
            class="button">
            Beri Penilaian & Saran
        </a>

        <p class="footer">
            Hormat kami,<br>
            <strong>Tim Layanan Pelanggan</strong>
        </p>
    </div>
</body>

</html>

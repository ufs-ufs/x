<?php
// send_to_telegram.php

// Ganti dengan token bot Anda
$botToken = "7375262668:AAHBFfwnMZ9Cg0clsH-m5HZOdq-nhFJ9Cww";
// Ganti dengan chat ID Anda (bisa berupa ID pribadi atau grup)
$chatId = "5649811717";

// Cek apakah data dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari POST
    $keywords = isset($_POST['keywords']) ? htmlspecialchars($_POST['keywords']) : '';
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';
    $searchEngines = isset($_POST['searchEngine']) ? implode(', ', array_map('htmlspecialchars', $_POST['searchEngine'])) : '';
    $category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '';
    $fileTypes = isset($_POST['fileType']) ? implode(', ', array_map('htmlspecialchars', $_POST['fileType'])) : '';
    $vivMode = isset($_POST['vivMode']) && $_POST['vivMode'] === 'on' ? 'Aktif' : 'Nonaktif';
    $dorkQuery = isset($_POST['dorkQuery']) ? htmlspecialchars($_POST['dorkQuery']) : '';

    // Buat pesan yang akan dikirim
    $message = "📢 *Pencarian Baru*\n\n";
    $message .= "*Kata Kunci:* " . $keywords . "\n";
    $message .= "*Negara:* " . $country . "\n";
    $message .= "*Mesin Pencari:* " . $searchEngines . "\n";
    $message .= "*Kategori:* " . $category . "\n";
    $message .= "*Jenis File:* " . $fileTypes . "\n";
    $message .= "*Mode VIV:* " . $vivMode . "\n";
    if (!empty($dorkQuery)) {
        $message .= "*Dork Query:* " . $dorkQuery . "\n";
    }

    // URL API Telegram
    $url = "https://api.telegram.org/bot$botToken/sendMessage";

    // Data yang dikirim ke Telegram
    $postFields = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];

    // Inisialisasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Eksekusi cURL
    $response = curl_exec($ch);
    curl_close($ch);

    // Kembalikan respons ke frontend
    echo $response;
}
?>

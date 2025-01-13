<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $frequency = $_POST['frequency'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Geçersiz e-posta adresi.";
        exit;
    }

    // E-posta başarıyla kaydedildi mesajı
    echo "Bültene başarıyla abone oldunuz! Sıklık: $frequency";
} else {
    echo "Geçersiz istek.";
}
?>

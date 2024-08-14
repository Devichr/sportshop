<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $protocol = 'smtp';
    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'devianochristian@gmail.com'; // Ganti dengan email Anda
    public string $SMTPPass = 'mspo wydn dedq nvcr'; // Ganti dengan password email Anda
    public int $SMTPPort = 587; // Port untuk TLS, 465 untuk SSL
    public string $SMTPCrypto = 'tls'; // 'tls' untuk port 587, 'ssl' untuk port 465
    public string $fromEmail  = 'devianochristian@gmail.com'; // Ganti dengan email Anda
    public string $fromName   = 'Sport Shop'; // Nama pengirim
    public bool $SMTPKeepAlive = false;
    public bool $SMTPDebug = true; // Tambahkan baris ini untuk mengaktifkan debugging
    public bool $wordWrap = true;
    public int $wrapChars = 76;
    public string $mailType = 'html'; // Gunakan 'html' atau 'text'
    public string $charset = 'UTF-8';
    public bool $validate = true;
    public int $priority = 3;
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool $DSN = false;
    
}

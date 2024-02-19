<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xendit {

    // Ganti dengan Xendit API Key Anda
    private $apiKey = 'xnd_development_y2t6hOsvNCx0VvYlKLemVsEe1gaspJ13Tt9MXd1WXskGTm8gnBxIKTo7qaFNyz';

    public function verifySignature($payload, $signature) {
        $hmac = hash_hmac('sha256', $payload, $this->apiKey);

        return $hmac === $signature;
    }
}
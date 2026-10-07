<?php
declare(strict_types=1);

class Captcha
{
    private string $secret;
    private float  $minScore;

    public function __construct(string $secret, float $minScore = 0.5)
    {
        $this->secret   = $secret;
        $this->minScore = $minScore;
    }

    /**
     * ตรวจสอบ reCAPTCHA v3 token
     * คืน ['valid' => true] หรือ ['valid' => false, 'reason' => '...']
     */
    public function verify(string $token, string $ip = ''): array
    {
        if (empty($token)) {
            return ['valid' => false, 'reason' => 'Token is empty'];
        }

        $params = [
            'secret'   => $this->secret,
            'response' => $token,
        ];
        if ($ip) {
            $params['remoteip'] = $ip;
        }

        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 5,
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        if (!$res) {
            return ['valid' => false, 'reason' => 'Could not reach reCAPTCHA service'];
        }

        $data = json_decode($res, true);

        if (empty($data['success'])) {
            $codes = implode(', ', $data['error-codes'] ?? []);
            return ['valid' => false, 'reason' => 'reCAPTCHA failed: ' . $codes];
        }

        $score = (float)($data['score'] ?? 0);
        if ($score < $this->minScore) {
            return ['valid' => false, 'reason' => "Score too low ({$score} < {$this->minScore})"];
        }

        return ['valid' => true, 'score' => $score];
    }
}

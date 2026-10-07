<?php
declare(strict_types=1);

class RateLimit
{
    private int    $max;
    private int    $window;
    private string $dir;

    public function __construct(int $max, int $window, string $storageDir)
    {
        $this->max    = $max;
        $this->window = $window;
        $this->dir    = rtrim($storageDir, '/') . '/rate_limit';

        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0700, true);
        }
    }

    /**
     * ตรวจสอบว่า IP นี้ยังไม่เกิน limit
     * คืน true = อนุญาต, false = เกิน limit
     */
    public function check(string $ip): bool
    {
        $file = $this->filePath($ip);
        $now  = time();
        $hits = $this->readHits($file);

        // กรองเฉพาะ hits ที่อยู่ใน window
        $hits = array_values(array_filter($hits, fn(int $t) => $t > $now - $this->window));

        if (count($hits) >= $this->max) {
            return false;
        }

        $hits[] = $now;
        file_put_contents($file, json_encode($hits), LOCK_EX);
        return true;
    }

    /**
     * คืนจำนวนวินาทีที่ต้องรอก่อนลองใหม่ได้
     */
    public function retryAfter(string $ip): int
    {
        $hits = $this->readHits($this->filePath($ip));
        if (empty($hits)) return 0;
        return max(0, (min($hits) + $this->window) - time());
    }

    /**
     * คืนจำนวน request ที่ใช้ไปแล้ว
     */
    public function current(string $ip): int
    {
        $now  = time();
        $hits = $this->readHits($this->filePath($ip));
        return count(array_filter($hits, fn(int $t) => $t > $now - $this->window));
    }

    // ────────────────────────────────────────────────────────────────────────

    private function filePath(string $ip): string
    {
        return $this->dir . '/' . md5($ip) . '.json';
    }

    private function readHits(string $file): array
    {
        if (!file_exists($file)) return [];
        $data = json_decode(file_get_contents($file), true);
        return is_array($data) ? $data : [];
    }
}

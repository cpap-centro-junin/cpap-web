<?php

namespace App\Support;

final class UploadLimits
{
    private function __construct()
    {
    }

    public static function phpMaxBytes(): int
    {
        $uploadMax = self::iniSizeToBytes((string) ini_get('upload_max_filesize'));
        $postMax = self::iniSizeToBytes((string) ini_get('post_max_size'));

        $availableLimits = array_filter([$uploadMax, $postMax], static fn (int $value): bool => $value > 0);

        if ($availableLimits === []) {
            return 0;
        }

        return min($availableLimits);
    }

    public static function phpMaxKb(): int
    {
        $maxBytes = self::phpMaxBytes();

        if ($maxBytes <= 0) {
            return 0;
        }

        return max(1, (int) floor($maxBytes / 1024));
    }

    public static function effectiveKb(int $desiredKb): int
    {
        $phpMaxKb = self::phpMaxKb();

        if ($phpMaxKb <= 0) {
            return max(1, $desiredKb);
        }

        return max(1, min($desiredKb, $phpMaxKb));
    }

    public static function formatMbFromKb(int $kb): string
    {
        $mb = $kb / 1024;

        if ((int) $mb === $mb) {
            return (string) (int) $mb;
        }

        return rtrim(rtrim(number_format($mb, 1, '.', ''), '0'), '.');
    }

    private static function iniSizeToBytes(string $size): int
    {
        $value = trim($size);

        if ($value === '') {
            return 0;
        }

        $unit = strtolower(substr($value, -1));
        $number = (float) $value;

        return match ($unit) {
            'g' => (int) round($number * 1024 * 1024 * 1024),
            'm' => (int) round($number * 1024 * 1024),
            'k' => (int) round($number * 1024),
            default => (int) round($number),
        };
    }
}
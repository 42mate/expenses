<?php

namespace App\Support;

/**
 * Normalizes an amount that may have been entered/pasted in a locale format
 * (e.g. "5.088,15" where "." groups thousands and "," is the decimal) into the
 * canonical machine format the app stores/validates ("5088.15").
 *
 * Mirrors the client-side logic in resources/js/amount-input.js so the value is
 * correct even when JavaScript did not run (stale cache, JS disabled, etc.).
 */
class AmountNormalizer
{
    public static function normalize($raw): ?string
    {
        if ($raw === null) {
            return null;
        }

        $s = trim((string) $raw);
        if ($s === '') {
            return $s;
        }

        $neg = str_starts_with($s, '-');
        $s = preg_replace('/[^0-9.,]/', '', $s);
        if ($s === '') {
            return $neg ? '-' : '';
        }

        $commas = substr_count($s, ',');
        $dots = substr_count($s, '.');

        if ($commas === 0) {
            // No comma: already canonical, unless several dots => thousands grouping.
            $out = $dots > 1 ? str_replace('.', '', $s) : $s;
        } else {
            $dotAfterComma = $dots > 0 && strrpos($s, '.') > strrpos($s, ',');
            if ($dotAfterComma) {
                // US style: "." is the decimal, "," are thousands.
                $out = str_replace(',', '', $s);
            } else {
                // AR/EU style: "," is the decimal, "." are thousands.
                $t = str_replace('.', '', $s);
                $lastComma = strrpos($t, ',');
                $decimals = strlen($t) - $lastComma - 1;
                if ($commas > 1 && $decimals === 3) {
                    // e.g. "1,000,000" grouped by commas => integer, no decimals.
                    $out = str_replace(',', '', $t);
                } else {
                    $intPart = str_replace(',', '', substr($t, 0, $lastComma));
                    $out = $intPart . '.' . substr($t, $lastComma + 1);
                }
            }
        }

        // Drop a dangling decimal point (e.g. "15." -> "15") so it stays numeric.
        $out = preg_replace('/\.$/', '', $out);

        return ($neg ? '-' : '') . $out;
    }
}

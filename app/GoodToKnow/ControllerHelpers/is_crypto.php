<?php

namespace GoodToKnow\ControllerHelpers;

/**
 * @param string $currency
 * @return bool
 */
function is_crypto(string $currency): bool
{
    $fiat_currencies = ['💵', '$', 'USD', 'dollar', 'US dollar', 'Dollar', 'US Dollar', 'ARS', 'AUD', 'BSD', 'BBD',
        'BYN', 'BZD', 'BMD', 'BOB', '$b', 'BAM', 'KM', 'BRL', 'R$', 'CAD', 'KYD', 'CLP', 'CNY', '¥', 'COP', 'CRC', '₡',
        'HRK', 'kn', 'CUP', '₱', 'CZK', 'Kč', 'DKK', 'kr', 'DOP', 'RD$', 'EGP', '£', 'EUR', '€', 'HNL', 'L', 'HKD',
        'INR', 'IRR', '﷼', 'ILS', '₪', 'JPY', '¥', 'KPW', '₩', 'KRW', 'MYR', 'RM', 'MXN', 'ANG', 'ƒ', 'NZD', 'NIO',
        'C$', 'NGN', '₦', 'NOK', 'kr', 'PKR', '₨', 'PAB', 'B/.', 'PEN', 'S/.', 'PHP', '₱', 'QAR', 'RUB', '	₽', 'SAR',
        'RSD', 'Дин.', 'SGD', 'ZAR', 'R', 'SEK', 'kr', 'CHF', 'SYP', 'TWD', 'NT$', 'TRY', 'UAH', '₴', 'GBP', 'VEF', 'Bs',
        'VND', '₫', 'YER', 'ZWD', 'Z$', '¢', '₣', '₲', 'ლ', 'лв.', '₺', '₥', '₹', '৳', '₮', 'zł', 'franc'];

    if (in_array($currency, $fiat_currencies)) {

        return false;

    }

    return true;
}
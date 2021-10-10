<?php

declare(strict_types=1);

/**
 * Removing empty values (null, '').
 *
 * @param  array  $associatedValues
 * @return array
 */
function removeEmptyValues(array $associatedValues): array
{
    foreach ($associatedValues as $key => $value) {
        if ($value === null || $value === '') {
            unset($associatedValues[$key]);
        }
    }

    return $associatedValues;
}

/**
 * Set array value by path with dots.
 *
 * @param  array  $arr
 * @param  string  $path
 * @param  mixed  $value
 * @param  string  $separator
 */
function setArrayByPath(array &$arr, string $path, mixed $value, string $separator = '.'): void
{
    $keys = explode($separator, $path);

    foreach ($keys as $key) {
        $arr = &$arr[$key];
    }

    $arr = $value;
}

/**
 * Get common path of namespaces.
 *
 * @param  string  $namespace1
 * @param  string  $namespace2
 * @return string|null
 */
function getCommonNamespace(string $namespace1, string $namespace2): ?string
{
    $chunks1 = explode('\\', $namespace1);
    $chunks2 = explode('\\', $namespace2);
    $common = null;

    for ($i = 0; $i < count($chunks1) && $i < count($chunks2); $i++) {
        $chunk1 = $chunks1[$i];
        $chunk2 = $chunks2[$i];

        if ($chunk1 !== $chunk2) {
            break;
        } else {
            $common = "$common\\$chunk1";
        }
    }

    return $common ? substr($common, 1) : $common;
}

/**
 * Remove $without if target start with $without.
 *
 * @param  string  $string
 * @param  string  $without
 * @return string
 */
function strStartWithout(string $string, string $without): string
{
    return str_starts_with($string, $without) ? mb_substr($string, mb_strlen($without)) : $string;
}

<?php

/**
 * Removing empty values (null, '').
 *
 * @param array $associatedValues
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
 * @param array $arr
 * @param string $path
 * @param mixed $value
 * @param string $separator
 */
function setArrayByPath(array &$arr, string $path, mixed $value, string $separator='.'): void
{
    $keys = explode($separator, $path);

    foreach ($keys as $key) {
        $arr = &$arr[$key];
    }

    $arr = $value;
}

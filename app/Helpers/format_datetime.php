<?php

if ( ! function_exists('carbonParse')) {
    function carbonParse($stringToParse)
    {
        $sanitizedString = str_replace('/', '-', $stringToParse);
        return \Carbon\Carbon::parse($sanitizedString);
    }
}

if ( ! function_exists('formatDate')) {
    function formatDate($stringToParse)
    {
        return \Carbon\Carbon::parse($stringToParse)->format('d-m-Y');
    }
}

if ( ! function_exists('formatDateTime')) {
    function formatDateTime($stringToParse)
    {
        return \Carbon\Carbon::parse($stringToParse)->format('d-m-Y h:i A');
    }
}

if ( ! function_exists('formatDatePickerFull')) {
    function formatDatePickerFull($stringToParse, $ampm = false)
    {
        $cleanString = str_replace('/', '-', $stringToParse);
        $format = "d/m/Y";
        $format .= $ampm ? " h:i A" : " H:i";
        return \Carbon\Carbon::parse($cleanString)->format($format);
    }
}

if ( ! function_exists('formatDateTimeFull')) {
    function formatDateTimeFull($stringToParse)
    {
        $cleanString = str_replace('/', '-', $stringToParse);
        return \Carbon\Carbon::parse($cleanString)->format('d-m-Y H:i:s');
    }
}

if ( ! function_exists('formatDateDBFull')) {
    function formatDateDBFull($stringToParse)
    {
        $cleanString = str_replace('/', '-', $stringToParse);
        return \Carbon\Carbon::parse($cleanString)->format('Y-m-d');
    }
}

if ( ! function_exists('formatDateTimeDBFull')) {
    function formatDateTimeDBFull($stringToParse)
    {
        $cleanString = str_replace('/', '-', $stringToParse);
        return \Carbon\Carbon::parse($cleanString)->format('Y-m-d H:i:s');
    }
}

<?php

class constGuards{
    const ADMIN = 'admin';
    const CLIENT = 'client';
    const SELLER = 'seller';
}

class constDefaults{
    const tokenExpiredMinutes = 15;
}

function numberToMonthName($monthNumber) {
    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    return isset($months[$monthNumber]) ? $months[$monthNumber] : 'Invalid Month';
}

function extName(){
    return [
        'SR.'   => 'SR.',
        'JR.'   => 'JR.',
        'I'     => 'I',
        'II'    => 'II',
        'III'   => 'III',
        'IV'    => 'IV',
        'V'     => 'V',
        'VI'    => 'VI',
        'VII'   => 'VII',
        'VIII'  => 'VIII',
        'IX'    => 'IX',
        'X'     => 'X',
        'XI'    => 'XI',
        'XII'   => 'XII',
    ];
}

function sex(){
    return [
        'Male'      => 'Male',
        'Female'    => 'Female',
        'Other'     => 'Other'
    ];
}

function civilStatus(){
    return [
        'Single'    => 'Single',
        'Married'   => 'Married',
        'Divorced'  => 'Divorced',
        'Separated' => 'Separated',
        'Widowed'   => 'Widowed',
        'Other'     => 'Other'
    ];
}

function leaveUnit(){
    return [
        'Yearly'    => 'Yearly',
        'Monthly'   => 'Monthly'
    ];
}

function yesNo(){
    return [
        'Yes'   => 'Yes',
        'No'    => 'No'
    ];
}

function plantillaStatus(){
    return [
        'Permanent' => 'Permanent',
        'Contract of Service' => 'Contract of Service',
        'Job Order' => 'Job Order',
    ];
}
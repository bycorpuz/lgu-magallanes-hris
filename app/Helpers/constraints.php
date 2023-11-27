<?php

class constGuards{
    const ADMIN = 'admin';
    const CLIENT = 'client';
    const SELLER = 'seller';
}

class constDefaults{
    const tokenExpiredMinutes = 15;
}

function months() {
    return [
        'January'   => 'January',
        'February'  => 'February',
        'March'     => 'March',
        'April'     => 'April',
        'May'       => 'May',
        'June'      => 'June',
        'July'      => 'July',
        'August'    => 'August',
        'September' => 'September',
        'October'   => 'October',
        'November'  => 'November',
        'December'  => 'December',
    ];
}

function months2($month) {
    if ($month == 'January'){
        return '01';
    } else if ($month == 'February'){
        return '02';
    } else if ($month == 'March'){
        return '03';
    } else if ($month == 'April'){
        return '04';
    } else if ($month == 'May'){
        return '05';
    } else if ($month == 'June'){
        return '06';
    } else if ($month == 'July'){
        return '07';
    } else if ($month == 'August'){
        return '08';
    } else if ($month == 'September'){
        return '09';
    } else if ($month == 'October'){
        return '10';
    } else if ($month == 'November'){
        return '11';
    } else if ($month == 'December'){
        return '12';
    } else {
        return '01';
    }
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

function leaveStatus(){
    return [
        'Approved'      => 'Approved',
        'Disapproved'   => 'Disapproved',
        'Cancelled'     => 'Cancelled',
        'Processing'    => 'Processing',
        'Pending'       => 'Pending'
    ];
}
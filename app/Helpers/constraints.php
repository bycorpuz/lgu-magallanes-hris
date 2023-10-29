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
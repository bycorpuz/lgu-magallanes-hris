<?php
    use Illuminate\Support\Facades\DB;
?>

<style>
    @media print {
        @page {
            size: landscape
        }
        .main {
            page-break-after: always;
            break-after: always;
        }
    }

    .header {
        width: 100%;
        text-align: center;
        margin-bottom: 1mm;
    }
    .header .banner {
        width: 3in;
    }

    .clearfix {
        border-top: 2px solid black;
    }

    .body {
        font-family: "Calibri";
        font-size: 10pt;
    }

    .leave-card {
        margin-top: 1mm;
        text-align: center;
        font-size: 18pt;
        font-weight: bold;
    }

    .table {
        width: 100%;
        word-wrap: break-word;
        border-collapse: collapse;
        font-size: 10pt;
    }
    .table thead{
        border-bottom: 2px solid black;
    }
    .table th {
        border: 1px solid black;
        text-align: center;
        vertical-align: middle;
    }
    .table td {
        border: 1px solid black;
        text-align: center;
        vertical-align: middle;
    }
    .table .no-border {
        border: none;
    }

    .table .text-left {
        text-align: left;
    }
    .table .text-right {
        text-align: right;
    }

    .margin-top-5 {
        margin-top: 5mm;
    }

    .margin-bottom-5 {
        margin-bottom: 5mm;
    }

    .padding-left-1 {
        padding-left: 1mm;
    }
    .padding-right-1 {
        padding-right: 1mm;
    }

    .basic-info {
        font-size: 12pt;
    }
    .left {
        width: 49.9%;
        float: left;
    }
    .right {
        width: 49.9%;
        float: right;
    }
</style>

{{-- CTO --}}
@if (count($cto) > 0)
    <div class="main">
        <div class="body">
            <div class="leave-card">COMPENSATORY OVERTIME CREDIT (COC)</div>
            <div>
                <table class="table margin-top-5 margin-bottom-5">
                    <tbody>
                        <tr>
                            <th class="no-border text-left">Name: <u class="basic-info">{{ strtoupper(getUserFullName($user_id)) }}</u></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table table-leave-card-cto">
                    <thead>
                        <tr style="height: 0.6cm; line-height: 0.35cm;">
                            <th style="width: 5%;">YEAR</th>
                            <th style="width: 40%;">PARTICULARS</th>
                            <th style="width: 10%;">EARNED</th>
                            <th style="width: 15%;">APPLIED LEAVE <br> (Inclusive Dates)</th>
                            <th style="width: 10%;">NO. OF DAYS</th>
                            <th style="width: 10%;">DATE PROCESSED</th>
                            <th style="width: 10%;">BALANCE</th>
                        </tr>
                    </thead>

                    @if (count($cto) == 0)
                        <tbody>
                            <tr><td colspan="9">No data found...</td></tr>
                        </tbody>
                    @else
                        <tbody>
                            @php
                                $runningBalance = 0;
                                $word = "carried";
                                $word2 = "forwarded";
                                $word3 = "less";

                                $totalEarned = 0;
                                $totalUsed = 0;
                                $totalExpired = 0;
                            @endphp
                            @foreach ($cto as $row)
                                @php
                                    $sce_style = ($row->identifier == 'HLCAL-HLCA') ? 'text-left padding-left-1' : 'text-right padding-right-1';
                                    $sce_days = ($row->identifier == 'HLCAL-HLCA') ? $row->value : '';

                                    $alr = ($row->identifier == 'HL') ? $row->hl_remarks : '';
                                    $alr_days = ($row->identifier == 'HL') ? $row->value : '';
                                    $aldp = ($row->identifier == 'HL') ? ( ($row->hl_date_processing) ? date_format(date_create( $row->hl_date_processing ), 'm/d/Y') : '-' ) : '';
                                @endphp

                                @if ($row->identifier == 'HLCAL-HLCA')
                                    @php
                                        $inclusive_dates = '';
                                        $hlcal_remarks = strtolower($row->hlcal_remarks);
                                        $cto_granted = date_format(date_create($row->date_to), 'm/d/Y');
                                    @endphp

                                    {{-- check if leave credit list has the following words --}}
                                    @if (strpos($hlcal_remarks, $word) !== false || strpos($hlcal_remarks, $word2) !== false)
                                        @php
                                            $runningBalance = $runningBalance;
                                            $sce_days = '';
                                        @endphp
                                    @else
                                        @if (strpos($hlcal_remarks, $word3) !== false)
                                            @php
                                                $runningBalance = $runningBalance - $row->value;

                                                $totalExpired += $row->value;
                                            @endphp
                                        @else
                                            @php
                                                $runningBalance += $row->value;

                                                $totalEarned += $row->value;
                                            @endphp
                                        @endif
                                    @endif
                                @else
                                    @php
                                        $cto_granted = '';
                                    @endphp

                                    @if ($row->date_from == $row->date_to)
                                        @php
                                            $inclusive_dates = date_format(date_create($row->date_from), 'm/d/Y');
                                        @endphp
                                    @else
                                        @php
                                            $inclusive_dates = date_format(date_create($row->date_from), 'm/d/Y') . ' - ' . date_format(date_create($row->date_to), 'm/d/Y');
                                        @endphp
                                    @endif

                                    @if ($row->hlcal_remarks == 'Compensatory Time-Off' && $row->hl_is_with_pay == "Yes" && $row->hl_status == "Approved")
                                        @php
                                            $runningBalance = $runningBalance - $row->value;

                                            $totalUsed += $row->value;
                                        @endphp
                                    @endif

                                    @php
                                        $runningBalance = ($runningBalance > 0) ? $runningBalance : '0';
                                    @endphp
                                @endif

                                <tr style="height: 0.6cm; line-height: 0.35cm;">
                                    <td>{{ $row->hlcal_year }}</td>
                                    <td class="{{ $sce_style }}">{{ $row->hlcal_remarks }} <div>{{ $cto_granted }}</div></td>
                                    <td>{{ $sce_days }}</td>
                                    <td>{{ $inclusive_dates }}</td>
                                    <td>{{ $alr_days }}</td>
                                    <td>{{ $aldp }} <div>{{ $row->hl_status }}</div> </td>
                                    <td>{{ number_format($runningBalance, 3) }}</td>
                                </tr>
                            @endforeach

                            {{-- for checking purposes --}}
                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <td colspan="8" style="border: none;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right; padding-right: 1mm;">TOTAL EARNED</td>
                                <td><b>{{ number_format($totalEarned, 3) }}</b></td>
                                <td style="text-align: right; padding-right: 1mm;">TOTAL USED & EXPIRED</td>
                                @php
                                    $totalUsedExpired = $totalUsed + $totalExpired;
                                @endphp
                                <td><b>{{ number_format($totalUsedExpired, 3) }}</b></td>
                                @php
                                    $checkingBalance = $totalEarned - $totalUsedExpired;
                                @endphp
                                <td style="text-align: right; padding-right: 1mm;">TOTAL BALANCE</td>
                                <td><b>{{ number_format($checkingBalance, 3) }}</b></td>
                            </tr>

                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <br>
@endif

{{-- VL - SL --}}
@if ($hasVacationLeave == "Yes")
    <div class="main">
        <div class="body">
            <div class="leave-card">EMPLOYEES LEAVE CARD</div>
            <div>
                <table class="table margin-top-5 margin-bottom-5">
                    <tbody>
                        <tr>
                            <th>NAME</th>
                            <th>DIVISION / OFFICE</th>
                            <th>1<sup>st</sup> DAY of SERVICE</th>
                        </tr>
                        <tr>
                            <td><b><span class="basic-info">{{ strtoupper(getUserFullName($user_id)) }}</span></b></td>
                            <td><b><span class="basic-info">{{ strtoupper(getPlantillas($user_id)->division_office ?? '') }}</span></b></td>
                            <td><b><span class="basic-info">-</span></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- VACATION LEAVE --}}
            <div style="width: 100%;">
                <div class="left">
                    <table class="table table-leave-card-vacation-leave">
                        <thead>
                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <th style="width: 10%;" rowspan="2">YEAR</th>
                                <th colspan="5">VACATION LEAVE</th>
                            </tr>

                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <th style="width: 50%;">PARTICULARS</th>
                                <th style="width: 10%;">EARNED</th>
                                <th style="width: 10%;">ABSENCE WITH PAY</th>
                                <th style="width: 10%;">DATE PROCESSED</th>
                                <th style="width: 10%;">BALANCE</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $runningBalance = 0;
                            @endphp
                            @php
                                $totalEarned = 0;
                                $totalUsed = 0;
                            @endphp
                            @foreach ($vacationLeave as $row2)
                                @php
                                    $vlp = ($row2->hlcal_remarks != 'Vacation Leave') ? $row2->hlcal_remarks : '';
                                @endphp

                                @if ($row2->identifier == 'HLCAL-HLCA')
                                    @php
                                        $vlp_style = 'text-left padding-left-1';
                                        $inclusive_dates = '';
                                        $earned = $row2->value;
                                        $awp = '';
                                        $aldp = '';
                                        $runningBalance += $row2->value;
                                        $totalEarned += $row2->value;
                                    @endphp
                                @else
                                    @php
                                        $vlp_style = 'text-right padding-right-1';
                                        $earned = '';
                                        $awp = $row2->value;
                                        $aldp = $row2->hl_date_processing ? date_format(date_create( $row2->hl_date_processing ), 'm/d/Y') : '';
                                    @endphp

                                    @if ($row2->date_from == $row2->date_to)
                                        @php
                                            $inclusive_dates = date_format(date_create($row2->date_from), 'm/d/Y');
                                        @endphp
                                    @else
                                        @php
                                            $inclusive_dates = date_format(date_create($row2->date_from), 'm/d/Y') . ' - ' . date_format(date_create($row2->date_to), 'm/d/Y');
                                        @endphp
                                    @endif

                                    @if ($row2->hlcal_remarks == 'Vacation Leave' && $row2->hl_is_with_pay == "Yes" && $row2->hl_status == "Approved")
                                        @php
                                            $runningBalance = $runningBalance - $row2->value;
                                            $totalUsed += $row2->value;
                                        @endphp
                                    @endif

                                    @php
                                        $runningBalance = ($runningBalance > 0) ? $runningBalance : '0';
                                    @endphp
                                @endif

                                @php
                                    $flag = ($row2->leave_type_id == 'e8bfe149-808c-4c72-b52d-1f373bedd548') ? '1' : '0';
                                    $runningBalance1 = ($flag == '1') ? number_format($runningBalance, 3) : '';
                                @endphp

                                <tr style="height: 0.6cm; line-height: 0.35cm;">
                                    <td>{{ $row2->hlcal_year }}</td>
                                    <td class="{{ $vlp_style }}"><div>{{ $row2->hl_period }}</div><div>{{ $row2->hl_remarks }}</div><div>{{ $vlp }}</div></td> {{-- <div>{{ $inclusive_dates }}</div> --}}
                                    <td>{{ $earned }}</td>
                                    <td>{{ $awp }}</td>
                                    <td>{{ $aldp }} <div>{{ $row2->hl_status }}</div> </td>
                                    <td>{{ $runningBalance1 }}</td>
                                </tr>
                            @endforeach

                            {{-- for checking purposes --}}
                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <td colspan="8" style="border: none;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right; padding-right: 1mm;">TOTAL</td>
                                <td><b>{{ number_format($totalEarned, 3) }}</b></td>
                                <td><b>{{ number_format($totalUsed, 3) }}</b></td>
                                @php
                                    $checkingBalance = $totalEarned - $totalUsed;
                                @endphp
                                <td></td>
                                <td><b>{{ number_format($checkingBalance, 3) }}</b></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                {{-- SICK LEAVE --}}
                <div class="right">
                    <table class="table table-leave-card-sick-leave">
                        <thead>
                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <th style="width: 10%;" rowspan="2">YEAR</th>
                                <th colspan="5">SICK LEAVE</th>
                            </tr>

                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <th style="width: 50%;">PARTICULARS</th>
                                <th style="width: 10%;">EARNED</th>
                                <th style="width: 10%;">ABSENCE WITH PAY</th>
                                <th style="width: 10%;">DATE PROCESSED</th>
                                <th style="width: 10%;">BALANCE</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $runningBalance = 0;
                            @endphp
                            @php
                                $totalEarned = 0;
                                $totalUsed = 0;
                            @endphp
                            @foreach ($sickLeave as $row2)
                                @php
                                    $vlp = ($row2->identifier == 'HLCAL-HLCA') ? $row2->hlcal_remarks : '';
                                @endphp

                                @if ($row2->identifier == 'HLCAL-HLCA')
                                    @php
                                        $vlp_style = 'text-left padding-left-1';
                                        $inclusive_dates = '';
                                        $earned = $row2->value;
                                        $awp = '';
                                        $aldp = '';
                                        $runningBalance += $row2->value;
                                        $totalEarned += $row2->value;
                                    @endphp
                                @else
                                    @php
                                        $vlp_style = 'text-right padding-right-1';
                                        $earned = '';
                                        $awp = $row2->value;
                                        $aldp = $row2->hl_date_processing ? date_format(date_create( $row2->hl_date_processing ), 'm/d/Y') : '';
                                    @endphp

                                    @if ($row2->date_from == $row2->date_to)
                                        @php
                                            $inclusive_dates = date_format(date_create($row2->date_from), 'm/d/Y');
                                        @endphp
                                    @else
                                        @php
                                            $inclusive_dates = date_format(date_create($row2->date_from), 'm/d/Y') . ' - ' . date_format(date_create($row2->date_to), 'm/d/Y');
                                        @endphp
                                    @endif

                                    @if ($row2->hl_is_with_pay == "Yes" && $row2->hl_status == "Approved")
                                        @php
                                            $runningBalance = $runningBalance - $row2->value;
                                            $totalUsed += $row2->value;
                                        @endphp
                                    @endif

                                    @php
                                        $runningBalance = ($runningBalance > 0) ? $runningBalance : '0';
                                    @endphp
                                @endif

                                <tr style="height: 0.6cm; line-height: 0.35cm;">
                                    <td>{{ $row2->hlcal_year }}</td>
                                    <td class="{{ $vlp_style }}"><div>{{ $row2->hl_period }}</div><div>{{ $row2->hl_remarks }}</div><div>{{ $vlp }}</div></td> {{-- <div>{{ $inclusive_dates }}</div> --}}
                                    <td>{{ $earned }}</td>
                                    <td>{{ $awp }}</td>
                                    <td>{{ $aldp }} <div>{{ $row2->hl_status }}</div> </td>
                                    <td>{{ number_format($runningBalance, 3) }}</td>
                                </tr>
                            @endforeach

                            {{-- for checking purposes --}}
                            <tr style="height: 0.6cm; line-height: 0.35cm;">
                                <td colspan="8" style="border: none;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right; padding-right: 1mm;">TOTAL</td>
                                <td><b>{{ number_format($totalEarned, 3) }}</b></td>
                                <td><b>{{ number_format($totalUsed, 3) }}</b></td>
                                @php
                                    $checkingBalance = $totalEarned - $totalUsed;
                                @endphp
                                <td></td>
                                <td><b>{{ number_format($checkingBalance, 3) }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
@endif

<script>
    const table = document.querySelector('.table-leave-card-service-credit');
    let headerCell0 = null;

    for (let row of table.rows) {
        const cell0 = row.cells[0];

        if (headerCell0 === null || cell0.innerText !== headerCell0.innerText) {
            headerCell0 = cell0;
        } else {
            headerCell0.rowSpan++;
            cell0.remove();
        }
    }
</script>

<script>
    const table2 = document.querySelector('.table-leave-card-cto');
    let headerCell0_2 = null;

    for (let row2 of table2.rows) {
        const cell0_2 = row2.cells[0];

        if (headerCell0_2 === null || cell0_2.innerText !== headerCell0_2.innerText) {
            headerCell0_2 = cell0_2;
        } else {
            headerCell0_2.rowSpan++;
            cell0_2.remove();
        }
    }
</script>

<script>
    const table3 = document.querySelector('.table-leave-card-vacation-leave');
    let headerCell0_3 = null;

    for (let row3 of table3.rows) {
        const cell0_3 = row3.cells[0];

        if (headerCell0_3 === null || cell0_3.innerText !== headerCell0_3.innerText) {
            headerCell0_3 = cell0_3;
        } else {
            headerCell0_3.rowSpan++;
            cell0_3.remove();
        }
    }
</script>

<script>
    const table4 = document.querySelector('.table-leave-card-sick-leave');
    let headerCell0_4 = null;

    for (let row4 of table4.rows) {
        const cell0_4 = row4.cells[0];

        if (headerCell0_4 === null || cell0_4.innerText !== headerCell0_4.innerText) {
            headerCell0_4 = cell0_4;
        } else {
            headerCell0_4.rowSpan++;
            cell0_4.remove();
        }
    }
</script>

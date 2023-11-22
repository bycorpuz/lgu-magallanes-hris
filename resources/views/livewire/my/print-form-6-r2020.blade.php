<style>
    @media print {.page {page-break-after: always;break-after: always;}}

    table {width: 100%; table-layout: fixed; word-wrap: break-word; border-spacing: 0; border-collapse: collapse;}

    .body, table {font-family:"Calibri";font-size: 10pt;}

    .table-1 .left {width:50%;line-height: 4mm;font-style: italic;font-size: 8pt;font-weight: bold;line-height: 3mm;}
    .table-1 .right {width:50%;font-weight: bold;font-size: 14pt;text-align: right;}

    .table-2 {margin-top: 3mm;}
    .table-2 .left {width:30%;text-align: center;}
    .table-2 .center {width:40%;font-size: 12pt;text-align: center;line-height: 4mm;letter-spacing: 0.2mm;}
    .table-2 .right {width:30%;text-align: center;}
    .table-2 .right .stamp{ width: 60%;margin-left: 25%;border: 1px dashed black;padding: 2mm;font-size: 9pt;vertical-align: middle;}
    .table-2 .left img {width: 15mm;text-align: center;}

    .title {font-size: 16pt;font-weight: bold;text-align: center;letter-spacing: 0.5mm;margin: 3mm;}

    .table-3 table .tr1 {border: 1px solid black; border-bottom: none;}
    .table-3 table .tr1 .td1 {padding-left: 1mm;width: 34%;}
    .table-3 table .tr1 .td2 {width: 22%;}
    .table-3 table .tr1 .td3 {width: 22%;}
    .table-3 table .tr1 .td4 {width: 22%;}
    .table-3 table .tr2 {border: 1px solid black; border-top: none;}
    .table-3 table .tr2 .td1 {padding-left: 1mm;}

    .table-4 table .tr1 {border: 1px solid black; border-top: none;border-bottom: none;}
    .table-4 table .tr1 .td1 {padding-left: 1mm;width: 34%;}
    .table-4 table .tr1 .td2 {width: 44%;}
    .table-4 table .tr1 .td3 {width: 22%;}
    .table-4 table .tr2 {border: 1px solid black; border-top: none;}
    .table-4 table .tr2 .td1 {padding-left: 1mm;}

    .table-5 table .tr1 {border: 1px solid black;font-weight: bold;text-align: center;letter-spacing: 0.1mm;}

    .img {height: 4mm;}

    .table-6 table .tr1 {border: 1px solid black;}
    .table-6 table .tr1 .td1 {width: 60%;border-right:1px solid black;padding-left: 1mm;vertical-align: top;}
    .table-6 table .tr1 .td2 {width: 40%;padding-left: 1mm;vertical-align: top;}
    .table-6 .leave-types {margin-top: -4.2mm; margin-left: 4.2mm;}
    .table-6 .leave-desc {font-size: 7.7pt;}
    .table-6 .others {padding-top: 2mm;}
    .table-6 .others2 {width:60%; border-bottom: 1px solid black; margin: -1mm 0 2mm 12mm;text-align: center;}
    .table-6 .details {margin-top: -4.2mm; margin-left: 4.2mm;}
    .table-6 .details2 {margin-top: -4.5mm; margin-left: 38mm; border-bottom: 1px solid black;}
    .table-6 .details3 {margin-top: -4.5mm; margin-left: 27mm; border-bottom: 1px solid black;}
    .table-6 .details4 {margin-top: -4.5mm; margin-left: 39mm; border-bottom: 1px solid black;}
    .table-6 .details5 {margin-top: -4.5mm; margin-left: 40mm; border-bottom: 1px solid black;}
    .table-6 .detailss {margin-top: -4.2mm;}
    .table-6 .details6 {margin-top: -4.5mm; margin-left: 19mm; border-bottom: 1px solid black;}

    .table-7 table .tr1 {border: 1px solid black; border-top: none;}
    .table-7 table .tr1 .td1 {width: 60%;border-right:1px solid black;padding-left: 1mm;vertical-align: top;}
    .table-7 table .tr1 .td2 {width: 40%;padding-left: 1mm;vertical-align: top;}
    .table-7 .details {margin-left: 12mm; border-bottom: 1px solid black; width: 60%; text-align: center;}
    .table-7 .details1 {margin-top: 1mm;margin-left: 5.5mm;}
    .table-7 .details2 {margin-top: -4.2mm; margin-left: 4.2mm;}
    .table-7 .details3 {text-align: center;text-decoration:underline; font-weight: bold;}
    .table-7 .details4 {text-align: center;font-size: 7.7pt; text-decoration: overline;}

    .table-8 table .tr1 {border: 1px solid black;font-weight: bold;text-align: center;letter-spacing: 0.1mm;}

    .table-9 table .tr1 {border: 1px solid black;}
    .table-9 table .tr1 .td1 {width: 60%;border-right:1px solid black;padding-left: 1mm;vertical-align: top;}
    .table-9 table .tr1 .td2 {width: 40%;padding-left: 1mm;vertical-align: top;}
    .table-9 .details {margin-left: 22mm;}
    .table-9 .details1 {width:50%;margin-top: -4.5mm;margin-left: 30mm;border-bottom: 1px solid black;}
    .table-9 .details2 {margin-top: -4.2mm; margin-left: 4.2mm;}
    .table-9 .details3 {margin-top: -4.5mm; margin-left: 38mm;border-bottom: 1px solid black;}
    .table-9 .details4 {margin-left: 4.2mm;border-bottom: 1px solid black;}
    .table-9 .details5 {text-align: center;text-decoration:underline; font-weight: bold;}
    .table-9 .details6 {text-align: center;font-size: 7.7pt;}

    .table-9 .table-2{width:90%;margin-top: 2mm;margin-left: 2.5mm;}
    .table-9 .td{border: 1px solid black;text-align: center;line-height: 2.5mm;height:5.5mm;width: 20mm;font-size: 9pt;}
    .table-9 .details7 {text-align: center;text-decoration:underline; font-weight: bold;}
    .table-9 .details8 {text-align: center;font-size: 7.7pt;}

    .table-10 table .tr1 {border: 1px solid black; border-top: none; border-bottom: none;}
    .table-10 table .tr1 .td1 {width: 60%;padding-left: 1mm;vertical-align: top;}
    .table-10 table .tr1 .td2 {width: 40%;padding-left: 1mm;vertical-align: top;}
    .table-10 .details {width:110px;border-bottom: 1px solid black;}
    .table-10 .details1 {margin-top:-4.5mm;margin-left: 30mm;}
    .table-10 .details2 {margin-left: 4.2mm;border-bottom: 1px solid black;}

    .table-10 table .tr2 {border: 1px solid black; border-top: none;}
    .table-10 .details3 {text-align: center;text-decoration:underline; font-weight: bold;}
    .table-10 .details4 {text-align: center;font-size: 7.7pt;}

</style>
<div class="page">
    <div class="body">
        <div class="table-1">
            <table>
                <tr>
                    <td class="left">
                        Civil Service Form No.6 <br>
                        Revised 2020
                    </td>
                    <td class="right">
                        ANNEX A
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-2">
            <table>
                <tr>
                    <td class="left">
                        <img src="{{ asset('images/site/logo.jpg') }}" alt="Logo" class="logo">
                    </td>
                    <td class="center">
                        Republic of the Philippines <br>
                        Province of Agusan del Norte <br>
                        MUNICIPALITY OF MAGALLANES
                    </td>
                    <td class="right">
                        <div class="stamp">Stamp of Date of Receipt</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="title">APPLICATION FOR LEAVE</div>

        <div class="table-3">
            <table>
                <tr class="tr1">
                    <td class="td1">1. OFFICE/DEPARTMENT</td>
                    <td class="td2">2. NAME: (Last)</td>
                    <td class="td3">(First)</td>
                    <td class="td4">(Middle)</td>
                </tr>
                <tr class="tr2">
                    <td class="td1"><b>MUNICIPALITY OF MAGALLANES</b></td>
                    <td><b>{{$data->userPersonalInformations->lastname}}</b></td>
                    <td><b>{{$data->userPersonalInformations->firstname}}</b></td>
                    <td><b>{{$data->userPersonalInformations->middlename}}</b></td>
                </tr>
            </table>
        </div>

        <div class="table-4">
            <table>
                <tr class="tr1">
                    <td class="td1">3. DATE OF FILING</td>
                    <td class="td2">4. POSITION</td>
                    <td class="td3">5. SALARY (Monthly)</td>
                </tr>
                <tr class="tr2">
                    <td class="td1"><b>{{date_format(date_create($data->created_at), 'm/d/Y')}}</b></td>
                    <td><b>{{$data->user_id ? $data->userPersonalInformations->userPlantilla->position->name : '&nbsp;'}}</b></td>
                    <td><b>{{empty($data->userPersonalInformations->userPlantilla->salary->basic) ? '' : number_format($data->userPersonalInformations->userPlantilla->salary->basic, 2)}}</b></td>
                </tr>
            </table>
        </div>

        <div class="table-5">
            <table>
                <tr class="tr1">
                    <td class="td1">6. DETAILS OF APPLICATION</td>
                </tr>
            </table>
        </div>

        <div class="table-6">
            <table>
                <tr class="tr1">
                    <td class="td1">
                        <div>6.A TYPE OF LEAVE TO BE AVAILED OF</div>
                        @foreach (getLeaveTypes('for_form') as $leaveType)
                            @if ($data->leave_type_id == $leaveType->id)
                                @php
                                    $src = "/images/site/checkbox-checked.png";
                                @endphp
                            @else
                                @php
                                    $src = "/images/site/checkbox-unchecked.png";
                                @endphp
                            @endif

                            <div><img class="img" src={{ $src }}></div>
                            <div class="leave-types">{{ $leaveType->name }} <span class="leave-desc">{{ $leaveType->description }}</span></div>
                        @endforeach

                        <div class="others">Others: </div>
                        @if ($data->leaveType->for_form == 'No')
                            <div class="others2">&nbsp; {{ $data->leaveType->name }}</div>
                        @else
                            <div class="others2">&nbsp; </div>
                        @endif
                    </td>
                    <td class="td2">
                        <div>6.B DETAILS OF LEAVE</div>
                        <div><i>In case of Vacation/Special Privilege Leave:</i></div>

                        @if ($data->details_b1 == 'Yes')
                            @php
                                $src1 = "/images/site/checkbox-checked.png";
                                $info1 = $data->details_b1_name;

                                $src2 = "/images/site/checkbox-unchecked.png";
                                $info2 = "&nbsp;";
                            @endphp
                        @elseif ($data->details_b1 == 'No')
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $info1 = "&nbsp;";

                                $src2 = "/images/site/checkbox-checked.png";
                                $info2 = $data->details_b1_name;
                            @endphp
                        @else
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $info1 = "&nbsp;";

                                $src2 = "/images/site/checkbox-unchecked.png";
                                $info2 = "&nbsp;";
                            @endphp
                        @endif

                        <div><img class="img" src={{ $src1 }}></div>
                        <div class="details">Within the Philippines:</div>
                        <div class="details2"><?php echo $info1 ?></div>

                        <div><img class="img" src={{ $src2 }}></div>
                        <div class="details">Abroad <span class="leave-desc">(Specify):</span></div>
                        <div class="details2"><?php echo $info2 ?></div>

                        <div><i>In case of Sick Leave:</i></div>

                        @if ($data->details_b2 == 'Yes')
                            @php
                                $src1 = "/images/site/checkbox-checked.png";
                                $info1 = $data->details_b2_name;

                                $src2 = "/images/site/checkbox-unchecked.png";
                                $info2 = "&nbsp;";
                            @endphp
                        @elseif ($data->details_b2  == 'No')
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $info1 = "&nbsp;";

                                $src2 = "/images/site/checkbox-checked.png";
                                $info2 = $data->details_b2_name;
                            @endphp
                        @else
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $info1 = "&nbsp;";

                                $src2 = "/images/site/checkbox-unchecked.png";
                                $info2 = "&nbsp;";
                            @endphp
                        @endif

                        <div><img class="img" src={{ $src1 }}></div>
                        <div class="details">In Hospital <span class="leave-desc">(Specify Illness):</span></div>
                        <div class="details4"><?php echo $info1 ?></div>

                        <div><img class="img" src={{ $src2 }}></div>
                        <div class="details">Out Patient <span class="leave-desc">(Specify Illness):</span></div>
                        <div class="details5"><?php echo $info2 ?></div>

                        <div><i>In case of Special Leave Benefits for Women:</i></div><br>

                        <div class="detailss"><span class="leave-desc">(Specify Illness):</span></div>
                        <div class="details6"><?php echo $data->details_b3_name ? $data->details_b3_name : '&nbsp;' ?></div>

                        <div><i>In case of Study Leave:</i></div>

                        @if ($data->details_b4 == 'Yes')
                            @php
                                $src1 = "/images/site/checkbox-checked.png";
                                $src2 = "/images/site/checkbox-unchecked.png";
                            @endphp
                        @elseif ($data->details_b4  == 'No')
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $src2 = "/images/site/checkbox-checked.png";
                            @endphp
                        @else
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $src2 = "/images/site/checkbox-unchecked.png";
                            @endphp
                        @endif

                        <div><img class="img" src={{ $src1 }}></div>
                        <div class="details">Completion of Master's Degree</div>

                        <div><img class="img" src={{ $src2 }}></div>
                        <div class="details">BAR/Board Examination Review</div>

                        <div><i>Other purpose:</i></div>

                        @if ($data->details_b5 == 'Yes')
                            @php
                                $src1 = "/images/site/checkbox-checked.png";
                                $src2 = "/images/site/checkbox-unchecked.png";
                            @endphp
                        @elseif ($data->details_b5  == 'No')
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $src2 = "/images/site/checkbox-checked.png";
                            @endphp
                        @else
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $src2 = "/images/site/checkbox-unchecked.png";
                            @endphp
                        @endif

                        <div><img class="img" src={{ $src1 }}></div>
                        <div class="details">Monetization of Leave Credits</div>

                        <div><img class="img" src={{ $src2 }}></div>
                        <div class="details">Terminal Leave</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-7">
            <table>
                <tr class="tr1">
                    <td class="td1">
                        <div>6.C NUMBER OF WORKING DAYS APPLIED FOR</div>
                        <div class="details">{{$data->days + 0}} {{$days}}</div>

                        <div class="details1">INCLUSIVE DATES</div>
                        <div class="details">
                            {{ $inclusive_dates }}
                        </div>
                    </td>
                    <td class="td2">
                        <div>6.D COMMUTATION</div>

                        @if ($data->details_d1 == 'No')
                            @php
                                $src1 = "/images/site/checkbox-checked.png";
                                $src2 = "/images/site/checkbox-unchecked.png";
                            @endphp
                        @elseif ($data->details_d1  == 'Yes')
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $src2 = "/images/site/checkbox-checked.png";
                            @endphp
                        @else
                            @php
                                $src1 = "/images/site/checkbox-unchecked.png";
                                $src2 = "/images/site/checkbox-unchecked.png";
                            @endphp
                        @endif

                        <div><img class="img" src={{ $src1 }}></div>
                        <div class="details2">Not Requested</div>

                        <div><img class="img" src={{ $src2 }}></div>
                        <div class="details2">Requested</div>

                        <div style="text-align: center; margin-top: 3mm; margin-bottom: -5px;"><img src="{{ asset('images/site/blank.png') }}" style="width: 70px;" alt="e-signature"></div>
                        <div class="details3"></div>
                        <div class="details4">(Signature of Applicant)</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-8">
            <table>
                <tr class="tr1">
                    <td class="td1">7. DETAILS OF ACTION ON APPLICATION</td>
                </tr>
            </table>
        </div>

        <div class="table-9">
            <table>
                <tr class="tr1">
                    <td class="td1">
                        <div>7.A CERTIFICATION OF LEAVE CREDITS</div>
                        <div class="details">As of</div>
                        <div class="details1">&nbsp;</div>

                        <div class="table-2">
                            <table>
                                <tr>
                                    <td class="td"></td>
                                    <td class="td">Vacation Leave</td>
                                    <td class="td">Sick Leave</td>
                                    <td class="td">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="td"><i>Total Earned</i></td>
                                    <td class="td">&nbsp;</td>
                                    <td class="td">&nbsp;</td>
                                    <td class="td">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="td"><i>Less this application</i></td>
                                    <td class="td">&nbsp;</td>
                                    <td class="td">&nbsp;</td>
                                    <td class="td">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="td"><i>Balance</i></td>
                                    <td class="td">&nbsp;</td>
                                    <td class="td">&nbsp;</td>
                                    <td class="td">&nbsp;</td>
                                </tr>
                            </table>
                        </div>

                        <div style="text-align: center; margin-top: 3mm; margin-bottom: -5px;"><img src="{{ asset('images/site/blank.png') }}" style="width: 70px;" alt="e-signature"></div>
                        <div class="details7">{{ getUserFullName($signatories->param1_signatory) }}</div>
                        <div class="details8">{{ $signatories->param1_designation ? getDesignations($signatories->param1_designation)->name : '(not-set)' }}</div>

                    </td>
                    <td class="td2">
                        <div>7.B RECOMMENDATION</div>
                        <div><img class="img" src="/images/site/checkbox-unchecked.png"></div>
                        <div class="details2">For approval</div>

                        <div><img class="img" src="/images/site/checkbox-unchecked.png"></div>
                        <div class="details2">For disapproval due to:</div>
                        <div class="details3">&nbsp;</div>
                        <div class="details4">&nbsp;</div>
                        <div class="details4">&nbsp;</div>
                        <div class="details4">&nbsp;</div>

                        <div style="text-align: center; margin-top: 9mm; margin-bottom: -5px;"><img src="{{ asset('images/site/blank.png') }}" style="width: 70px;" alt="e-signature"></div>
                        <div class="details5">{{ getUserFullName($signatories->param2_signatory) }}</div>
                        <div class="details6">{{ $signatories->param2_designation ? getDesignations($signatories->param2_designation)->name : '(not-set)' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-10">
            <table>
                <tr class="tr1">
                    <td class="td1">
                        <div>7.C APPROVED FOR:</div>

                        <div class="details">&nbsp;</div>
                        <div class="details1">days with pay</div>

                        <div class="details">&nbsp;</div>
                        <div class="details1">days without pay</div>

                        <div class="details">&nbsp;</div>
                        <div class="details1">others (Specify)</div>
                    </td>
                    <td class="td2">
                        <div>7.D DISAPPROVED DUE TO:</div>

                        <div class="details2">&nbsp;</div>
                        <div class="details2">&nbsp;</div>
                        <div class="details2">&nbsp;</div>
                    </td>
                </tr>

                <tr class="tr2">
                    <td class="td1" colspan="2">
                        <div style="text-align: center; margin-top: 3mm; margin-bottom: -5px;"><img src="{{ asset('images/site/blank.png') }}" style="width: 70px;" alt="e-signature"></div>
                        <div class="details3">{{ getUserFullName($signatories->param3_signatory) }}</div>
                        <div class="details4">{{ $signatories->param3_designation ? getDesignations($signatories->param3_designation)->name : '(not-set)' }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

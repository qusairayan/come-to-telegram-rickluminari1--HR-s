<!DOCTYPE html>
<html>
<head>

    <head>
        <title>Part Time Report -{{ $user['company'] }}</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;

            }

            @page {
                margin: 10px 10px 10px 10px !important;
                padding: 10px1 0px 10px 10px !important;
            }

            table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: separate;
                width: 100%;
            }

            table th {
                border: 1px solid #000;
                padding: 2px
            }

            table th {
                text-align: center;
                background-color: #F7F9F9;
                color: black;
            }

            table td {
                text-align: center;
                padding-bottom: 5px;
                padding: 8px;
                border-collapse: collapse;
            }

            .column {
                float: left;
                width: 50%;
                padding: 10px;
            }

            .row:after {
                content: "";
                display: table;
                clear: both;
            }
        </style>

    </head>

<body>


    <div style="padding:5mm; margin: bottom 25px;">
        <div class="row">
            <div class="column" style="width:20%">
                {{-- <img src="/storage/company/{{ $image }}" height="70" width="160" /> --}}

            </div>
            <div class="column" style="width:70%">
                <p style="font-size:18px;text-align:center"><b>{{ $user['company'] }}</b></p>
            </div>
        </div>
    </div>
    <div style="color: white;background-color: #03415F;" class="row">
        <div class="column" style="padding:4px;width: 100%">
            <p style="text-align: center; font-size:18px;color: #fff;margin:0;padding:5;"><b>Part Times Report</b>
            </p>
        </div>
    </div>
    <br>
    <div class="row" style="background: #03415F; ma">
        <div class="column" style="padding:0; width:20%">
            <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">Employee :</p>
        </div>
        <div class="column" style="padding:0;margin-left:3px; width:33%">
            <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $user['name'] }} -
                {{ $user['id'] }}</p>
        </div>



        <div class="column" style="padding:0; width:10%">
            <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">From :</p>
        </div>

        <div class="column" style="padding:0;margin-left:3px; width:14%">
            <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $from }}</p>
        </div>

        <div class="column" style="padding:0; width:10%">
            <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">To :</p>
        </div>
        <div class="column" style="padding:0;margin-left:3px; width:10%">
            <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $to }}</p>
        </div>
    </div>

    <div class="row" style="background: #03415F; ma">
        <div class="column" style="padding:0; width:20%">
            <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">Department :</p>
        </div>
        <div class="column" style="padding:0;margin-left:3px; width:33%">
            <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $user['department'] }} -
                {{ $user['position'] }}</p>
        </div>

        <div class="column" style="padding:0; width:10%">
            <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">Salary :</p>
        </div>
        <div class="column" style="padding:0;margin-left:3px; width:10%">
            <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $user['salary'] }} JD -
                {{ $user['part_time'] }}</p>
        </div>
    </div>
    <br>
    <table id="account">
        <tr>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px; width: 11%">From</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 22%">To</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Debit</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Credit</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Balance
            </th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Details
            </th>
        </tr>
        <tr>
            <td style="text-align: center;padding-top: 8px; width: 10%">{{ $from }}</td>
            <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
            <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
            <td style="text-align: center;padding-top: 8px; width: 10%"></td>
            <td style="text-align: center;padding-top: 8px; width: 10%">{{ $reBalance }}</td>
            <td style="text-align: center;padding-top: 8px; width: 10%; ">PRE Balance</td>
        </tr>



        @php($totalDebit = 0)
        @php($total = 0)
        @php($totalCredit = 0)
        @foreach ($data as $key => $row)
            @php($totalDebit += $row['type'] == 'salary' || $row['type'] == 'allownce' ? $row['amount'] : 0)
            @php($totalCredit += $row['type'] == 'check' || $row['type'] == 'dedction' ? $row['amount'] ?? $row['Value'] : 0)
            @php($reBalance -= $row['type'] == 'check' ? $row['Value'] : 0)
            @php($reBalance += $row['type'] === 'allownce' ? $row['amount'] : 0)
            @php($reBalance -= $row['type'] == 'dedction' ? $row['amount'] : 0)
            @php($reBalance += $row['type'] == 'salary' ? $row['amount'] : 0)
            @php($total += $reBalance)
            <tr>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $row['date'] }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">
                    {{ $row['type'] == 'salary' ? $row['to'] : '-' }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">
                    {{ $row['type'] === 'allownce' || $row['type'] === 'salary' ? $row['amount'] : '-' }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">
                    {{ $row['type'] === 'dedction' || $row['type'] == 'check' ? $row['amount'] ?? $row['Value'] : '-' }}
                </td>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $reBalance }}</td>
                @if (isset($row['name']))
                    <td style="text-align: center;padding-top: 8px; width: 10%">{{ $row['name'] }}</td>
                @else
                    <td style="text-align: center;padding-top: 8px; width: 10%">
                        {{ $row['type'] == 'allownce' || $row['type'] == 'dedction' ? $row['detail'] : $row['type'] }}
                    </td>
                @endif
            </tr>
        @endforeach
        @foreach ($pending as $row)
            <tr>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $row['from'] }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">
                    -</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">
                    -</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">
             -
                </td>
                <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
                @if (isset($row['name']))
                    <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
                @else
                    <td style="text-align: center;padding-top: 8px; width: 10%">
                        pending
                    </td>
                @endif
            </tr>
        @endforeach
        @if (count($partTime) > 0 || count($data) > 0)
            <tr>
                <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 22%"
                    colspan="2">Total:</th>

                <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">
                    {{ $totalDebit }}
                </th>
                <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">
                    {{ $totalCredit }}
                </th>
                <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">
                    {{-- {{ $total }} --}}
                    {{  $reBalance}}
                </th>
                <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">
                </th>

            </tr>
        @else
            <tr>
                <th style="text-align: center; color: #03415F; font-size: 17px;  "colspan="6"> No Records
                </th>

            </tr>
        @endif
    </table>
</body>

</html>
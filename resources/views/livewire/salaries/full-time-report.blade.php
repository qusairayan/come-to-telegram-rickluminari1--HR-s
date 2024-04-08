<!DOCTYPE html>
<html>

<head>

    <head>
        <title>Full Time Report -{{ $user['name'] }}</title>
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
    
    <div class="fullTimeReport">
        <div style="padding:5mm; margin: bottom 25px;">
            <div class="row">
                <div class="column" style="width:20%">
                    {{-- <img src="/storage/company/{{ $user['image'] }}" height="70" width="160" /> --}}
                </div>
                <div class="column" style="width:70%">
                    <p style="font-size:18px;text-align:center"><b>{{ $user['company'] }}</b></p>
                </div>
            </div>
        </div>
        <div style="color: white;background-color: #03415F;" class="row">
            <div class="column" style="padding:4px;width: 100%">
                <p style="text-align: center; font-size:18px;color: #fff;margin:0;padding:5;"><b>Full Times Report</b>
                </p>
            </div>
        </div>
        <br>
        <div class="row" style="background: #03415F; ma">
            <div class="column" style="padding:0; width:20%">
                <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">Employee :</p>
            </div>
            <div class="column" style="padding:0;margin-left:3px; width:33%">
                <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $user['name']}} -
                    {{ $user["id"] }}</p>
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
                    {{ $user["position"] }}</p>
            </div>
    
            <div class="column" style="padding:0; width:10%">
                <p style="font-size:15px;color: white;margin:0;padding:4;font-weight:bold">Salary :</p>
            </div>
            <div class="column" style="padding:0;margin-left:3px; width:10%">
                <p style="font-size:12px;color: white;margin:0;padding:4;font-weight:bold">{{ $user['salary'] }} JD </p>
            </div>
        </div>
        <br>
    <table id="account">
        <tr>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px; width: 11%">From</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 22%">Transaction</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Debit</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Credit</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Balance</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">Details</th>
        </tr>
        <tr>
            <td style="text-align: center;padding-top: 8px; width: 10%">{{ $from }}</td>
            <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
            <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
            <td style="text-align: center;padding-top: 8px; width: 10%">-</td>
            <td style="text-align: center;padding-top: 8px; width: 10%">{{ abs($preBalance) }}</td>
            <td style="text-align: center;padding-top: 8px; width: 10%; ">PRE Balance</td>
        </tr>
        @php($totalDebit =0)
        @php($total =$preBalance)
        @php($totalCredit =0)
        @foreach ($arr as $key => $row)
        @if(getType($row) == "array")
        @php($total += $row["salary"])
        @php($totalDebit +=$row["salary"])
            <tr>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ substr($row['month'],0,7) }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">0</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $row['salary'] }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">0</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $total }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%; ">salary</td>
            </tr>
        @else
        @php($totalCredit += $row->Value)
        @php($total -= $row->Value)
            <tr>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $row->month }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{$row->Payment_Method}}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%">0</td>
                <td style="text-align: center;padding-top: 8px; width: 10%"> {{ $row->Value }} </td>
                <td style="text-align: center;padding-top: 8px; width: 10%">{{ $total }}</td>
                <td style="text-align: center;padding-top: 8px; width: 10%; ">{{$row->check_details}}</td>
            </tr>
        @endif
 @endforeach
        <tr>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 22%" colspan="2">Total:</th>                
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%"> {{ $totalDebit }} </th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%"> {{ $totalCredit }} </th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%">{{ $total }}</th>
            <th style="text-align: center; background-color:#03415F;color: #fff; font-size: 12px;width: 14%"></th>                
        </tr>
    </table>
    </div>
</body>
</html>
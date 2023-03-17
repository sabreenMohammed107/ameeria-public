<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
           margin-top: 320px;
            margin-bottom: 100px;

        }

        .footer {
            font-size: 12px;
            padding: 5px 10px;

            width: 70%;
            margin: auto;
            text-align: center;
            margin-top: 40px
        }

        header {
            position: fixed;

            top: -320px;

            height: 320px;

        }

        footer {
            position: fixed;
            bottom: -80px;
            left: 0px;
            right: 0px;
            height: 100px;
        }


        html,
        body,
        .body {
            box-sizing: border-box;

        }

        .body-page {
            /* padding: 35px 0 0; */

            width: 100%;
        }

        .container {
            width: 90%;
            margin: auto;

        }

        span {
            color: grey;
        }

        .headerr,
        .hero {
            /* margin-top: 10px; */
            width: 100%;

        }

        .headerr {
            margin-top: 0;

        }

        .headerr .logo,
        .headerr .logo2 {
            width: 70%;
            float: left;
        }

        .headerr .logo-name {
            width: 30%;
            float: left;
            /* text-align: center; */
        }

        .logo img {
            width: 30%;
        }

        .headerr .logo-date {
            width: 30%;
            float: right;
            /* text-align: center; */
        }

        .hero .logo2 {
            width: 70%;
            float: left;
        }

        .hero-data {
            width: 60%;
            float: left;
        }

        .hero .logo-date {
            width: 30%;
            float: left;
            /* text-align: center; */
            /* margin-left: -23px; */
            /* background: #ccc; */
        }

        table {
            border-collapse: collapse;
        }

        td {
            text-align: center;
            color: #333;
            border-bottom: 1px solid #ccc;
            border-width: thin;
            padding: 20px 0;

        }

        #table td {
            border-bottom: none;
            padding: 0 !important;
            margin: 0;
        }

        td p {
            padding: 5px !important;
            margin: 0;
        }


    </style>
</head>

<body>

    <header>
        <div class="container">

            <div class="headerr">

                <div class="logo">
                    <img src="{{ public_path('webassets/dist/img/download.jpg')}}" alt="">
                </div>
                <div class="logo-name">
                    <h1 style="font-size: 35px;">تقرير الفاتورة</h1>
                </div>
                <div style="clear: both;"></div>
            </div>
            <hr>

            <div class="headerr">
                <div class="logo2">

                </div>
                <div class="logo-date">
                    <?php $dateinvoice = date_create($invoice->date)
                    ?>

                    <p>Date : <span style="color: #333;">
                            {{ date_format($dateinvoice,'Y-m-d') ?? '' }}
                        </span></p>
                    <p>Statement # : <span style="color: #333;">
                            {{ $invoice->invoice_no }}
                        </span></p>

                </div>
                <div style="clear: both;"></div>
            </div>

            <hr>
            <!-- next section -->
            <div class="hero">
                <div class="logo2">
                    <!-- <div class="hero-data"> -->
                    <p>To:<span style="color: #333;">{{$invoice->operation->sale->client->client_name ?? '' }}
                            <br> {{$invoice->operation->sale->client->address ?? '' }}</span></p>
                    <!-- </div> -->
                </div>
                <div class="logo-date">
                    <p>
                        @if($invoice->operation->ocean)
                        Pol:
                        @elseif($invoice->operation->air)
                        Aol:
                        @else

                        @endif
                        <span>{{$invoice->operation->ocean->ocean->pol->port_name ?? '' }}{{$invoice->operation->air->air->aol->port_name ?? '' }}</span>
                    </p>
                    <p> @if($invoice->operation->ocean)
                        Pod:
                        @elseif($invoice->operation->air)
                        Aod:
                        @else

                        @endif
                        <span>{{$invoice->operation->ocean->ocean->pod->port_name ?? '' }}{{$invoice->operation->air->air->aod->port_name ?? '' }}</span>
                    </p>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>

    </header>
    <footer>
        <div class="container">
        <div class="footer">
            <p>Make all transfers and checks payable to <b>OVER SEAS EGYPT </b></p>
            QNB EGP ACC # 00701-20317446147-53 | QNB USD ACC # 00701-20319927487-07<br>
            <b> Thank you for your business ! </b></p>
            </div>
        </div>
    </footer>

    <div class="container" >
    <!-- table -->
    <div class="hero" >
        <table width="100%">
            <thead style="border-bottom: 1px solid #ccc; background:#333;color:#fff">
                <tr>
                    <th>Ref#</th>
                    <th>B/L#</th>
                    <th>Volume</th>
                    <th>Loding Date</th>
                </tr>
            </thead>
            <tbody>
                <td>{{$invoice->operation->operation_code}}</td>
                <td>{{$invoice->operation->pl_no}}</td>
                <td>{{$invoice->operation->container_counts }} @if($invoice->operation->ocean) <span>X</span> @endif {{$invoice->operation->ocean->ocean->container->container_size ?? ''}} {{ $invoice->operation->ocean->ocean->container->container_type ?? ''}}</td>
                <td> <?php $dateinvoice = date_create($invoice->operation->loading_date)
                        ?>
                    {{ date_format($dateinvoice,'Y-m-d') ?? '' }}
                </td>


            </tbody>

        </table>
    </div>
    <div class="hero" style="margin-top:20px">
        <table width="100%">
            <thead style=" border-bottom:1px solid #ccc;
                border-width: thin;background:#333 ;color:#fff ">
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Cur </th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody style="">

                @foreach($rows as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>@if($row->automatic == 1) {{$row->provider->expenses_name ?? ''}}  @else {{$row->type->expense_name ?? ''}}  @endif</td>
                    <td>{{ $row->operation->container_counts}} @if($row->operation->ocean) <span>X</span> @endif {{$row->operation->ocean->ocean->container->container_size ?? ''}} {{ $row->operation->ocean->ocean->container->container_type ?? ''}}</td>
                    <td>{{$row->sell}}</td>
                    <td></i>{{$row->currency->currency_name}}</td>
                    <td></i>
                        @if($row->automatic==1)
                        {{$row->sell *$row->operation->container_counts}}
                        @else
                        {{$row->sell *1}}
                        @endif
                    </td>
                </tr>

                @endforeach



            </tbody>
        </table>
    </div>
    <div class="hero" style="margin-top: 20px;">
        <div class="hero-data" style="width: 100%">

            <table width="100%" id="table" style="font-size: 14px;border:none" cellspacing="0" cellpadding="0" page-break-inside: auto;>
                <thead>
                    <tr>
                        <th colspan="3"></th>
                        <th style=" border-bottom:1px solid #ccc;
                border-width: thin;background:#eee ;color:#333 ;padding:8px 0px" colspan="2">Summary</th>

                    </tr>
                <tbody>
                    @foreach($curs as $cur)



                    <tr style="padding: 0;">
                        <td style="width: 20%;"></td>
                        <td style="width: 20%;"></td>
                        <td style="width: 20%;"></td>
                        <td style="background-color: #eee; padding:0">
                            <p style="text-align: left;font-weight:bold">Total - {{$cur}}</p>
                        </td>
                        @foreach($totals as $total)
                        @if($total->cur===$cur)
                        <td style="background-color: #eee;text-align:right">

                        {{" " . number_format($total->num, 2, '.', ',')  }} <br>

                        </td>
                        @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td style="width: 20%;"></td>
                        <td style="width: 20%;"></td>
                        <td style="width: 20%;"></td>

                        @foreach($totals as $total)
                        @if($total->cur===$cur)
                        <td colspan="2" style="background-color: #eee;border-bottom:1px solid #333;text-align:center;font-weight:bold">


                        {{$total->total}}
                        </td>
                        @endif
                        @endforeach
                    </tr>


                    @endforeach

                </tbody>
            </table>
        </div>
        <div style="clear: both;"></div>
    </div>

    </div>

<p></p>

</body>

</html>

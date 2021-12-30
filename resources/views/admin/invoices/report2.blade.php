<html>

<head>
    <style>
        @page {
	header: page-header;
    footer: page-footer;
    margin-top: 120px;
}
.header{
    padding: 2px 10px;
    width: 100%;
    font-size: 16px;
    text-align: center;
    /* background: #021625; */
   /* / color: #fff; */
    /* float: left; */

}
.footer{
    /* padding: 5px 10px; */
    width: 100%;
    font-size: 16px;
    text-align: center;
    /* background: #021625;
    color: #fff; */
}
        .borderless tr {
            border: none;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
            padding-top: 25px;
            box-sizing: border-box;
            margin: 0;
            padding: 0;

        }

        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-size: 10px;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        body {
            margin: 0;

        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }

        .container:before,
        .container:after {
            display: table;
            content: " ";
        }

        .container:after {
            clear: both;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .panel-body {
            padding: 15px;
        }

        .panel-heading {
            padding: 0px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .panel-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;

        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-default>.panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }

        .panel-default>.panel-heading+.panel-collapse>.panel-body {
            border-top-color: #ddd;
        }

        .panel-default>.panel-heading .badge {
            color: #f5f5f5;
            background-color: #333;
        }

        .panel-default>.panel-footer+.panel-collapse>.panel-body {
            border-bottom-color: #ddd;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }


        .pull-left {
            float: left !important;
        }

        .pull-right {
            float: right !important;
        }

        .text-right {
            text-align: right;
        }

        table {
            background-color: transparent;
        }

        th {
            text-align: left;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table>thead>tr>th,
        table>tbody>tr>th,
        table>tfoot>tr>th,
        table>thead>tr>td,
        table>tbody>tr>td,
        table>tfoot>tr>td {
            padding: 80px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        table>thead>tr>th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
        }

        table td,
        table th {
            background-color: #fff !important;
        }

        table {
            border-collapse: collapse !important;
        }

        th,
        td {
            border: 1px solid #ddd !important;
        }

        strong {
            font-weight: bold;
        }

        thead {
            display: table-header-group;
        }

        tr.collapse.in {
            display: table-row;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0;
        }

        tr,
        img {
            page-break-inside: avoid;
        }

        img {
            max-width: 100% !important;
        }

        img {
            border: 0;
        }

        img {
            vertical-align: middle;
        }

        .dir-rtl {
            direction: rtl;
            text-align: right;
        }

        .dir-rtl thead tr th {
            text-align: right !important
        }

        .pr-10 {
            padding-right: 32px !important;
        }

        .center {
            direction: rtl;
            text-align: center;
            padding: 20px 10px 50px 10px;
            border: solid 1px rgba(0, 0, 0, .05);
            background-color: #f5f5f5;
            margin-bottom: 10px;

        }

    </style>

</head>

<body style="font-family:Arial;">
<div >

    <div class="container" >
        <div class="panel panel-default mb-5">
            {{-- start header --}}
            <htmlpageheader name="page-header">
                <div class="header">

            <div class="panel-heading" style="background-color:white;border:none;">
                <div class="row" style="margin-left: 15px;margin-right:15px;">
                    <div class="col-md-12">
                        <div class="row dir-rtl" style="margin-left: 15px;margin-right:15px;">
                            <div style="width: 43%;float:left;padding-top:35px">
                                <span> فاتورة رقم :
                                    {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( $inv->invoice_no)}}</span><br>
                                تاريخ الفاتورة: {{ date('Y-m-d', strtotime($inv->date)) }} <br>
                                نوع الفاتورة: {{ $inv->type->name ?? '' }}
                            </div>
                            <div style="width: 55%;float:left;padding:0">
                                <img height="120" dir="ltr" style="text-align: left;"
                                    src="{{ public_path('webassets/dist/img/amiria_logo.jpg') }}" />

                            </div>
                            <div style="clear: both"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="width: 100%;margin:10px 0;">
                <table class="table" style="border:noneكborder-left:1px solid #eee">
                    <tbody>
                        <tr style="border: none ;border-bottom:1px solid #eee;background-color: gray">
                            <td scope="row" class="text-right" style="padding:15px;background-color: #333 !important;color:#fff">
                              المشترى</td>
                            <td class="text-right" style="padding:15px;background-color: #333 !important;color:#fff">  البائع</td>

                        </tr>
                        <tr style="border: none">
                            <td scope="row" class="text-right" style="padding:15px">
                                {{ $inv->client->name ?? '' }}</td>
                            <td class="text-right" style="padding:15px">   الھیئة العامة لشؤون المطابع الامیرية</td>

                        </tr>
                        <tr style="border: none">
                            <td scope="row" class="text-right" style="padding:15px">
                                رقم التسجيل:
                                {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( $inv->client->commercial_register ?? '')}} </td>
                            <td class="text-right" style="padding:15px">رقم التسجيل:  {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(100304559)}}</td>
                        </tr>
                        <tr style="border: none">
                            <td scope="row" class="text-right" style="padding:15px">
                                رقم  السجل التجارى:
                                {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($inv->client->tax_card_id ?? '')}} </td>
                            <td class="text-right" style="padding:15px">رقم السجل التجارى:  {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(1811)}} </td>
                        </tr>
                        <tr style="border: none ;border-bottom:1px solid #eee">
                            <td scope="row" class="text-right" style="padding:15px">
                                العنوان: {{ $inv->client->address ?? '' }}</td>
                            <td class="text-right" style="padding:15px"> العنوان: 0, 0, كورنیش النیل, ا 22 إمبابة, الجيزة </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            </htmlpageheader>
            {{-- end header --}}
            <div class="panel-body" style="margin-top: 300px">
                <table class="table dir-rtl" style=" width: 100%;
                max-width: 100%;
                margin-bottom: 20px;">

                    <thead >
                        <tr style="background-color: #333 !important">

                            <th style="padding:10px;text-align:center;background-color: #333 !important;color:#fff">الكود</th>
                            <th style="padding:10px;text-align:center;background-color: #333 !important;color:#fff">اسم الصنف</th>

                            {{-- <th>الوصف</th> --}}



                            {{-- <th data-name="operation">رقم اذن التشغيل</th> --}}
                            <th style="padding:10px;text-align:center;background-color: #333 !important;color:#fff">الكمية</th>

                            <th style="padding:10px;text-align:center;background-color: #333 !important;color:#fff" data-name=price> سعر الصنف ج.م</th>
                            <th style="padding:10px;text-align:center;background-color: #333 !important;color:#fff">اجمالى ج.م</th>
                            <th style="padding:10px;text-align:center;background-color: #333 !important;color:#fff">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($invItems as $i => $itemo)
                            <tr data-id="" style="padding:10px">
                                <td style="padding:10px">

                                    <div class="input-mark-inner mg-b-22">

                                        {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( $itemo->item->code ?? ' ' )}}
                                    </div>
                                </td>

                                <td id="desc" style='width: 200px;padding:10px'>{{ $itemo->item->name ?? '' }}</td>

                                {{-- <td>
                                    <div class="input-mark-inner mg-b-22">
                                        {{ $itemo->op_permission_no }}
                                    </div>
                                </td> --}}
                                <td style='width: 150px;padding:10px'>
                                    <div class="input-mark-inner mg-b-22">
                                        {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->quantity)}}
                                    </div>
                                </td>

                                <td style='width: 150px;padding:10px'>
                                    <div class="input-mark-inner mg-b-22">
                                        {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->price)}}
                                    </div>
                                </td>

                                <td class="total_item_price" style='width: 180px;padding:10px'>

                                    <div class="input-mark-inner mg-b-22">
                                        {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->total)}}
                                    </div>
                                </td>

                                <td>
                                    <div class="input-mark-inner mg-b-22">
                                        {{ $itemo->note }}
                                    </div>
                                </td>

                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <div class="row justify-content-end dir-rtl" style="margin-left: 15px;margin-right:15px;">
                    <div class="col-md-6" style="width: 43%;float:left">
                        <table class="table" style="border:solid 1px rgba(0, 0, 0, .05)">
                            <tbody>
                                <tr>
                                    <td scope="row" class="text-right" style="padding:15px">
                                        الإجمالى ج.م</td>
                                    <th class="text-right" style="padding:15px">{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( $inv->subtotal)}}</th>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-right" style="padding:15px">
                                       اجمالى ضريبة القيمة المضافة ج.م</td>
                                    <th class="text-right" style="padding:15px">{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( $inv->tax)}}</th>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-right" style="padding:15px">
                                        إجمالى العام ج.م</td>
                                    <th class="text-right" style="padding:15px">{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($inv->total)}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6" style="width: 43%;float:left">

                    </div>

                </div>
            </div>

        </div>
        {{-- footer --}}
        <htmlpagefooter name="page-footer">
        <div class="footer" style="height: 20rem;margin-top:120px;margin:10px">
            <div class="row" style="margin-left: 15px;margin-right:15px;">
                <div class="col-md-12">
                    <div class="row" style="margin-left: 15px;margin-right:15px;">
                        <div class="col-md-6 center" style="width: 43%;float:left">
                          الملاحظات
                        </div>
                        <div class="col-md-6 center" style="width: 43%;float:left;text-align:right">
                            التوقیعات : <br>
                            الهيئة العامة لشئون المطابع الأميرية
                        </div>
                    </div>
                </div>
                <div dir="rtl" style="background: #333">
                    <span style="text-align: right;color:#fff">الصفحة رقم : {PAGENO} / {nbpg}</span>

                </div>
            </div>
        </div>
        </htmlpagefooter>
    </div>
</div>

</body>

</html>

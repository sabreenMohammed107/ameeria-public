<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>الفواتير</title>
    <style>
@page {
	header: page-header;
    footer: page-footer;
    margin-top: 100px;
}
html,body,.body{
    box-sizing: border-box;
}
.body-page{
    padding: 15px 0 0;
    direction: ltr;
    /* background: #ddd; */
    width: 100%;
}
.dir-rtl{
	direction:rtl !important;
}
.dir-ltr{
	direction:ltr !important;
}
.float-r{
	float:right !important;
}
.float-l{
	float:left !important;
}
.header{
    padding: 25px 10px;
    width: 20%;
    font-size: 10px;
    text-align: center;
    background: #021625;
    color: #fff;
    float: left;
}
.footer{
    padding: 5px 10px;
    width: 20%;
    font-size: 10px;
    text-align: center;
    background: #021625;
    color: #fff;
}
.report-header{
    float: right;
    width: 40%;
    display: inline-block;
}
.date{
    float: right;
    padding: 10px;
    width: 40%;
    font-size: 12px;
    text-align: center;
}
.image{
    width: 100%;
    text-align: center;
    clear: both;
    padding: 5px 50px 30px 10px;

    /* background: #021625; */
}
.company{
    width: 100%;
    /* background: #255; */
}
.name{
    background-color: #cecece;
    padding: 10px;
    margin: 10px;
    width: 95px;
    font-size: 12px;
    float: right;
}
.off_name{
    padding: 10 20px;
    float: right;
    width: 180px;
}
.rep_name{
    padding: 10px;
    display: inline-block;
    width: 200px;
    float: left;
    font-size: 12px;
    text-align: center;
    margin: 10px auto;
    background: #021625;
    color: #fff;
    clear: both;
}
.right{
    margin: 250px 0;
}
.right, .left{
    float: right;
    width:50%;
}
h1{
  font-size: 30px;
  color: #333;
  text-transform: uppercase;
  font-weight: 300;
  text-align: center;
  margin-bottom: 15px;
}


/* Default Table Style */
tbody tr{
    background: #fff;
}
thead tr th{
    font-weight: 100;
    font-size: 12px;
    padding: 10px;
}
tbody tr td{
    color: #222 !important;
    font-size: 12px;
    font-size: 12px;
    text-align: center;
}
section{
  margin: 80px 0;
}






    </style>
</head>
<body>
    <hr>
    <div class="body">
        <span>
            <div class="body-page">
                <htmlpageheader name="page-header">
                    <div class="header">
                        <span>رقم الصفحة : {PAGENO} / {nbpg}</span>
                    </div>
                    <div class="report-header">

                        <span>
                            <img height="80" dir="ltr" style="text-align: left;" src="{{ public_path('webassets/dist/img/download.jpg')}}" />
                            <div class="date">
                                <span>التاريخ : {{$Today}}</span>
                            </div>
                            <div class="date">
                                <span dir="rtl">اسم المستخدم : {{$User->user_name}}</span>
                            </div>
                        </span>

                    </div>
                    <br>
                    {{-- <div class="image" dir="rtl">
                        <span><img height="80" style="text-align: right;" src="{{ public_path('webassets/dist/img/download.jpg')}}" /></span>
                    </div> --}}
                    <div class="rep_name">
                        <span>{{$Title}}</span>
                    </div><br><br>
                    {{-- <div dir="rtl" class="company">
                        <span>
                            <div class="name">
                                <span> :</span>
                            </div>
                            <div class="off_name">
                                <span>
                                {{$Company->company_official_name ?? 'مطابع الأميرية'}}
                                </span>
                            </div>
                        </span>
                    </div> --}}

                </htmlpageheader>

                <htmlpagefooter name="page-footer">
                    <div class="footer">
                        <span>{{$Title}}</span>
                    </div>
                </htmlpagefooter>
            </div>
        </span>
    </div>
    <section>
        <!--for demo wrap-->
        <h1></h1>
        <div class="tbl-header">
            <table dir="rtl" style="background-color: #021625;color: #fff;width:100%;">
                <thead style="color: #fff !important">
                  <tr>
                    <th>#</th>
            <th>رقم الفاتورة </th>
            <th>التاريخ </th>
            <th>نوع الفاتورة</th>
            <th>الحالة</th>

            <th>اسم العميل</th>
            <th>إجمالى صافى </th>
                  </tr>
                </thead>
                <tbody >
                    @foreach ($invoices as $index => $row)
                    <tr >
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->invoice_no }}</td>
                        <td>{{ date('Y-m-d', strtotime($row->date)) }} </td>
                        <td>{{ $row->type->name ?? '' }}</td>
                        <td>@if ($row->status == 1) تم الترحيل @else لم يتم الترحيل @endif</td>

                        <td> {{ $row->client->name ?? '' }}</td>
                        <td>{{ $row->total }}</td>

                    </tr>

                            </form>
                        </div>
                    </div>
                @endforeach

                </tbody>
            </tbody>
          </table>
        </div>
    </section>

    </body>
    </html>

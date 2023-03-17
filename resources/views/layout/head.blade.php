<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>الأميرية</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('webassets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('webassets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('webassets/dist/css/adminlte.css')}}">
<style>
    .page-item.active .page-link,
.pagination-datatables li.active .page-link,
.pagination li.active .page-link,
**.pagination li.active span,** --Added line
.page-item.active .pagination-datatables li a,
.pagination-datatables li .page-item.active a,
.pagination-datatables li.active a,
.page-item.active .pagination li a,
.pagination li .page-item.active a,
.pagination li.active a {
    z-index: 2;
   color: #fff;
   background-color: #20a8d8;
   border-color: #20a8d8;
}
.page-link, .pagination-datatables li a, .pagination li a, .pagination span {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #20a8d8;
    background-color: #fff;
    border: 1px solid #ddd; }
    </style>
</head>

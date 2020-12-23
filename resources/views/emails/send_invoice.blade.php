@extends('layouts.emails')
@section('content')
    <h3>Dear user {{$invoice->customer_name}}</h3>
    <h4>Greatings</h4>

    @endsection
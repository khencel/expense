@extends('layouts.master')

@section('label')
    Expenses
@endsection

@section('page')
    <li class="breadcrumb-item"><a href="#">Expense Management</a></li>
    <li class="breadcrumb-item active">Expenses</li>
@endsection

@section('content')
<expense-expenses></expense-expenses>
@endsection

@extends('layouts.master')

@section('label')
    Expense Categories
@endsection

@section('page')
    <li class="breadcrumb-item"><a href="#">Expense Management</a></li>
    <li class="breadcrumb-item active">Expense Categories</li>
@endsection

@section('content')
<expense-category></expense-category>
@endsection

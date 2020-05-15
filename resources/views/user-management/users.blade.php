@extends('layouts.master')

@section('label')
    Users
@endsection

@section('page')
    <li class="breadcrumb-item"><a href="#">User Management</a></li>
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<user-users></user-users>
@endsection

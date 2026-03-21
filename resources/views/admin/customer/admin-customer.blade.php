@extends('layouts.app')

@section('title', 'Admin Customer Management')
@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gradient">Customer Management</h1>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.customers.admin-customer') }}" class="row g-3">
                        <div class="col-md-9">
                            <label class="form-label">Search Customers</label>
                            <input type="text" class="form-control" name="search" placeholder="Enter name or email" value="{{ request('search') }}">
                        </div> 
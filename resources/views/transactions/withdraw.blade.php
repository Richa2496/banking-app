@extends('layout')
@extends('header')
@include('navigation')
<div class="page-body">
    <div class="container container-tight py-6">
        <div class="row row-cards">
            <div class="col-md-12 ">
                <div class="card card-md">
                    <div class="card">
                        <form action="{{route('transactions.withdraw')}}" method="POST" autocomplete="off" novalidate>
                            @csrf    
                            <div class="card-header">
                                <h2 class="card-title">Withdraw Money</h2>
                            </div>
                            <div class="card-body ">
                                <div class="mb-3">
                                    <label class="form-label">Amount</span>
                                    <input type="text" class="form-control" name="transaction_amount" placeholder="Enter your amount" autocomplete="off">
                                </div>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary w-100">Withdraw</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@extends('layout')
@extends('header')
@include('navigation')

<style>
    .content-center {
        display: flex;
        justify-content: center;
    }
</style>


<div class="page-body">
<div class="container">
        <div class="row row-cards content-center">
            <div class="col-md-12 " style="width: 600px;">
                <div class="card card-md">
                    <div class="card">
                        <form action="{{route('transactions.deposit')}}" method="POST" autocomplete="off" novalidate>
                            @csrf
                            <div class="card-header">
                                <h2 class="card-title">Deposit Money</h2>
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

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary w-100">Deposit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
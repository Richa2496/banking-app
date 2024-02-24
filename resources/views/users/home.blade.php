@extends('layout')
@extends('header')
@include('navigation')

<div class="page-body">
    <div class="container container-tight py-6">
        <div class="row row-cards">
            <div class="col-md-12 ">
            <form class="card card-md" action="./" method="get" autocomplete="off" novalidate>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Welcome {{($userData->name)}}</h2>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-3">
                            <span class="text-secondary" style="margin-right: 20px;">Your Id </span>
                            <span >{{($userData->email)}}</span>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-3">
                            <span class="text-secondary" style="margin-right: 20px;">Balance</span>
                            <span >{{$userData->current_balance}} INR</span>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
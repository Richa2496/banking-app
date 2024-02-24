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
            <form class="card card-md" action="./" method="get" autocomplete="off" novalidate>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Welcome {{($userData->name)}}</h2>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-3" style="display: flex; align-items: center">
                            <div class="text-secondary" style="width: 130px">YOUR ID </div>
                            <div >{{($userData->email)}}</div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-3" style="display: flex; align-items: center">
                            <div class="text-secondary" style="width: 130px">YOUR BALANCE</div>
                            <div >{{$userData->current_balance}} INR</div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
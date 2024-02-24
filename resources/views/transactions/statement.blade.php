@extends('layout')
@extends('header')
@include('navigation')
<style>
    .content-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-12 content-center">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Statement of account</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DATETIME</th>
                                        <th>AMOUNT</th>
                                        <th>TYPE</th>
                                        <th>DETAILS</th>
                                        <th>BALANCE</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: small;">
                                    @php
                                        $count = ($accountData->currentPage() - 1) * $accountData->perPage();
                                    @endphp
                                    @if($accountData)
                                        @foreach ($accountData as $transaction)
                                            @php
                                                $count++;
                                            @endphp
                                            <tr class="text-secondary">
                                                <td class="text-secondary">{{ $count }}</td>
                                                <td class="text-secondary">{{ $transaction->created_at }}</td>
                                                <td class="text-secondary">{{ $transaction->transaction_amount }}</td>
                                                <td class="text-secondary">{{ $transaction->transaction_type }}</td>

                                                @if($transaction->transaction_type == 'Debit' && $transaction->transfer_to_email === null)
                                                    <td class="text-secondary">Withdraw</td>

                                                @elseif($transaction->transaction_type == 'Debit' && $transaction->transfer_to_email !== null)
                                                    <td class="text-secondary">Transfer to<br>{{ $transaction->transfer_to_email }}</td>

                                                @elseif($transaction->transaction_type == 'Credit' && $transaction->transfer_from_email !== null)
                                                    <td class="text-secondary">Transfer from<br>{{ $transaction->transfer_from_email }}</td>

                                                @else
                                                    <td class="text-secondary">Deposit</td>
                                                @endif
                                                <td class="text-secondary">{{ $transaction->closing_balance }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>No records found!</tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination" style="padding: 15px 0px 0px 10px">
                            <ul class="pagination" >
                                @if ($accountData->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">                          
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                                    </span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $accountData->previousPageUrl() }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                                    </a></li>
                                @endif

                                @for ($page = 1; $page <= $accountData->lastPage(); $page++)
                                    @if ($page == $accountData->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $accountData->url($page) }}">{{ $page }}</a></li>
                                    @endif
                                @endfor

                                @if ($accountData->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $accountData->nextPageUrl() }}">                   
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                                    </a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">                          
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                                    </span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

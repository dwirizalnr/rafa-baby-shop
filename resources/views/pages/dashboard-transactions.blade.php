@extends('layouts.dashboard')

@section('title')
    Store Dashboard Transaction
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">
                    This is Recent Transactions
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12 mt-2">
                        @foreach ($buyTransactions as $transaction)
                            <a href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                                class="card card-list d-block">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                                class="w-50" />
                                        </div>
                                        <div class="col-md-4">
                                            {{ Str::limit($transaction->product->name, 40) }}
                                        </div>
                                        <div class="col-md-2 text-danger">
                                            {{ $transaction->transaction->transaction_status }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $transaction->transaction->created_at }}
                                        </div>
                                        <div class="col-md-1 d-none d-md-block">
                                            <img src="/images/dashboard-arrow-right.svg" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

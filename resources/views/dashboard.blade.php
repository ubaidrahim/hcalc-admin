@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-6">
        <!-- Congratulations card -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
            <div class="card-body text-nowrap">
                <h5 class="card-title mb-0 flex-wrap text-nowrap">Welcome {{auth()->user()->name}} 🎉</h5>
                <p class="mb-2">Most Used Calculator (Last 30 days)</p>
                <h4 class="text-primary mb-0">{{ $stats['mostviewedName'] }}</h4>
                <p class="mb-2">{{ $stats['mostviewedCount'] }} Calculations</p>
                <a href="{{route('calculators.index')}}" class="btn btn-sm btn-primary">View Calculators</a>
            </div>
            <img
                src="{{asset('assets/img/illustrations/trophy.png')}}"
                class="position-absolute bottom-0 end-0 me-5 mb-5"
                width="83"
                alt="view sales" />
            </div>
        </div>
        <!--/ Congratulations card -->

        <!-- Transactions -->
        <div class="col-lg-8">
            <div class="card h-100">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Statistics</h5>
                <div class="dropdown d-none">
                    <button
                    class="btn text-body-secondary p-0"
                    type="button"
                    id="transactionID"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                    </div>
                </div>
                </div>
                <p class="small mb-0"><span class="h6 mb-0">Total {{$stats['growth']}}% Growth</span> 😎 this month</p>
            </div>
            <div class="card-body pt-lg-10">
                <div class="row g-6">
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-success rounded shadow-xs">
                        <i class="icon-base ri ri-group-line icon-24px"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Visitors</p>
                        <h5 class="mb-0">{{$stats['visitors']}}</h5>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-warning rounded shadow-xs">
                        <i class="icon-base ri ri-macbook-line icon-24px"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Page Views</p>
                        <h5 class="mb-0">{{$stats['pageviews']}}</h5>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-primary rounded shadow-xs">
                        <i class="icon-base ri ri-calculator-line icon-24px"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Calculations</p>
                        <h5 class="mb-0">{{$stats['calculations']}}</h5>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-info rounded shadow-xs">
                        <i class="icon-base ri ri-global-line icon-24px"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Countries</p>
                        <h5 class="mb-0">{{$stats['countries']}}</h5>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!--/ Transactions -->

        <!-- Weekly Overview Chart -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                <h5 class="mb-1">Weekly Overview (Last 4 Weeks)</h5>
                <div class="dropdown d-none">
                    <button
                    class="btn text-body-secondary p-0"
                    type="button"
                    id="weeklyOverviewDropdown"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="weeklyOverviewDropdown">
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body pt-lg-2">
                <div id="weeklyOverviewChart"></div>
                <div class="mt-1 mt-md-3">
                <div class="d-flex align-items-center gap-4">
                    <h4 class="mb-0">{{$stats['growth']}}%</h4>
                    <p class="mb-0">Our growth performance is {{$stats['growth']}}% 😎 better compared to last month</p>
                </div>
                <div class="d-grid mt-3 mt-md-4">
                    <a href="{{ route('visitors.index') }}" class="btn btn-primary">Details</a>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!--/ Weekly Overview Chart -->

        <!-- Total Earnings -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Total Activity</h5>
                <div class="dropdown d-none">
                <button
                    class="btn text-body-secondary p-0"
                    type="button"
                    id="totalEarnings"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalEarnings">
                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                </div>
                </div>
            </div>
            <div class="card-body pt-lg-8">
                <div class="mb-5 mb-lg-12">
                <div class="d-flex align-items-center">
                    <h3 class="mb-0">{{ $stats['allactivity'] }}</h3>
                    <span class="{{$stats['activityFlag'] == 1 ? 'text-success' : 'text-danger'}} ms-2">
                    @switch($stats['activityFlag'])
                        @case(1)
                            <i class="icon-base ri ri-arrow-up-s-line icon-sm"></i>
                        @break
                        @case(0)
                        <i class="icon-base ri ri-arrow-down-s-line icon-sm"></i>
                        @break
                        @default
                            
                    @endswitch
                    <span>{{$stats['activityPct']}}%</span>
                    </span>
                </div>
                <p class="mb-0">Compared to {{$stats['lastMonthActivity']}} last month</p>
                </div>
                <ul class="p-0 m-0">
                @foreach ($stats['topcalcs'] as $item)
                    <li class="d-flex mb-6">
                        <div class="avatar flex-shrink-0 bg-lightest rounded me-3">
                            @if($item->calculator->image)
                            <img src="{{asset($item->calculator->image)}}" alt="{{ $item->calculator->title }}" />
                            @endif
                        </div>
                        <div class="d-flex w-100 flex-wrap flex-column gap-1">
                        <div class="me-2">
                            <h6 class="mb-0">{{ $item->calculator->title }}</h6>
                            {{-- <p class="mb-0">Vuejs, React & HTML</p> --}}
                        </div>
                        <div>
                            <h6 class="mb-2">{{$item->total_count}}</h6>
                            {{-- <div class="progress bg-label-primary" style="height: 4px">
                                <div
                                    class="progress-bar bg-primary"
                                    style="width: 75%"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                                </div>
                            </div> --}}
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
            </div>
        </div>
        <!--/ Total Earnings -->

        <!-- Sales by Countries -->
        <div class="col-xl-4 col-md-6">
            <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Sales by Countries</h5>
                <div class="dropdown">
                <button
                    class="btn text-body-secondary p-0"
                    type="button"
                    id="saleStatus"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="saleStatus">
                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-4">
                    <div class="avatar-initial bg-label-success rounded-circle">US</div>
                    </div>
                    <div>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <h6 class="mb-0">$8,656k</h6>
                        <i class="icon-base ri ri-arrow-up-s-line icon-24px text-success"></i>
                        <span class="text-success">25.8%</span>
                    </div>
                    <p class="mb-0">United states of america</p>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="mb-1">894k</h6>
                    <small class="text-body-secondary">Sales</small>
                </div>
                </div>
                <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-4">
                    <span class="avatar-initial bg-label-danger rounded-circle">UK</span>
                    </div>
                    <div>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <h6 class="mb-0">$2,415k</h6>
                        <i class="icon-base ri ri-arrow-down-s-line icon-24px text-danger"></i>
                        <span class="text-danger">6.2%</span>
                    </div>
                    <p class="mb-0">United Kingdom</p>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="mb-1">645k</h6>
                    <small class="text-body-secondary">Sales</small>
                </div>
                </div>
                <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-4">
                    <span class="avatar-initial bg-label-warning rounded-circle">IN</span>
                    </div>
                    <div>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <h6 class="mb-0">865k</h6>
                        <i class="icon-base ri ri-arrow-up-s-line icon-24px text-success"></i>
                        <span class="text-success"> 12.4%</span>
                    </div>
                    <p class="mb-0">India</p>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="mb-1">148k</h6>
                    <small class="text-body-secondary">Sales</small>
                </div>
                </div>
                <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-4">
                    <span class="avatar-initial bg-label-secondary rounded-circle">JA</span>
                    </div>
                    <div>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <h6 class="mb-0">$745k</h6>
                        <i class="icon-base ri ri-arrow-down-s-line icon-24px text-danger"></i>
                        <span class="text-danger">11.9%</span>
                    </div>
                    <p class="mb-0">Japan</p>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="mb-1">86k</h6>
                    <small class="text-body-secondary">Sales</small>
                </div>
                </div>
                <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="avatar me-4">
                    <span class="avatar-initial bg-label-danger rounded-circle">KO</span>
                    </div>
                    <div>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <h6 class="mb-0">$45k</h6>
                        <i class="icon-base ri ri-arrow-up-s-line icon-24px text-success"></i>
                        <span class="text-success">16.2%</span>
                    </div>
                    <p class="mb-0">Korea</p>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="mb-1">42k</h6>
                    <small class="text-body-secondary">Sales</small>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!--/ Sales by Countries -->
        @if(1 == 0)
        <!-- Four Cards -->
        <div class="col-xl-4 col-md-6">
            <div class="row gy-6">
            <!-- Total Profit line chart -->
            <div class="col-sm-6">
                <div class="card h-100">
                <div class="card-header pb-0">
                    <h4 class="mb-0">$86.4k</h4>
                </div>
                <div class="card-body">
                    <div id="totalProfitLineChart" class="mb-3"></div>
                    <h6 class="text-center mb-0">Total Profit</h6>
                </div>
                </div>
            </div>
            <!--/ Total Profit line chart -->
            <!-- Total Profit Weekly Project -->
            <div class="col-sm-6">
                <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="avatar">
                    <div class="avatar-initial bg-secondary rounded-circle shadow-xs">
                        <i class="icon-base ri ri-pie-chart-2-line icon-24px"></i>
                    </div>
                    </div>
                    <div class="dropdown">
                    <button
                        class="btn text-body-secondary p-0"
                        type="button"
                        id="totalProfitID"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="icon-base ri ri-more-2-line icon-24px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalProfitID">
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        <a class="dropdown-item" href="javascript:void(0);">Update</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-1">Total Profit</h6>
                    <div class="d-flex flex-wrap mb-1 align-items-center">
                    <h4 class="mb-0 me-2">$25.6k</h4>
                    <p class="text-success mb-0">+42%</p>
                    </div>
                    <small>Weekly Project</small>
                </div>
                </div>
            </div>
            <!--/ Total Profit Weekly Project -->
            <!-- New Yearly Project -->
            <div class="col-sm-6">
                <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="avatar">
                    <div class="avatar-initial bg-primary rounded-circle shadow-xs">
                        <i class="icon-base ri ri-file-word-2-line icon-24px"></i>
                    </div>
                    </div>
                    <div class="dropdown">
                    <button
                        class="btn text-body-secondary p-0"
                        type="button"
                        id="newProjectID"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="icon-base ri ri-more-2-line icon-24px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="newProjectID">
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        <a class="dropdown-item" href="javascript:void(0);">Update</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-1">New Project</h6>
                    <div class="d-flex flex-wrap mb-1 align-items-center">
                    <h4 class="mb-0 me-2">862</h4>
                    <p class="text-danger mb-0">-18%</p>
                    </div>
                    <small>Yearly Project</small>
                </div>
                </div>
            </div>
            <!--/ New Yearly Project -->
            <!-- Sessions chart -->
            <div class="col-sm-6">
                <div class="card h-100">
                <div class="card-header pb-0">
                    <h4 class="mb-0">2,856</h4>
                </div>
                <div class="card-body">
                    <div id="sessionsColumnChart" class="mb-3"></div>
                    <h6 class="text-center mb-0">Sessions</h6>
                </div>
                </div>
            </div>
            <!--/ Sessions chart -->
            </div>
        </div>
        <!--/ four cards -->

        <!-- Deposit / Withdraw -->
        <div class="col-xl-8">
            <div class="card-group">
            <div class="card mb-0">
                <div class="card-body card-separator">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <h5 class="m-0 me-2">Deposit</h5>
                    <a class="fw-medium" href="javascript:void(0);">View all</a>
                </div>
                <div class="deposit-content pt-2">
                    <ul class="p-0 m-0">
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/payments/gumroad.png"
                            class="img-fluid"
                            alt="gumroad"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Gumroad Account</h6>
                            <p class="mb-0">Sell UI Kit</p>
                        </div>
                        <h6 class="text-success mb-0">+$4,650</h6>
                        </div>
                    </li>
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/payments/mastercard-2.png"
                            class="img-fluid"
                            alt="mastercard"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Mastercard</h6>
                            <p class="mb-0">Wallet deposit</p>
                        </div>
                        <h6 class="text-success mb-0">+$92,705</h6>
                        </div>
                    </li>
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/payments/stripes.png"
                            class="img-fluid"
                            alt="stripes"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Stripe Account</h6>
                            <p class="mb-0">iOS Application</p>
                        </div>
                        <h6 class="text-success mb-0">+$957</h6>
                        </div>
                    </li>
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/payments/american-bank.png"
                            class="img-fluid"
                            alt="american"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">American Bank</h6>
                            <p class="mb-0">Bank Transfer</p>
                        </div>
                        <h6 class="text-success mb-0">+$6,837</h6>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/payments/citi.png"
                            class="img-fluid"
                            alt="citi"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Bank Account</h6>
                            <p class="mb-0">Wallet deposit</p>
                        </div>
                        <h6 class="text-success mb-0">+$446</h6>
                        </div>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <h5 class="m-0 me-2">Withdraw</h5>
                    <a class="fw-medium" href="javascript:void(0);">View all</a>
                </div>
                <div class="withdraw-content pt-2">
                    <ul class="p-0 m-0">
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/brands/google.png"
                            class="img-fluid"
                            alt="google"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Google Adsense</h6>
                            <p class="mb-0">Paypal deposit</p>
                        </div>
                        <h6 class="text-danger mb-0">-$145</h6>
                        </div>
                    </li>
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/brands/github.png"
                            class="img-fluid"
                            alt="github"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Github Enterprise</h6>
                            <p class="mb-0">Security &amp; compliance</p>
                        </div>
                        <h6 class="text-danger mb-0">-$1870</h6>
                        </div>
                    </li>
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/brands/slack.png"
                            class="img-fluid"
                            alt="slack"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Upgrade Slack Plan</h6>
                            <p class="mb-0">Debit card deposit</p>
                        </div>
                        <h6 class="text-danger mb-0">$450</h6>
                        </div>
                    </li>
                    <li class="d-flex mb-4 align-items-center pb-2">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/payments/digital-ocean.png"
                            class="img-fluid"
                            alt="digital"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Digital Ocean</h6>
                            <p class="mb-0">Cloud Hosting</p>
                        </div>
                        <h6 class="text-danger mb-0">-$540</h6>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-4">
                        <img
                            src="../assets/img/icons/brands/aws.png"
                            class="img-fluid"
                            alt="aws"
                            height="30"
                            width="30" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">AWS Account</h6>
                            <p class="mb-0">Choosing a Cloud Platform</p>
                        </div>
                        <h6 class="text-danger mb-0">-$21</h6>
                        </div>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Deposit / Withdraw -->
        @endif

        <!-- Data Tables -->
        <div class="col-12">
            <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Recent Visitors</h5>
            </div>
            <div class="card-body pt-lg-8">
            @if(isset($stats['recentVisitors']) && count($stats['recentVisitors']) > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                <thead>
                    <tr>
                    <th class="text-truncate">UUID / User Agent</th>
                    <th class="text-truncate">IP Address</th>
                    <th class="text-truncate">City / County</th>
                    <th class="text-truncate">Total Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats['recentVisitors'] as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-4">
                                <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                                <h6 class="mb-0 text-truncate">{{$item->visitor_uuid}}</h6>
                                <small class="text-truncate">
                                    {{strlen($item->user_agent) > 30 ? substr($item->user_agent,0,30) : $item->user_agent}}
                                    @if(strlen($item->user_agent) > 30)
                                        <button
                                            type="button"
                                            class="btn btn-xs rounded-pill btn-icon btn-outline-secondary border-none shadow waves-effect"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{$item->user_agent}}">
                                            <span class="icon-base ri ri-info-i icon-12px"></span>
                                        </button>
                                    @endif
                                </small>
                            </div>
                            </div>
                        </td>
                        <td class="text-truncate">{{ $item->ip }}</td>
                        <td class="text-truncate">
                            <div class="d-flex align-items-center flex-column">
                            {{-- <i class="icon-base ri ri-vip-crown-line icon-22px text-primary me-2"></i> --}}
                            <span>{{ $item->city ?? '' }}</span>
                            <span class="text-primary">{{ $item->country ?? '--NIL--' }}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-label-success rounded-pill">{{ count($item->activity) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @else
            <div class="py-4 px-3 text-center">
                <h4 class="text-primary mb-0">No New Visitors</h4>
                <p class="mb-2">No visitors found for this month</p>
            </div>
            @endif
            </div>
            </div>
        </div>
        <!--/ Data Tables -->
        </div>
    </div>
    <!-- / Content -->
@endsection
@push('scripts')
<script>
    let weeklyOverviewData = @js($stats['weeklyOverview']);
    const weeklyOverviewLabels = weeklyOverviewData.map(item => item.week);
    const weeklyOverviewValues = weeklyOverviewData.map(item => item.count);
    console.log(config.colors);
</script>
<script src="{{asset('assets/js/dashboards-analytics.js')}}?v=0.2"></script>
@endpush
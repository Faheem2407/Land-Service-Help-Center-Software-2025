@extends('backend.app')
@section('title', 'ড্যাশবোর্ড')

@section('page-content')

<style>
    .dashboard-card {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dashboard-card .card-body {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dashboard-card h1 {
        font-size: 32px;
        line-height: 1;
    }

    .dashboard-card i {
        opacity: 0.85;
    }
</style>

<section class="mt-0">
    <div class="container-fluid">
        <div class="row">

            <!-- মোট ব্যবহারকারী -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_users }}</h1>
                            <h5 class="text-muted">মোট ব্যবহারকারী</h5>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- আজকের গ্রহণকারী -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $today_receivers }}</h1>
                            <h5 class="text-muted">আজকের গ্রাহক</h5>
                        </div>
                        <div>
                            <i class="fas fa-user-check fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মোট গ্রহণকারী -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_receivers }}</h1>
                            <h5 class="text-muted">মোট গ্রাহক</h5>
                        </div>
                        <div>
                            <i class="fas fa-users-cog fa-3x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- আজকের প্রক্রিয়াকরণ চার্জ -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $today_processing_charge }}</h1>
                            <h5 class="text-muted">আজকের সার্ভিস চার্জ</h5>
                        </div>
                        <div>
                            <i class="fas fa-money-bill fa-3x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মোট প্রক্রিয়াকরণ চার্জ -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_processing_charge }}</h1>
                            <h5 class="text-muted">মোট সার্ভিস চার্জ</h5>
                        </div>
                        <div>
                            <i class="fas fa-coins fa-3x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- আজকের অনলাইন চার্জ -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $today_online_charge }}</h1>
                            <h5 class="text-muted">আজকের অনলাইন চার্জ</h5>
                        </div>
                        <div>
                            <i class="fas fa-globe fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মোট অনলাইন চার্জ -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_online_charge }}</h1>
                            <h5 class="text-muted">মোট অনলাইন চার্জ</h5>
                        </div>
                        <div>
                            <i class="fas fa-laptop-code fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- আজকের খরচ -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $today_costs }}</h1>
                            <h5 class="text-muted">আজকের খরচ</h5>
                        </div>
                        <div>
                            <i class="fas fa-wallet fa-3x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মোট খরচ -->
            <div class="col-md-3 mt-4 mb-5">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_costs }}</h1>
                            <h5 class="text-muted">মোট খরচ</h5>
                        </div>
                        <div>
                            <i class="fas fa-chart-line fa-3x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- আজকের মোট আয় -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $today_total_revenue }}</h1>
                            <h5 class="text-muted">আজকের মোট আয়</h5>
                        </div>
                        <div>
                            <i class="fas fa-cash-register fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মোট আয় -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_revenue }}</h1>
                            <h5 class="text-muted">মোট আয়</h5>
                        </div>
                        <div>
                            <i class="fas fa-wallet fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

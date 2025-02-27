@extends('layouts.customer_baru.master')

@section('title', 'Dashboard Customer')

@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Dashboard Customer</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Complaint Form -->
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Complaint Customer</div>
                    </div>
                    <form action="{{ route('customer.store.complaint') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Subject Field -->
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject"
                                    placeholder="Enter complaint subject" required>
                            </div>

                            <!-- Description Field -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4"
                                    placeholder="Enter complaint description" required></textarea>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Troubleshooting Tips</div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Matikan modem dengan menekan tombol power atau cabut kabel daya.</li>
                            <li>Tunggu selama 10-30 detik agar modem benar-benar mati.</li>
                            <li>Hidupkan kembali modem dengan menyambungkan kabel daya atau menekan tombol power.</li>
                            <li>Tunggu beberapa menit hingga modem selesai booting dan lampu indikator stabil.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

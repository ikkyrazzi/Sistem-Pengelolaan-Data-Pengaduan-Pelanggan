@extends('layouts.customer.master')

@section('title', 'Home Page')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Complaint Customer</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Complaint Customer</div>
                    </div>
                    <form action="{{ route('customer.store.complaint') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Form Group for Subject -->
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject"
                                    placeholder="Enter complaint subject" required>
                            </div>

                            <!-- Form Group for Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4"
                                    placeholder="Enter complaint description" required></textarea>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

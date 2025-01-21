@extends('layouts.admin.master')

@section('title', 'Schedule Complaint')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Schedule Complaint</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Schedule Complaint</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Technician and Schedule</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.complaint.schedule.update', $complaint->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="assigned_technician_id">Assign Technician</label>
                                <select name="assigned_technician_id" id="assigned_technician_id" class="form-control">
                                    <option value="" disabled selected>Select Technician</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $complaint->assigned_technician_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_technician_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="schedule">Schedule</label>
                                <input type="date" name="schedule" id="schedule" class="form-control"
                                    value="{{ $complaint->schedule }}">
                            </div>
                            <button type="submit" class="btn btn-success">Assign Technician</button>
                            <a href="{{ route('admin.complaint.schedule-index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

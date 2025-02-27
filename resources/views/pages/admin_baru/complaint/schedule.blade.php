@extends('layouts.admin_baru.master')

@section('title', 'Schedule Technician')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Schedule Technician</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Assign Technician Schedule</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Set Technician Schedule</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.complaint.schedule.update', $complaint->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
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
                        <div class="mb-3">
                            <label for="schedule" class="form-label">Schedule Date & Time</label>
                            <input type="datetime-local" name="schedule" id="schedule" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Schedule</button>
                        <a href="{{ route('admin.complaint.schedule-index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

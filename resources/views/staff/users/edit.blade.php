@extends('layouts.app')

@section('title', 'Edit Account')

@section('content')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-4">
            <h5 class="fw-bold text-dark mb-1">Edit Account Forms</h5>
            <small class="text-muted mb-4 d-block">Please <span class="text-danger">.fill-all</span> input form with right value.</small>

            @if(session('success'))
                <div class="alert alert-success text-success bg-light border-success opacity-75 mb-4" style="background-color: #d1e7dd !important;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('staff.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-semibold">New Password <span class="text-warning fw-normal">optional</span></label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('lendings.index') }}" class="btn btn-secondary text-white px-4 me-2">Cancel</a>
                    <button type="submit" class="btn text-white px-4" style="background-color: #6f42c1;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
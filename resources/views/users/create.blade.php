@extends('layout')
@extends('header')

<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark">
                <h2>ABC BANK</h2>
            </a>
        </div>
        <form class="card card-md" method="POST" action="{{ route('users.store') }}" autocomplete="off" novalidate>
            @csrf
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Create new account</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-flat">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check">
                        <input type="checkbox" id="agree_terms" name="agree_terms" class="form-check-input" required>
                        <span class="form-check-label">Agree to the <a href="#" tabindex="-1">terms and policy</a>.</span>
                    </label>
                </div>
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Create new account</button>
                </div>
            </div>
        </form>
        <div class="text-center text-secondary mt-3">
            Already have an account? <a href="{{ url('/login') }}" tabindex="-1">Sign in</a>
        </div>
    </div>
</div>

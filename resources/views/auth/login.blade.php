@extends('layout')
@extends('header')
<!-- <style>
    .content-center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style> -->

<!-- <div class="container content-center">
    <div class="row row-cards">
        <div class="col-md-12 page page-center">
        <h1 class="content-center" style="padding: 80px 0 20px 0;">ABC BANK</h1>
            <div style="width: 400px;">
                <form class="card" method="POST">
                    <div class="card-header">
                        <h3 class="card-title">Login to your account</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Email address</label>
                            <div>
                                <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Password</label>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <label class="form-check">
                                    <input class="form-check-input" name="remember_token" type="checkbox" checked="">
                                    <span class="form-check-label">Remember me</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </form> 
                <div class="content-center">Don't have an account yet? <a href="#">Sign up</a></div>
            </div>
        </div>
    </div>
    
</div> -->

<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <h2>ABC BANK</h2>
          </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login to your account</h2>
                <form action="{{route('login')}}" method="POST" autocomplete="off" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="your@email.com" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control"  name="password" placeholder="Your password"  autocomplete="off" required>
                        </div>
                    </div>
                    <div class="mb-3">
                    <label class="form-check">
                        <input type="checkbox" name="remember_token" class="form-check-input"/>
                        <span class="form-check-label">Remember me</span>
                    </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center text-secondary mt-3">
            Don't have account yet? <a href="{{url('/registration') }}" tabindex="-1">Sign up</a>
        </div>
    </div>
</div>
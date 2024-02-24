<style>
    .content-center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<div class="page-body">
    <div class="container-xl content-center">
        <div class="box">
            <div class="mb-3">
                <header class="navbar navbar-expand-md d-print-none" >
                    <div class="container-xl">
                        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                            <a href="{{url('/home') }}">ABC BANK</a>
                        </h1>
                    </div>
                </header>
                <header class="navbar-expand-md">
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <div class="navbar">
                            <div class="container-xl content-center">
                                <div class="row flex-fill align-items-center">
                                    <div class="col">
                                        <ul class="navbar-nav">
                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{url('/home') }}" >
                                                <span class="nav-link-title">
                                                    <i class="fa fa-home" aria-hidden="true"></i> Home
                                                </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{url('/deposit') }}" >
                                                    <span class="nav-link-title">
                                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i> Deposit
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{url('/withdraw') }}">
                                                    <span class="nav-link-title">
                                                        <i class="fa fa-cloud-download" aria-hidden="true"></i> Withdraw
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{url('/transfer') }}">
                                                    <span class="nav-link-title">
                                                        <i class="fa fa-exchange" aria-hidden="true"></i> Transfer
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{url('/statement') }}">
                                                    <span class="nav-link-title">
                                                        <i class="fa fa-file" aria-hidden="true"></i> Statement
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " href="{{url('/logout') }}">
                                                    <span class="nav-link-title">
                                                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
        </div>
    </div>
</div>
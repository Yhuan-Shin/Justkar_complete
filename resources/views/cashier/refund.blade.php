
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@livewireStyles
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt="" style="width: 60px; height: 60px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link text-white text-center" href="/cashier/pos">
                    <i class="bi bi-house"></i>
                    <span class="mx-1">Dashboard</span>
                </a>
              </li>
                <li class="nav-item">
                    <a class="nav-link text-white text-center" href="/cashier/refund">
                        <i class="bi bi-arrow-counterclockwise"></i>                
                        <span class="mx-1">Refund</span>
                    </a>
                  </li>
              <li class="nav-item">
                <a class="nav-link text-white text-center" href="#"> 
                    <i class="bi bi-person-circle"></i>
                    <span class="text-white">
                        @if (Auth::check())
                            <span class="mx-1 ">
                            @if (Auth::guard('cashier')->check())
                                {{ Auth::guard('cashier')->user()->username }}
                            @endif</span>
                        @else
                            <span class="mx-1">Guest</span>
                        @endif
    
                    </span>
                </a>
              </li>
             
              <li class="nav-item d-flex justify-content-center">
                <button type="button" class="btn btn-danger col-md" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Logout
                </button>
                {{-- // Logout Confirmation Modal --}}
                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="logoutModalLabel">Logout</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-dark">
                                Are you sure you want to logout?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('user.logout') }}">
                                    <button type="button" class="btn btn-danger">Logout</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>     
      <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="container">
                    <div class="row ">
                        <div class="col-md-8 ">
                            <div class="container">
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-3">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger  alert-dismissible fade show mt-3" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                              
                                {{-- @if (session('success')) --}}
                             
                            </div>
                        </div>

                    </div>
                 </div>
            </div>
        </div>
        {{-- display product --}}
        <div class="row mt-3" style="width: 100%">
            @livewire('available-refund')
        </div>
      </div>

    <!-- End of sidebar -->
    @livewireScripts
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris SMK Wikrama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .hero-section { text-align: center; margin-top: 50px; }
        .hero-section h1 { font-weight: bold; }
        .btn-login-nav { background-color: #0d6efd; color: white; border-radius: 5px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                SMK WIKRAMA
            </a>
            <div class="d-flex">
                <button class="btn btn-login-nav px-4" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            </div>
        </div>
    </nav>

    <div class="container hero-section">
        <h1>Inventory Management of<br>SMK Wikrama</h1>
        <p class="text-muted mt-3">Management of incoming and outgoing items at SMK Wikrama Bogor.</p>
        <div class="mt-5">
            <img src="https://via.placeholder.com/600x300?text=Ilustrasi+Orang+Angkat+Barang" alt="Ilustrasi" class="img-fluid">
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <h2 class="text-center mb-4">Login</h2>
                    
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-warning text-white w-50" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success w-50">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('error') || $errors->any())
                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                myModal.show();
            @endif
        });
    </script>
</body>
</html>
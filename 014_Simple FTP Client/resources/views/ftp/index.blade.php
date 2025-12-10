@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center p-5">
                <div class="ftp-icon">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                </div>
                <h2 class="card-title mb-4">FTP Client</h2>
                <p class="text-muted mb-4">Connect to your FTP server to manage files</p>
                
                <form action="{{ route('ftp.connect') }}" method="POST">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="host" class="form-label">FTP Host</label>
                        <input type="text" class="form-control" id="host" name="host" 
                               placeholder="ftp.example.com" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="port" class="form-label">Port</label>
                            <input type="number" class="form-control" id="port" name="port" value="21">
                        </div>
                    </div>
                    
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="ssl" name="ssl">
                            <label class="form-check-label" for="ssl">Use SSL (FTPS)</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-plug me-2"></i> Connect to FTP
                    </button>
                </form>
                
                <div class="mt-4 text-muted">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Your credentials are not stored and are only used for the current session
                    </small>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-lightbulb me-2"></i>Quick Connection Tips
                </h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Standard FTP uses port 21</li>
                    <li class="mb-2"><i class="bi bi-check text-success me-2"></i>FTPS (SSL) uses port 990</li>
                    <li class="mb-2"><i class="bi bi-check text-success me-2"></i>SFTP uses port 22 (different protocol)</li>
                    <li><i class="bi bi-check text-success me-2"></i>Timeout defaults to 30 seconds</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
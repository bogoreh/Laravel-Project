@extends('layout')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-plug me-2"></i>
                    Connect to FTP Server
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ftp.connect') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label for="host" class="form-label">FTP Server Host</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-server"></i>
                                </span>
                                <input type="text" class="form-control" id="host" name="host" 
                                       placeholder="ftp.example.com" required
                                       value="{{ old('host', session('last_host', '')) }}">
                            </div>
                            <small class="form-text text-muted">
                                Enter the hostname or IP address of your FTP server
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label for="port" class="form-label">Port</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-ethernet"></i>
                                </span>
                                <input type="number" class="form-control" id="port" name="port" 
                                       value="{{ old('port', 21) }}" min="1" max="65535">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" class="form-control" id="username" name="username" 
                                       required value="{{ old('username') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-key-fill"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="ssl" name="ssl" 
                                   {{ old('ssl') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ssl">
                                <i class="bi bi-shield-lock me-1"></i>
                                Use SSL/TLS (FTPS)
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Enable for secure FTP connections. This changes the default port to 990.
                        </small>
                    </div>
                    
                    <div class="mb-4">
                        <label for="timeout" class="form-label">Connection Timeout (seconds)</label>
                        <input type="range" class="form-range" id="timeout" name="timeout" 
                               min="10" max="120" step="5" value="{{ old('timeout', 30) }}">
                        <div class="d-flex justify-content-between">
                            <small>10s</small>
                            <span id="timeoutValue" class="fw-bold">30s</span>
                            <small>120s</small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('ftp.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plug me-1"></i> Connect to Server
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Quick Help Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-question-circle me-2"></i>
                    Connection Help
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-check-circle text-success me-1"></i> Common Ports</h6>
                        <ul class="list-unstyled">
                            <li><strong>FTP:</strong> Port 21 (standard)</li>
                            <li><strong>FTPS (SSL):</strong> Port 990</li>
                            <li><strong>SFTP:</strong> Port 22 (SSH-based)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-lightning text-warning me-1"></i> Tips</h6>
                        <ul class="list-unstyled">
                            <li>• Use passive mode if behind firewall</li>
                            <li>• Increase timeout for slow connections</li>
                            <li>• Credentials are session-only</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
    
    // Update timeout value display
    const timeoutSlider = document.getElementById('timeout');
    const timeoutValue = document.getElementById('timeoutValue');
    
    timeoutSlider.addEventListener('input', function() {
        timeoutValue.textContent = this.value + 's';
    });
    
    // Auto-update port based on SSL selection
    document.getElementById('ssl').addEventListener('change', function() {
        const portInput = document.getElementById('port');
        if (this.checked && portInput.value === '21') {
            portInput.value = '990';
        } else if (!this.checked && portInput.value === '990') {
            portInput.value = '21';
        }
    });
</script>
@endsection
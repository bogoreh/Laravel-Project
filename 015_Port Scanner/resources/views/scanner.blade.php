@extends('layouts.app')

@section('title', 'Port Scanner')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="glass-card p-4 p-md-5">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-white mb-3">
                    <i class="bi bi-shield-check"></i> Port Scanner
                </h1>
                <p class="lead text-light">
                    Scan ports on any host to check for open services and potential vulnerabilities
                </p>
            </div>
            
            <!-- Scan Form -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-body p-4">
                    <form id="scanForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="host" class="form-label fw-bold">
                                    <i class="bi bi-globe"></i> Target Host
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-server"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="host" 
                                           name="host"
                                           placeholder="example.com, 192.168.1.1, or localhost"
                                           value="localhost"
                                           required>
                                </div>
                                <div class="form-text">
                                    Enter domain name or IP address
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-gear"></i> Scan Type
                                </label>
                                <div class="d-flex gap-2 mb-3" id="scanTypeSelector">
                                    <div class="scan-type-tab active" data-type="common">
                                        <i class="bi bi-star-fill"></i> Common Ports
                                    </div>
                                    <div class="scan-type-tab" data-type="custom">
                                        <i class="bi bi-pencil"></i> Custom
                                    </div>
                                    <div class="scan-type-tab" data-type="range">
                                        <i class="bi bi-arrows-expand"></i> Range
                                    </div>
                                </div>
                                
                                <!-- Common Ports (Default) -->
                                <div id="commonPortsInfo" class="alert alert-info">
                                    <small>Scanning 23 most common ports (HTTP, SSH, FTP, MySQL, etc.)</small>
                                </div>
                                
                                <!-- Custom Ports Input -->
                                <div id="customPortsInput" style="display: none;">
                                    <input type="text" 
                                           class="form-control" 
                                           id="ports" 
                                           name="ports"
                                           placeholder="80,443,8080,3306">
                                    <div class="form-text">Enter ports separated by commas</div>
                                </div>
                                
                                <!-- Port Range Input -->
                                <div id="portRangeInput" style="display: none;">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="portRangeStart"
                                                   name="port_range_start"
                                                   placeholder="From"
                                                   min="1" 
                                                   max="65535">
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <span class="fw-bold">-</span>
                                        </div>
                                        <div class="col">
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="portRangeEnd"
                                                   name="port_range_end"
                                                   placeholder="To"
                                                   min="1" 
                                                   max="65535">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="showDetails">
                                    <label class="form-check-label" for="showDetails">
                                        Show detailed information
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" 
                                        class="btn btn-primary btn-lg scan-btn px-5"
                                        id="scanButton">
                                    <i class="bi bi-search"></i> Start Scan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="text-center my-5" style="display: none;">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Scanning...</span>
                </div>
                <div class="mt-3">
                    <h5 class="text-white">Scanning ports...</h5>
                    <p class="text-light">This may take a few moments</p>
                    <div class="progress" style="width: 300px; margin: 0 auto;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Results Section -->
            <div id="resultsSection" style="display: none;">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check"></i> Scan Results
                            <span id="scanSummary" class="badge bg-primary ms-2"></span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <!-- Statistics -->
                        <div class="row g-0" id="statistics">
                            <div class="col-md-4 p-3 border-end">
                                <div class="stat-card total text-center">
                                    <h6 class="text-muted mb-2">Total Ports Scanned</h6>
                                    <h2 id="totalPorts" class="fw-bold text-primary mb-0">0</h2>
                                </div>
                            </div>
                            <div class="col-md-4 p-3 border-end">
                                <div class="stat-card open text-center">
                                    <h6 class="text-muted mb-2">Open Ports</h6>
                                    <h2 id="openPorts" class="fw-bold text-success mb-0">0</h2>
                                </div>
                            </div>
                            <div class="col-md-4 p-3">
                                <div class="stat-card text-center">
                                    <h6 class="text-muted mb-2">Target Host</h6>
                                    <h4 id="targetHost" class="fw-bold text-dark mb-0">-</h4>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Results Table -->
                        <div class="p-3">
                            <div class="table-responsive">
                                <table class="table table-hover" id="resultsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Port</th>
                                            <th>Status</th>
                                            <th>Service</th>
                                            <th>Response Time</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody id="resultsBody">
                                        <!-- Results will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Export Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-outline-primary" id="exportBtn">
                        <i class="bi bi-download"></i> Export Results
                    </button>
                </div>
            </div>
            
            <!-- Error Alert -->
            <div class="alert alert-danger alert-dismissible fade mt-4" id="errorAlert" role="alert">
                <div id="errorMessage"></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-4">
            <p class="text-light">
                <small>
                    <i class="bi bi-info-circle"></i> 
                    This tool is for authorized testing only. Always get permission before scanning.
                </small>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentScanType = 'common';
    
    // Scan type selector
    $('#scanTypeSelector .scan-type-tab').click(function() {
        $('#scanTypeSelector .scan-type-tab').removeClass('active');
        $(this).addClass('active');
        currentScanType = $(this).data('type');
        
        // Show/hide appropriate input
        $('#commonPortsInfo').hide();
        $('#customPortsInput').hide();
        $('#portRangeInput').hide();
        
        switch(currentScanType) {
            case 'common':
                $('#commonPortsInfo').show();
                break;
            case 'custom':
                $('#customPortsInput').show();
                break;
            case 'range':
                $('#portRangeInput').show();
                break;
        }
    });
    
    // Form submission
    $('#scanForm').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            host: $('#host').val(),
            scan_type: currentScanType,
            _token: $('input[name="_token"]').val()
        };
        
        if (currentScanType === 'custom') {
            formData.ports = $('#ports').val();
        } else if (currentScanType === 'range') {
            const start = $('#portRangeStart').val();
            const end = $('#portRangeEnd').val();
            formData.port_range = `${start}-${end}`;
        }
        
        // Show loading spinner
        $('#loadingSpinner').show();
        $('#scanButton').prop('disabled', true);
        $('#resultsSection').hide();
        
        $.ajax({
            url: '{{ route("port.scan") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    displayResults(response);
                } else {
                    showError(response.errors || response.message);
                }
            },
            error: function(xhr) {
                showError(xhr.responseJSON?.message || 'An error occurred');
            },
            complete: function() {
                $('#loadingSpinner').hide();
                $('#scanButton').prop('disabled', false);
            }
        });
    });
    
    // Display results
    function displayResults(data) {
        $('#targetHost').text(data.host);
        $('#totalPorts').text(data.total_ports);
        $('#openPorts').text(data.open_ports);
        $('#scanSummary').text(`${data.open_ports} open / ${data.total_ports} total`);
        
        const resultsBody = $('#resultsBody');
        resultsBody.empty();
        
        data.results.forEach(result => {
            const statusClass = result.status === 'Open' ? 'open' : 'closed';
            const rowClass = result.status === 'Open' ? 'table-success' : '';
            
            const row = `
                <tr class="${rowClass}">
                    <td>
                        <span class="badge port-badge bg-dark">${result.port}</span>
                    </td>
                    <td>
                        <span class="badge status-badge ${statusClass}">
                            <i class="bi bi-${result.status === 'Open' ? 'check-circle' : 'x-circle'}"></i>
                            ${result.status}
                        </span>
                    </td>
                    <td>
                        <span class="fw-bold">${result.service}</span>
                    </td>
                    <td>
                        <span class="text-muted">${result.response_time} ms</span>
                    </td>
                    <td>
                        <small class="text-muted">${result.description}</small>
                    </td>
                </tr>
            `;
            
            resultsBody.append(row);
        });
        
        $('#resultsSection').show();
        $('html, body').animate({
            scrollTop: $('#resultsSection').offset().top - 100
        }, 500);
    }
    
    // Show error
    function showError(message) {
        if (typeof message === 'object') {
            message = Object.values(message).flat().join('<br>');
        }
        
        $('#errorMessage').html(message);
        $('#errorAlert').addClass('show');
        
        setTimeout(() => {
            $('#errorAlert').removeClass('show');
        }, 5000);
    }
    
    // Export results
    $('#exportBtn').click(function() {
        const host = $('#targetHost').text();
        const date = new Date().toLocaleString();
        let csv = `Port Scan Results\n`;
        csv += `Host: ${host}\n`;
        csv += `Scan Date: ${date}\n`;
        csv += `Total Ports: ${$('#totalPorts').text()}\n`;
        csv += `Open Ports: ${$('#openPorts').text()}\n\n`;
        csv += `Port,Status,Service,Response Time (ms),Description\n`;
        
        $('#resultsBody tr').each(function() {
            const cols = $(this).find('td');
            if (cols.length > 0) {
                const port = $(cols[0]).text().trim();
                const status = $(cols[1]).text().trim();
                const service = $(cols[2]).text().trim();
                const responseTime = $(cols[3]).text().trim();
                const description = $(cols[4]).text().trim();
                csv += `${port},${status},${service},${responseTime},"${description}"\n`;
            }
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `port-scan-${host}-${Date.now()}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    });
});
</script>
@endpush
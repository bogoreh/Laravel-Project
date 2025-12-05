<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="mb-3">DonationHub</h4>
                <p>Making a difference one donation at a time. Join us in supporting meaningful causes around the world.</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="{{ route('campaigns') }}" class="text-white text-decoration-none">Campaigns</a></li>
                    <li><a href="{{ route('about') }}" class="text-white text-decoration-none">About Us</a></li>
                    <li><a href="{{ route('donations.create') }}" class="text-white text-decoration-none">Donate</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Contact Info</h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> 123 Charity St, Helping City</p>
                <p class="mb-1"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                <p class="mb-0"><i class="fas fa-envelope me-2"></i> info@donationhub.com</p>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Newsletter</h5>
                <p>Subscribe to get updates on new campaigns</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Your email">
                    <button class="btn btn-primary" type="button">Subscribe</button>
                </div>
            </div>
        </div>
        <hr class="mt-0 mb-4" style="border-color: rgba(255,255,255,0.1)">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} DonationHub. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                <a href="#" class="text-white text-decoration-none">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
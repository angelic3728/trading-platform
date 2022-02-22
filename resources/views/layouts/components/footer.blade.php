<footer>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-sm-auto">
                © {{ date('Y') }} {{ config('app.name') }}
            </div>
            <div class="col-sm-auto pt-2 pt-sm-0">
                <nav>
                    <a href="mailto://{{ config('app.email') }}">Contact Us</a>
                    <a href="{{ route('legal.terms-and-conditions') }}">Terms & Conditions</a>
                    <a href="{{ route('legal.privacy-policy') }}">Privacy Policy</a>
                </nav>
            </div>
        </div>
    </div>
</footer>

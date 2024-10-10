<div class="footer_container">
    <!-- Info Section -->
    <section class="info_section py-4">
        <div class="container">
            <div class="contact_box mb-3">
                <a href="#" class="text-decoration-none">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </a>
            </div>
            <div class="info_links mb-3">
                <ul class="list-inline">
                    <li class="list-inline-item active">
                        <a href="{{ url('/') }}" class="text-decoration-none">Home</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('recipes') }}" class="text-decoration-none">Resep</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('/blog') }}" class="text-decoration-none">Blog</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('/testimonial') }}" class="text-decoration-none">Testimonial</a>
                    </li>
                </ul>
            </div>
            <div class="container text-center ">
                <p>© <span id="displayYear"></span> Flavora - All rights reserved.</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer_section bg-blue">
        <div class="container">
            <p>
                &copy; <span id="displayYear"></span> All Rights Reserved By
                <a href="https://html.design/" class="text-decoration-none">Free Html Templates</a><br>
                Distributed By: <a href="https://themewagon.com/" class="text-decoration-none">ThemeWagon</a>
            </p>
        </div>
    </footer>
</div>
<script>
    document.getElementById('displayYear').innerText = new Date().getFullYear();
</script>

  <div class="footer_container">
    <!-- info section -->
    <section class="info_section ">
      <div class="container">
        <div class="contact_box">
          <a href="">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-phone" aria-hidden="true"></i>
          </a>
          <a href="">
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
        <div class="social_box">
          <a href="">
            <i class="fa fa-facebook" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-twitter" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-linkedin" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </section>
    <!-- end info_section -->


    <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a><br>
          Distributed By: <a href="https://themewagon.com/">SafeZone</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->
    <script>
    document.getElementById('displayYear').innerText = new Date().getFullYear();
</script>
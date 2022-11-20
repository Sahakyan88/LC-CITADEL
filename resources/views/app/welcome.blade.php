@extends('app.layouts.app')
@section('content')
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
    <div class="container text-center text-md-left" data-aos="fade-up">
      <h1>Welcome to Maxim</h1>
      <h2>We are team of talented designers making websites with Bootstrap</h2>
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </section><!-- End Hero -->
  
  <!-- ======= F.A.Q Section ======= -->
  <section id="faq" class="faq section-bg">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>F.A.Q</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      <div class="faq-list">
        <ul>
          <li data-aos="fade-up">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
              <p>
                Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="100">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
              <p>
                Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="200">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
              <p>
                Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="300">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
              <p>
                Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
              <p>
                Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
              </p>
            </div>
          </li>

        </ul>
      </div>

    </div>
  </section><!-- End F.A.Q Section -->
  
    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">
  
          <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-right">
              <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                  <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">
                    <h4>Modi sit est</h4>
                    <p>Quis excepturi porro totam sint earum quo nulla perspiciatis eius.</p>
                  </a>
                </li>
                <li class="nav-item mt-2">
                  <a class="nav-link" data-bs-toggle="tab" href="#tab-2">
                    <h4>Unde praesentium sed</h4>
                    <p>Voluptas vel esse repudiandae quo excepturi.</p>
                  </a>
                </li>
                <li class="nav-item mt-2">
                  <a class="nav-link" data-bs-toggle="tab" href="#tab-3">
                    <h4>Pariatur explicabo vel</h4>
                    <p>Velit veniam ipsa sit nihil blanditiis mollitia natus.</p>
                  </a>
                </li>
                <li class="nav-item mt-2">
                  <a class="nav-link" data-bs-toggle="tab" href="#tab-4">
                    <h4>Nostrum qui quasi</h4>
                    <p>Ratione hic sapiente nostrum doloremque illum nulla praesentium id</p>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-lg-7 ml-auto" data-aos="fade-left">
              <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                  <figure>
                    <img src="assets/img/features-1.png" alt="" class="img-fluid">
                  </figure>
                </div>
                <div class="tab-pane" id="tab-2">
                  <figure>
                    <img src="assets/img/features-2.png" alt="" class="img-fluid">
                  </figure>
                </div>
                <div class="tab-pane" id="tab-3">
                  <figure>
                    <img src="assets/img/features-3.png" alt="" class="img-fluid">
                  </figure>
                </div>
                <div class="tab-pane" id="tab-4">
                  <figure>
                    <img src="assets/img/features-4.png" alt="" class="img-fluid">
                  </figure>
                </div>
              </div>
            </div>
          </div>
  
        </div>
      </section><!-- End Features Section -->
    </main><!-- End #main -->
  
@endsection

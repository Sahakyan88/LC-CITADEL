@extends('app.layouts.app')
@section('content')

  <section id="about" class="about">
    <div class="container">

      <div class="row">
        <div class="col-xl-6 col-lg-7" data-aos="fade-right">
          <img src="assets/img/about-img.jpg" class="img-fluid" alt="">
        </div>
        <div class="col-xl-6 col-lg-5 pt-5 pt-lg-0">
          <h3 data-aos="fade-up">Voluptatem dignissimos provident</h3>
          <p data-aos="fade-up">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
          <div class="icon-box" data-aos="fade-up">
            <i class="bx bx-receipt"></i>
            <h4>Corporis voluptates sit</h4>
            <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
          </div>

          <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
            <i class="bx bx-cube-alt"></i>
            <h4>Ullamco laboris nisi</h4>
            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
          </div>

          <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
            <i class="bx bx-cube-alt"></i>
            <h4>Ullamco laboris nisi</h4>
            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
          </div>

        </div>
      </div>

    </div>
  </section>
  @if (count($teams)>0)
   <section id="team" class="team">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>
      <div class="row">
        @foreach ( $teams as $team )
        <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
          <div class="member">
            <img src="{{ asset('images/services/' . $team->image_file_name)  }}" class="img-fluid" alt="">
            <div class="member-info">
              <div class="member-info-content">
                <h4>{{ $team->title }}</h4>
                <span>{{ $team->description }}</span>
              </div>
              <div class="social">
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif
@endsection
@extends('app.layouts.app')
@section('content')
    @if (count($about) > 0)
        <section id="about" class="about section-bg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7" data-aos="fade-right">
                        <img src="{{ asset('images/document/' . $about[0]->image_file_name) }}" class="img-fluid"
                            alt="">
                    </div>
                    <div class="col-xl-6 col-lg-5 pt-5 pt-lg-0">
                        <h3 data-aos="fade-up">{{ $about[0]->title }}</h3>
                        <?php echo $about[0]->body; ?>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if (count($teams) > 0)
        <section id="team" class="team">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Team</h2>
                    @if (count($dictionary) > 0)
                        <p>{{ $dictionary[0]->team }}</p>
                    @endif
                </div>
                <div class="row">
                    @foreach ($teams as $team)
                        <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
                            <div class="member">
                                <img src="{{ asset('images/services/' . $team->image_file_name) }}" class="img-fluid"
                                    alt="">
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

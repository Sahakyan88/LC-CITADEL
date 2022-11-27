@extends('app.layouts.app')
@section('content')
    <section id="services" class="services section-bg">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Services</h2>
                @if (count($dictionary) > 0)
                    <p>{{ $dictionary[0]->service }}</p>
                @endif
            </div>
            <div class="row">
                @foreach ( $services as $service )
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-4" data-aos="fade-up">
                    <div class="icon-box icon-box-pink">
                        <div> <img style="border-radius: 50px;" src="{{ asset('images/backendSmall/' . $service->image_file_name) }}"></div>
                        <h4 class="title"><a href="">{{ $service->title }}</a></h4>
                        <h4 class="title"><a href="">{{ $service->price }}$</a></h4>
                        <p class="description"><?php echo $service->body ?> </p>
                        <div class="text-center"><button type="submit" class="btn btn-success">Pay Now</button></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@extends('app.layouts.app')
@section('content')
    @if (count($services) > 0)
        <section id="services" class="services section-bg">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Services</h2>
                    @if (count($dictionary) > 0)
                        <p>{{ $dictionary[0]->service }}</p>
                    @endif
                </div>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-xl-3 col-lg-4 col-md-6 mt-4" data-aos="fade-up">
                            <div class="icon-box icon-box-pink">
                                <div> <img style="border-radius: 50px;"
                                        src="{{ asset('images/backendSmall/' . $service->image_file_name) }}"></div>
                                <h4 class="title"><a href="">{{ $service->title }}</a></h4>
                                <h4 class="title"><a href="">{{ $service->price }}$</a></h4>
                                <div class="description"><?php echo $service->body; ?> </div>
                                <div class="text-center"><button type="submit" class="btn btn-success">Pay Now</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

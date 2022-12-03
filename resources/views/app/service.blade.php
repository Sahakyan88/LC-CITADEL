@extends('app.layouts.app')
@section('content')
    @if (count($services) > 0)
        <section id="services" class="services section-bg">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>{{ config()->get('lang.' . App::getLocale() . '.plans') }}</h2>
                    @if (count($dictionary) > 0)
                        <p>{{ $dictionary[0]->service }}</p>
                    @endif
                </div>
                <div class="row">
                    @foreach ($services as $service)<div class="col-xl-4  col-md-4 mt-5" data-aos="fade-up">
                        <div class="icon-box icon-box-pink">
                                <div> <img style="border-radius: 50px;"
                                           src="{{ asset('images/backendSmall/' . $service->image_file_name) }}"></div>
                                <h4 class="title"><a href="">{{ $service->title }}</a></h4>
                                <h4 class="title"><a href="">{{ $service->price }} {{ config()->get('lang.' . App::getLocale() . '.amd') }}</a></h4>
                                <div class="description"><?php echo $service->body; ?> </div>
                                <div class="text-center">
                                    <form action="{{url('/createServiceOrder/' . $service->service_id)}}" method="POST">
                                        @csrf
                                        <button
                                            class="btn btn-success">{{ config()->get('lang.' . App::getLocale() . '.get_insurance') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

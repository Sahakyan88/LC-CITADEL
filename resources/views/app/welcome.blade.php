@extends('app.layouts.app')
@section('content')

    @if (count($homeimage) > 0)
        @foreach ($homeimage as $home)
            <section style="background-image: url('{{ asset('images/homeslider/' . $home->image_file_name) }}" id="hero"
                class="d-flex flex-column justify-content-center align-items-center">
                <div class="container text-center text-md-left" data-aos="fade-up">
                    <h1>{{ $home->title }}</h1>
                    <h2>{{ $home->description }}</h2>
                    <a href="{{ route('service') }}"
                        class="btn-get-started scrollto">{{ config()->get('lang.' . App::getLocale() . '.get_started') }}</a>
                </div>
            </section>
        @endforeach
    @endif
    @if (count($faq) > 0)
        <section id="faq" class="faq section-bg">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>{{ config()->get('lang.' . App::getLocale() . '.faq') }}</h2>
                    @if (count($dictionary) > 0)
                        <p>{{ $dictionary[0]->faq }}</p>
                    @endif
                </div>
                <div class="faq-list">
                    <div class="b-faq ">
                        @for ($i = 0; $i < count($faq); $i++)
                            @if ($i == 0)
                                <ul>
                                    <li class="faq__item" data-aos="fade-up">
                                        <a class="faq__title js-faq-title">{{ $faq[$i]->question }}
                                            <i class="bx bx-help-circle icon-help"></i> </a>
                                        <div class="faq__content js-faq-content">
                                            <p> {{ $faq[$i]->answer }} </p>
                                        </div>
                                    </li>
                                </ul>
                            @endif
                            @if ($i != 0)
                                <ul>
                                    <li class="faq__item" data-aos="fade-up">
                                        <a class="faq__title js-faq-title">{{ $faq[$i]->question }}
                                            <i class="bx bx-help-circle icon-help"></i> </a>
                                        <div style="display:none" class="faq__content js-faq-content ">
                                            <p> {{ $faq[$i]->answer }} </p>
                                        </div>
                                    </li>
                                </ul>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </section>
    @endif
    </main>
@push('script')
    <script>
        $(document).ready(function() {
            $(".js-faq-title").on("click", function(e) {
                console.log(4144);
                e.preventDefault();
                var $this = $(this);
                if (!$this.hasClass("faq__active")) {
                    $(".js-faq-content").slideUp(800);
                    $(".js-faq-title").removeClass("faq__active");
                    $(".js-faq-rotate").removeClass("faq__rotate");
                }
                $this.toggleClass("faq__active");
                $this.next().slideToggle();
                $(".js-faq-rotate", this).toggleClass("faq__rotate");
            });
        });
    </script>
    @endpush
@endsection

@extends('app.layouts.app')
@section('content')
    @if (count($homeimage) > 0)
        @foreach ($homeimage as $home)
            <section style="background-image: url('{{ asset('images/homeslider/' . $home->image_file_name) }}" id="hero"
                class="d-flex flex-column justify-content-center align-items-center">
                <div class="container text-center text-md-left" data-aos="fade-up">
                    <h1>{{ $home->title }}</h1>
                    <h2>{{ $home->description }}</h2>
                    <a href="{{ url(App::getLocale() . "/insurance") }}"
                        class="btn-get-started scrollto">{{ config()->get('lang.' . App::getLocale() . '.get_started') }}</a>
                </div>
            </section>
        @endforeach
    @endif
    @if (count($faq) > 0)
        <section id="faq" class="faq section-bg">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>{{config()->get('lang.' . App::getLocale() . '.faq')}}</h2>
                    @if (count($dictionary) > 0)
                    <p>{{  $dictionary[0]->faq }}</p>
                    @endif
                </div>
                <div class="faq-list">
                    <div>
                        <ul>
                            @for ($i = 0; $i < count($faq); $i++)
                                @if ($i == 0)
                                    <li data-aos="fade-up">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                            class="collapse" data-bs-target="#faq-list-1"> {{ $faq[$i]->question }}
                                            <i class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                                            <p>
                                                {{ $faq[$i]->answer }} </p>
                                        </div>
                                    </li>
                                @endif
                                @if ($i != 0)
                                    <li data-aos="fade-up" data-aos-delay="100">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                            data-bs-target="#faq-list-2" class="collapsed"> {{ $faq[$i]->question }}
                                            <i class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                            <p>
                                                {{ $faq[$i]->answer }} </p>
                                        </div>
                                    </li>
                                @endif
                            @endfor
                    </div>
                    </ul>
                </div>
            </div>
        </section>
    @endif
    </main>
@endsection

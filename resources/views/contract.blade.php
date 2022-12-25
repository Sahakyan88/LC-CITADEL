@extends('app.layouts.app')
@section('content')
    <style>
        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(1.5);
            /* IE */
            -moz-transform: scale(1.5);
            /* FF */
            -webkit-transform: scale(1.5);
            /* Safari and Chrome */
            -o-transform: scale(1.5);
            /* Opera */
            transform: scale(1.5);
            margin-right: 5px;
        }

        input[type='checkbox'] {
            accent-color: #1bac91;

        }
    </style>
    <section id="contact" class=" services section-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><img style="width: 5%" src="{{ asset('assets/img/nkar.png') }}">LC-CITADEL
                        </div>

                        <div class="card-body">
   <p>{{ config()->get('lang.' . App::getLocale() . '.accept-contract') }}
                                <a target="_blank" class="pdf"
                                    href="{{ asset('content/' . $file_path) }}"> {{ config()->get('lang.' . App::getLocale() . '.contract') }}</a>
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <form method="post" action="{{ route('contractCheck') }}">
                                    @csrf
                                   <div class="mb-2">
                                    <input name="service_id"  class="pay_allowed" type="hidden" value="{{ $id }}" />

                                    <input name="pay_allowed" class="pay_allowed" type="checkbox" value="1" />
                                     {{ config()->get('lang.' . App::getLocale() . '.accept') }}
                                    </div>
                                    @error('pay_allowed')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                    <button type="submit"class="reset-p">{{ config()->get('lang.' . App::getLocale() . '.save') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

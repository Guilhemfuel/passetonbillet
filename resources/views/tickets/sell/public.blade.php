@extends('layouts.app')

@section('advanced_title')
    <title>@lang('tickets.sell.public.title')</title>
@endsection

@section('advanced_description')
    <meta name="description"
          content="@lang('tickets.sell.public.meta_description')"/>
@endsection

@section('content')

    <div id="sell-public">
        <div class="first-section orange-gradient">

            @include('components.nav-simple')

            <div class="first-section-content">
                <h1 class="catchline text-center">
                    @lang('tickets.sell.public.title')
                </h1>
                <h3 class="text-white text-center">
                    @lang('tickets.sell.public.subtitle')
                </h3>
            </div>

            <div class="video">
                <div class='responsive-container'>
                    <iframe src='https://www.youtube.com/embed//N0wy1LC8H0w?modestbranding=1&border=0&showinfo=0&autoplay=1&mute=1' frameborder='0'></iframe>
                </div>
            </div>
        </div>

        <div class="section-keywords pb-5">

            <div class="section-btn pb-5">
                <a href="{{ route('login') }}" class="text-uppercase font-weight-bold btn btn-ptb-blue text-center m-3">
                    @lang('nav.resell_a_ticket')
                </a>
            </div>
            <div class="section-title">
                <h3>
                    @lang('tickets.sell.public.question')
                </h3>
                <h4 class="mt-3">
                    @lang('tickets.sell.public.subquestion')
                </h4>
            </div>
            <div class="font-weight-bold section-list mt-4">
                <div class="section-list-group">
                    <ul>
                        <li>Revendre un billet eurostar</li>
                        <li>Revendre un billet prems</li>
                        <li>Revendre un billet thalys</li>
                        <li>Revendre un billet sncf</li>
                    </ul>
                </div>
                <div class="section-list-group">
                    <ul>
                        <li>Revendre un billet idgtv</li>
                        <li>Revendre un billet ter</li>
                        <li>Revendre un billet tgv</li>
                        <li>Revendre un billet de train</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="section-favorites" id="section-favorites">
            <h2 class="text-center text-warning title">@lang('tickets.sell.public.favorites.title')</h2>
            <h5 class="text-center text-warning subtitle">@lang('tickets.sell.public.favorites.subtitle')</h5>


            <div class="cards-horizontal-list">
                <div id="scroll-left-cities" class="scroll-btn">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </div>
                <div id="scroll-right-cities" class="scroll-btn">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </div>

                <div class="cards" id="cards-trips">
                    <div class="d-inline-flex px-3">
                        <a class="card card-trip"
                           href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=8267" target="_blank">
                            <div class="card-img-top-background"
                                 style="background-image: url('/../../img/cities/london.jpeg')">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Paris <span class="arrow"></span> Londres</h5>
                            </div>
                        </a>
                        <a class="card card-trip"
                           href="{{route('public.ticket.buy.page')}}?departure_station=8267&arrival_station=4916" target="_blank">
                            <div class="card-img-top-background"
                                 style="background-image: url('../../img/cities/paris-2.jpeg')">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Londres <span class="arrow"></span> Paris</h5>
                            </div>
                        </a>
                        <a class="card card-trip"
                           href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=4718" target="_blank">
                            <div class="card-img-top-background"
                                 style="background-image: url('../../img/cities/lyon.jpg')">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Paris <span class="arrow"></span> Lyon</h5>
                                <div class="orange-card-border"></div>
                            </div>
                        </a>
                        <a class="card card-trip"
                           href="{{route('public.ticket.buy.page')}}?departure_station=4718&arrival_station=4916" target="_blank">
                            <div class="card-img-top-background"
                                 style="background-image: url('../../img/cities/paris.jpeg')">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Lyon <span class="arrow"></span> Paris</h5>
                            </div>
                        </a>
                        <a class="card card-trip"
                           href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=4791" target="_blank">
                            <div class="card-img-top-background"
                                 style="background-image: url('../../img/cities/marseille.jpg')">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Paris <span class="arrow"></span> Marseille</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-recent-tickets">
            <h2 class="text-center text-warning title">@lang('tickets.sell.public.recent')</h2>


            <div class="tickets-horizontal-list">

                <div id="scroll-left-tickets" class="scroll-btn">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </div>
                <div id="scroll-right-tickets" class="scroll-btn">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </div>

                <div id="recent-tickets" class="tickets">
                    <div class="d-inline-flex px-3">
                        <div v-for="ticket in child.tickets.recentTickets" class="ticket-wrap"
                             :key="ticket.id">
                            <ticket :ticket="ticket" :buying="true">
                            </ticket>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="section-feedback" id="section-feedback">
            <h2 class="text-center text-warning title">{{__('welcome.feedback.title')}}</h2>

            <div class="container-fluid">
                <div class="row px-5">
                    @foreach ($reviews as $review)
                        <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                            <div class="card card-review ">
                                <div class="card-body">
                                    <img src="{{ $review->user->picture  }}" class="picture"
                                         alt="user profile picture"/>

                                <!-- <p class="date">
                                         {{ $review->created_at }}
                                        </p> -->

                                    <h4 class="first-name">
                                        {{ $review->user->first_name }}
                                    </h4>
                                    <el-rate
                                            :value="5"
                                            disabled
                                            text-color="#FF9600"
                                    >
                                    </el-rate>
                                    <p class="comment">
                                        {{ $review->text }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div>
            @include('components.footer')
        </div>
    </div>

    @push('scripts')

        <script type="application/javascript">

            /**
             *   Script to slide the card-trips and recent-tickets
             */
            let rightTripBtn = document.getElementById('scroll-right-cities');
            let leftTripBtn = document.getElementById('scroll-left-cities');

            let rightTicketBtn = document.getElementById('scroll-right-tickets');
            let leftTicketBtn = document.getElementById('scroll-left-tickets');

            let tripContainer = document.getElementById('cards-trips');
            let ticketContainer = document.getElementById('recent-tickets');

            rightTripBtn.onclick = function () {
                sideScroll(tripContainer, 'right', 25, 365, 25);
            };

            leftTripBtn.onclick = function () {
                sideScroll(tripContainer, 'left', 25, 365, 25);
            };

            leftTicketBtn.onclick = function () {
                sideScroll(ticketContainer, 'left', 25, 365, 25);
            };

            rightTicketBtn.onclick = function () {
                sideScroll(ticketContainer, 'right', 25, 365, 25);
            };


            function sideScroll(element, direction, speed, distance, step) {
                scrollAmount = 0;
                var slideTimer = setInterval(function () {
                    if (direction == 'left') {
                        element.scrollLeft -= step;
                    } else {
                        element.scrollLeft += step;
                    }
                    scrollAmount += step;
                    if (scrollAmount >= distance) {
                        window.clearInterval(slideTimer);
                    }
                }, speed);
            }


        </script>

        <script type="application/javascript">

            /**
             *   Script to toggle to pos-top class of the nav-bar
             */
            function checkScroll() {
                let scroll = window.scrollY;

                // On mobile only 20 pix are enough
                if ( (scroll > 100 && !window.Vue.prototype.$mobile) || (scroll > 20 && window.Vue.prototype.$mobile ) ) {
                    document.getElementById('nav').classList.remove("pos-top");
                }
                else {
                    document.getElementById('nav').classList.add("pos-top");
                }
            }

            (function () {
                window.addEventListener('scroll', function () {
                    checkScroll();
                });
            })();

            // On page load check position of nav
            checkScroll();

        </script>

    @endpush


@endsection

<?php
$langTickets = Lang::get( 'tickets' );
$routes = [
    'tickets'  => [

    ],
    'register' => route( 'register.page' )
];
?>

@push('vue-data')
    <script type="application/javascript">

            data.welcome = {
                ticketLang: {!! json_encode($langTickets) !!},
                routes: {!! json_encode($routes) !!}
            }

            data.tickets = {
                recentTickets: {!! json_encode( $recentTickets ) !!}
            }

    </script>
@endpush



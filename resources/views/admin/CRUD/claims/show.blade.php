@extends('admin.layouts.app')


@section('admin-title')
    - Manage Claim
@endsection

@section('admin-content')

    <div class="crud-table">

        <div class="card">

            <div class="card-header">
                <h5>Manage Claim</h5>
                {!!'<a href='.route('claims.index').'>Back to claims list</a>'!!}
            </div>

            <div class="card-body row" id="editPage">
                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Claim Duration</h5>

                    <div>
                        Started at : {{ $ticket->claim->created_at->format('Y-m-d H:i:s') }}<br>
                        @if($ticket->claim->status)
                            Close at : {{ $ticket->claim->updated_at->format('Y-m-d H:i:s') }}
                        @endif
                    </div>

                </div>
                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Claim status</h5>

                    <div>
                        @if(!$ticket->claim->status && !$ticket->claim->claim_seller)
                            <b style="color: red;">Waiting for seller</b>
                        @elseif(!$ticket->claim->status && $ticket->claim->claim_seller)
                            <b style="color: #0b89e7;">Pending for decision</b>
                        @elseif($ticket->claim->status === 'WON')
                            <b style="color: green;">Close, outcome for Purchaser</b>
                        @elseif($ticket->claim->status === 'LOST')
                            <b style="color: green;">Close, outcome for Seller</b>
                        @elseif($ticket->claim->status === 'EQUALITY')
                            <b style="color: #FF9600;">Close, outcome for Purchaser and Seller</b>
                        @endif
                    </div>

                </div>

                <div class="col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Ticket information</h5>

                    <div>
                        Id : {{ $ticket->id }}<br>
                        Departure : {{ $ticket->train->carbon_departure_date }}<br>

                        <b>From : </b> {{ $ticket->train->departureCity->name }}<br>

                        <br>

                        Arrival : {{ $ticket->train->carbon_arrival_date }}<br>
                        <b>To : </b> {{ $ticket->train->arrivalCity->name }}<br>
                        <br>
                    </div>

                    <div>
                        <a href="{{ route('tickets.show_pdf', ['ticket_id' => $ticket->id]) }}" class="btn btn-warning btn-fill btn-sm ml-3">See PDF</a>
                    </div>
                </div>

                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Buyer Answers</h5>

                    @if($ticket->claim->claim_purchaser)

                        @php
                            $answers = json_decode($ticket->claim->claim_purchaser);

                            $questions = [
                            'Avez vous essayez de scanner le billet en personne ?',
                            'A quelle heure avez vous scannez le billet ?',
                            'Avez vous rencontrez un problème au moment du scan du billet',
                            'Avez vous été controlé après avoir scanné le billet ?',
                            'Informations supplémentaire',
                            ]

                        @endphp

                        @foreach ($answers as $key => $answer)

                            <b>{{ $questions[$key] }}</b>
                            <br>

                            @if($answer === true)
                                Oui
                            @elseif($answer === false)
                                Non
                            @else
                                {{ $answer }}
                            @endif
                            <br>
                        @endforeach
                    @endif
                </div>

                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Seller Answers</h5>

                    @if($ticket->claim->claim_seller)

                        @php
                            $answers = json_decode($ticket->claim->claim_seller);

                            $questions = [
                            'Avez vous mis votre billet en vente sur d\'autre site ?',
                            'Avzz vous bien téléchargé le billet complet original ?',
                            'Informations supplémentaire',
                            ]

                        @endphp

                        @foreach ($answers as $key => $answer)

                            <b>{{ $questions[$key] }}</b>
                            <br>

                            @if($answer === true)
                                Oui
                            @elseif($answer === false)
                                Non
                            @else
                                {{ $answer }}
                            @endif
                            <br>
                        @endforeach
                    @else
                        Pas de réponse du vendeur
                        <br>
                    @endif
                </div>

                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Buyer Track Record</h5>

                    <div>
                        {{ $ticket->claim->purchaser->full_name }}
                        <br>

                        <b>Registration date</b> : {{ $ticket->claim->purchaser->created_at->format('Y-m-d') }}<br>

                        <b>FB Connect :</b> @if($ticket->claim->purchaser->fb_id) Oui @else Non @endif <br>
                    </div>

                    <div class="mt-2">
                        <h6>History Tickets : </h6>
                        @forelse($ticketsPurchaser as $ticketPurchaser)
                            @if($ticketPurchaser->user_id === $ticket->claim->purchaser_id)
                                Vendu :
                            @else
                                Acheté :
                            @endif
                            {{ $ticketPurchaser->id }} - {{ $ticketPurchaser->train->departureCity->name }} - {{ $ticketPurchaser->train->arrivalCity->name }}<br>
                        @empty
                            Aucun ticket
                        @endforelse
                    </div>

                    <div class="mt-2">
                        <h6>Ticket currently on sale : </h6>
                        @forelse($ticketsPurchaserOnSale as $ticketPurchaser)
                            {{ $ticketPurchaser->id }} - {{ $ticketPurchaser->train->departureCity->name }} - {{ $ticketPurchaser->train->arrivalCity->name }}<br>
                        @empty
                            Aucun ticket
                        @endforelse
                    </div>

                    <div class="mt-2">
                        <b>Other claims : </b><br>
                        @forelse($claimsPurchaser as $claim)
                            <a href="{{route( 'claims.show', $claim->id )}}" target="_blank">
                                @if($claim->status === 'WON')
                                    Claim n°{{ $claim->id }} - @if($claim->purchaser_id == $ticket->claim->purchaser->id) Gagné @else Perdu @endif
                                @elseif($claim->status === 'LOST')
                                    Claim n°{{ $claim->id }} - @if($claim->purchaser_id == $ticket->claim->purchaser->id) Perdu @else Gagné @endif
                                @elseif($claim->status === 'EQUALITY')
                                    Claim n°{{ $claim->id }} - Egalité
                                @else
                                    Claim n°{{ $claim->id }} - Open
                                @endif
                            </a>
                            <br>
                        @empty
                            No other claims from this user
                        @endforelse
                    </div>
                </div>

                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Seller Track Record</h5>

                    <div>
                        {{ $ticket->claim->seller->full_name }}
                        <br>

                        <b>Registration date</b> : {{ $ticket->claim->seller->created_at->format('Y-m-d') }}<br>

                        <b>FB Connect :</b> @if($ticket->claim->seller->fb_id) Oui @else Non @endif <br>
                    </div>

                    <div class="mt-2">
                        <h6>History Tickets : </h6>
                        @forelse($ticketsSeller as $ticketSeller)
                            @if($ticketSeller->user_id === $ticket->claim->seller_id)
                                Vendu :
                            @else
                                Acheté :
                            @endif
                            {{ $ticketSeller->id }} - {{ $ticketSeller->train->departureCity->name }} - {{ $ticketSeller->train->arrivalCity->name }}<br>
                        @empty
                            Aucun ticket
                        @endforelse
                    </div>

                    <div class="mt-2">
                        <h6>Ticket currently on sale : </h6>
                        @forelse($ticketsSellerOnSale as $ticketSeller)
                            {{ $ticketSeller->id }} - {{ $ticketSeller->train->departureCity->name }} - {{ $ticketSeller->train->arrivalCity->name }}<br>
                        @empty
                            Aucun ticket
                        @endforelse
                    </div>

                    <div class="mt-2">
                        <b>Other claims : </b><br>
                        @forelse($claimsSeller as $claim)
                            <a href="{{route( 'claims.show', $claim->id )}}" target="_blank">
                                @if($claim->status === 'WON')
                                    Claim n°{{ $claim->id }} - @if($claim->purchaser_id == $ticket->claim->seller->id) Gagné @else Perdu @endif
                                @elseif($claim->status === 'LOST')
                                    Claim n°{{ $claim->id }} - @if($claim->purchaser_id == $ticket->claim->seller->id) Perdu @else Gagné @endif
                                @elseif($claim->status === 'EQUALITY')
                                    Claim n°{{ $claim->id }} - Egalité
                                @else
                                    Claim n°{{ $claim->id }} - Open
                                @endif
                            </a>
                            <br>
                        @empty
                            No other claims from this user
                        @endforelse
                    </div>
                </div>

                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Contact Purchaser</h5>
                    {{ $ticket->claim->purchaser->email }}<br>
                    {{ $ticket->claim->purchaser->phone }}<br>
                </div>

                <div class="col-md-6 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Contact Seller</h5>
                    {{ $ticket->claim->seller->email }}<br>
                    {{ $ticket->claim->seller->phone }}<br>
                </div>

                <div class="col-md-12 col-12 mt-3 p-2 text-center" style="border: 1px solid #dbdbdb;">
                    <h5>Take Action</h5>

                    <div class="row">
                        <div class="col-4">
                            <a href="{{ route('claims.refund', ['ticket_id' => $ticket->id]) }}" class="btn btn-warning btn-fill btn-sm ml-3">
                                Refund Buyer
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="{{ route('claims.pay', ['ticket_id' => $ticket->id]) }}" class="btn btn-warning btn-fill btn-sm ml-3">
                                Pay 2/3 Each
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="{{ route('claims.pay_each', ['ticket_id' => $ticket->id]) }}" class="btn btn-warning btn-fill btn-sm ml-3">
                                Pay Seller
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
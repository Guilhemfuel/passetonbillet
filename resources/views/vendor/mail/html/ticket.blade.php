<table class="ticket" width="100%" cellpadding="0" cellspacing="0">
    <tr class="header">
        <td class="text-center" style="padding:10px;">
            {{$ticket->train->carbon_departure_date->formatLocalized('%A %d %B %Y')}}
        </td>
    </tr>
    <tr>
        <td class="content {{isset($discussion)?'':'bottom_radius'}}">
            <table width="100%" cellspacing="0">
                <tr>
                    <td colspan="5" height="20"></td>
                </tr>
                <tr>
                    <td width="20">
                        {{--                        {{$discussion->price}} {{$discussion->currency}}* for the train *{{$discussion->ticket->train->departureCity->name}}* to {{$discussion->ticket->train->arrivalCity->name}} on {{$discussion->ticket->train->carbon_departure_date->formatLocalized('%A %d %B %Y')}} at {{$discussion->ticket->train->departure_date}}, was accepted!--}}
                    </td>
                    <td class="bold" style="text-align: center;">{{$ticket->train->departureCity->name}}</td>
                    <td style="text-align: center;">{{$lang=='fr'?'à':'to'}}</td>
                    <td class="bold" style="text-align: center;">{{$ticket->train->arrivalCity->name}}</td>
                    <td width="20"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="bold"
                        style="text-align: center;color: #D40EFD;"> {{substr($ticket->train->departure_time, 0, -3)}} </td>
                    <td></td>
                    <td class="bold"
                        style="text-align: center;color: #D40EFD;"> {{substr($ticket->train->arrival_time, 0, -3)}} </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" height="20"></td>
                </tr>
            </table>
        </td>
    </tr>
    @if(isset($discussion))
        <tr class="footer">
            <td>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding:13px; text-align: center">
                            <a style="color:white; text-decoration: none;" href="{{route('public.ticket.download',['ticket_id'=>$ticket->id])}}">{{$lang=='fr'?'Télécharger le billet':'Download ticket'}}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif
</table>

@if(isset($discussion))
<table width="100%" cellpadding="0" cellspacing="0">
    <tr class="header">
        <a href="{{$ticket->passbook_link}}">
            <img style="display: block;margin: auto;width:154px; margin-top: 20px;"
                 src="{{secure_asset('/img/mail/apple_wallet.png')}}">
        </a>
    </tr>
</table>
@endif


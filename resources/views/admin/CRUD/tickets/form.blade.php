
{{-- Additional Butttons--}}
@push('additional-btn')
    @if(!$entity->scam)
    <a class="btn btn-danger btn-fill btn-sm mr-3 mt-2" href="{{route('tickets.scam',$entity->id)}}">
        <i class="fa fa-ban" aria-hidden="true"></i>
        Mark as Scam
    </a>
    @endif
    @if($entity->pdf_downloaded)
    <a class="btn btn-info btn-fill btn-sm mr-3 mt-2" target="_blank" href="{{route('public.ticket.download',['ticket_id'=>$entity->id])}}">
        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download ticket
    </a>
    @else
    <button class="btn btn-info btn-fill btn-sm mr-3 mt-2" type="button" disabled>
        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download ticket
    </button>
    @endif
    @if(!$entity->passed)
    <button class="btn btn-primary btn-fill btn-sm mr-3 mt-2" @click.prevent="child.ticket.uploadPdfModal = true">
        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
        Manually Upload PDF
    </button>
    @if(!$entity->pdf_downloaded)
    <a class="btn btn-warning btn-fill btn-sm mr-3 mt-2" href="{{route('tickets.redownload',['ticket_id'=>$entity->id])}}">
        <i class="fa fa-cloud-download" aria-hidden="true"></i> Retry downloading ticket
    </a>
    @endif
    @if($entity->sold_to_id != null)
    <a class="btn btn-outline-purple btn-fill btn-sm mt-2" href="{{route('tickets.revert_status',['ticket_id'=>$entity->id])}}">
         <i class="fa fa-step-backward" aria-hidden="true"></i> Revert ticket status
    </a>


        @push('additional-content')
            {{-- Modal here so that pdf form is in the right place (not in the update form)--}}
            <modal v-cloak :is-open="child.ticket.uploadPdfModal"  @close-modal="child.ticket.uploadPdfModal = false"
                   title="Manually upload ticket PDF">
                <form method="post" action="{{route('tickets.manual_upload',$entity->id)}}" enctype="multipart/form-data" id="pdfForm">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input class="form-control" type="file" name="ticket_pdf">
                    </div>
                    <button type="submit" class="btn btn-block btn-ptb-blue">Upload</button>
                </form>
            </modal>
        @endpush

        @push('vue-data')
            {{--Modal here to avoid being in edition form--}}
            <script type="application/javascript">
                data.ticket = {
                    uploadPdfModal: false
                }
            </script>
        @endpush
    @endif
@endpush

@if($entity->scam)
    <div class="row text-bold">
        <div class="col">
            <h3 class="text-danger  text-center">SCAM</h3>
        </div>
    </div>
@elseif($entity->sold_to_id!=null)
<div class="row text-bold">
    <div class="col">
        <h3 class="text-success  text-center">SOLD</h3>
    </div>
</div>
@endif

{{-- Form --}}

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label><a href="{{route('trains.edit',$entity->train->id)}}">Train Number</a></label>
            <input type="text" class="form-control" name="train_number" placeholder="Train number"
                   value="{{$entity->train->number}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Departure Date</label>
            <input type="text" class="form-control" placeholder="Train number"
                   value="{{$entity->train->carbon_departure_date->format('d/m/Y H:i:s')}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Departure city</label>
            <input type="text" class="form-control" name="departure_city" placeholder="Departure city"
                   value="{{$entity->train->departureCity->name}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Arrival city</label>
            <input type="text" class="form-control"  name="arrival_city" placeholder="Arrival city"
                   value="{{$entity->train->arrivalCity->name}}" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Buyer Name</label>
            <input type="text" class="form-control" placeholder="Buyer last name"
                   value="{{$entity->buyer_name}}" name="buyer_name" disabled>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Buyer Email</label>
            <input type="text" class="form-control" placeholder="Buyer email address"
                   value="{{$entity->buyer_email}}" name="buyer_email" disabled>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Booking Code</label>
            <input type="text" class="form-control" placeholder="Booking code"
                   value="{{$entity->provider_code}}" name="provider_code" disabled>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Ticket Number</label>
            <input type="text" class="form-control"
                   value="{{$entity->ticket_number}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Trip</label>
            <select class="form-control" name="inbound" disabled>
                <option value="true" {{$entity->inbound?'selected':''}}>Inbound</option>
                <option value="false" {{!$entity->inbound?'selected':''}}>Outbound</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Seller</label>
            @if(!$entity->scam)
            <userpicker :name="'user_id'"
                        :default-placeholder="'User name'"
                        :default-value="{{json_encode($entity->user)}}"></userpicker>
            @else
                <input type="text" class="form-control"
                       value="{{$entity->user->full_name}}" disabled>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Buyer</label>
            <input type="text" class="form-control"
                   value="{{isset($entity->buyer)?$entity->buyer->full_name:''}}" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Bought price</label>
            <input class="form-control" value="{{$entity->bought_price}}" name="bought_price" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Bought currency</label>
            <select class="form-control" name="bought_currency">
                <option value="GBP" {{$entity->bought_currency=='GBP'?'selected':''}}>GBP</option>
                <option value="EUR" {{$entity->bought_currency=='EUR'?'selected':''}}>EUR</option>
                <option value="EUR" {{$entity->bought_currency=='EFT'?'selected':''}}>EFT</option>
                <option value="EUR" {{$entity->bought_currency=='USD'?'selected':''}}>USD</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Selling price</label>
            <input class="form-control" value="{{$entity->price}}" name="price"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Selling currency</label>
            <select class="form-control" name="currency">
                <option value="GBP" {{$entity->currency=='GBP'?'selected':''}}>GBP</option>
                <option value="EUR" {{$entity->currency=='EUR'?'selected':''}}>EUR</option>
                <option value="EUR" {{$entity->currency=='EFT'?'selected':''}}>EFT</option>
                <option value="EUR" {{$entity->currency=='USD'?'selected':''}}>USD</option>
            </select>
        </div>
    </div>
</div>


{{------------ Additional content --------------}}

@push('additional-content')

    <div class="row mt-5">
        <div class="col-sm-6 col-12">
            <h5>Offers ({{$entity->discussions()->count()}})</h5>
            <table class="table table-hover table-striped">
                <thead>
                <th>Date</th>
                <th>From</th>
                <th>Price</th>
                <th>Status</th>
                <th>Link</th>
                </thead>
                <tbody>
                @foreach($entity->discussions as $offer)
                    <tr>
                        <td>{{$offer->created_at->format('d/m/Y')}}</td>
                        <td>
                            {{$offer->buyer->full_name}}
                        </td>
                        <td>
                            {{$offer->price}} {{$offer->currency}}
                        </td>
                        <td>
                            {{$offer->status_text}}
                        </td>
                        <td>
                            <a href="{{route('offers.edit',$offer->id)}}"><i class="fa fa-comments" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endpush

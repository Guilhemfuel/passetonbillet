<div class="row">
    @if($entity->ticket->eurostar_ticket_number == null )
        @if($entity->ticket->sold_to_id==null)
            <div class="col-md-12">
                <div class="form-group">
                    <label>Status</label>
                    <small class="text-info">If you mark the ticket as sold, all conversations will be disabled (mark as
                        sold).
                    </small>
                    <select class="form-control" name="mark_as_sold">
                        <option value="true">True</option>
                        <option value="false" selected>False</option>
                    </select>
                </div>
            </div>

        @else
            <p>Billet déjà vendu.</p>
        @endif
    @else
        <p>You can't modify an offer for a real ticket.</p>
    @endif
</div>

@if ($entity->status == \App\Models\Discussion::DENIED)
    @push('additional-btn')
        <a class="btn btn-info btn-sm" href="{{route('offers.undeny',$entity->id)}}">
            <i class="fa fa-ban" aria-hidden="true"></i> Cancel Deny Offer
        </a>
    @endpush
@endif

@push('additional-content')
    <div class="row mt-5">
        <div class="col-12">
            <h5>Messages de la discussion</h5>
        </div>

        <div class="discussion-admin col-12">
        @foreach($entity->messages as $message)
            @if($message->sender->id == $entity->buyer->id)
            <p class="p-0 m-0">
                {{$message->created_at}} - <a href="{{route('users.edit',$entity->buyer->id)}}" class="text-bold text-primary">{{$message->sender->full_name}}</a>
                @if($message->read_at)
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                @endif
                : {{$message->message}}
            </p>
            @else
            <p class="p-0 m-0">
                {{$message->created_at}} - <a href="{{route('users.edit',$entity->seller->id)}}" class="text-bold text-info">{{$message->sender->full_name}}</a>
                @if($message->read_at)
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                @endif
                : {{$message->message}}
            </p>
            @endif
        @endforeach
        </div>

    </div>

@endpush
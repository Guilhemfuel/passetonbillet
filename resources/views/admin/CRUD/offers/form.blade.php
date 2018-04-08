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

@push('additional-content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <h5>Messages de la discussion</h5>
            </div>

            <div class="discussion-admin col-12">
            @foreach($entity->messages as $message)
                <p class="p-0 m-0"><span class="text-bold text-primary">{{$message->sender->full_name}} :</span> {{$message->message}}</p>
            @endforeach
            </div>

        </div>

    </div>
@endpush
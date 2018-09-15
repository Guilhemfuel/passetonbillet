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
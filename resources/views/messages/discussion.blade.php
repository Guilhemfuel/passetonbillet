@extends('layouts.dashboard')

@section('title')
    - Offer
@endsection

@section('dashboard-content')
        <div  id="messages-discussion">
            <discussion :discussion-default="child.discussion.discussion"
            ></discussion>
        </div>
@endsection

@push('vue-data')
    <script type="application/javascript">
        data.discussion = {
            discussion: {!! json_encode($discussion) !!}
        };
        currentPage.data = {
            discussion_id: {!! $discussion->id !!},
            ticket_id: {!! $discussion->ticket->id !!},
        }
    </script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $crisp.push(["do", "chat:hide"]);
    </script>
@endpush

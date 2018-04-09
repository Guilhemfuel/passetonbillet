
    @if(count($entities)>0)

    <table class="table table-hover table-striped">
        <thead>
        <th>Seller Email</th>
        <th>Date</th>
        <th>From</th>
        <th>To</th>
        <th>Price</th>
        <th class="text-center">NB Offres</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr @if($entity->sold_to_id != null) class="table-success"
                @elseif($entity->passed)
                class="table-danger"
                @endif
            >
                <td>
                    <a href="{{route('users.edit',$entity->user->id)}}">{{$entity->user->full_name}}</a>
                    <span class="text-danger pull-right">{{$entity->eurostar_ticket_number==null?'FAKE':''}}</span>
                </td>
                <td>
                    {{$entity->train->carbon_departure_date->format('d/m/Y')  }}
                </td>
                <td>
                    {{substr($entity->train->departureCity->short_name,2)}}
                </td>
                <td>
                    {{ substr($entity->train->arrivalCity->short_name,2)  }}
                </td>
                <td>{{$entity->price}} {{$entity->currency}}</td>
                <td class="text-center">{{$entity->discussions->count()}}</td>
                <td>
                    <button class="btn btn-sm btn-primary btn-fill" onclick="share({{ $entity->id}})">
                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                    </button>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('tickets.edit',$entity->id)}}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <input style="height: 10px;width: 10px;opacity: 0;" value="{{route( 'ticket.unique.page', [ 'ticket_id' => \Hashids::encode($entity->id) ] )}}" id="share-{{ $entity->id}}">

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @else

        <div class="content">
            0 entity found!
        </div>

    @endif

@push('scripts')

    <script type="application/javascript">
        console.log(navigator);
        let share = function(id) {
            document.getElementById('share-'+id).select();
            document.getElementById('share-'+id).setSelectionRange(0,  document.getElementById('share-'+id).value.length);

            document.execCommand("Copy");
        }
    </script>
@endpush
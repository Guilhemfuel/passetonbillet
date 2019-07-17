@if(count($entities)>0)

    <table class="table table-hover table-striped">
        <thead>
        <th>Question</th>
        <th>Actions</th>

        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>{{$entity->question_en}}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('help_questions.edit',$entity->id)}}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
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

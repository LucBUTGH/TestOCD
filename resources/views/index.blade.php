<div>
    @foreach($persons as $person)
        <div>
            <span>{{ $person->first_name }}</span>
            <span>{{ $person->last_name }}</span>
            <span>{{ $person->date_of_birth }}</span>
        </div>
    @endforeach
</div>

@if (count($errors))
    <div class="alert alert-danger">
    
        <ul>
            @foreach ($errors->all() as $error)

                <li>
                    @if (strpos($error, 'deadline.') !== false)
                        Date and Time need to be set
                    @elseif (strpos($error, 'attachment.') !== false)
                        Attachment may not be greater than 2000 kilobytes.
                    @elseif (strpos($error, 'description.') !== false)
                        Description should not be less than three characters
                    @else
                        {{ $error }}
                    @endif
                </li>

            @endforeach
        </ul>
    </div>
@endif
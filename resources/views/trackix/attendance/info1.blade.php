<form action="" method="post">
    @csrf
    <input type="hidden" name="document_id" value="{{$attendData[0]->id}}">
    <input name="document_id" id='documentID' class="form-control col-sm-5" onmouseover="this.focus();" type="text">


    <div>
        <p>
            first name: {{ $attendData[0]->first_name }}
        </p>
    </div>
    <div>
        <p>
            last name: {{ $attendData[0]->last_name }}
        </p>
    </div>
    <div>
        <p>
            email: {{ $attendData[0]->email_address }}
        </p>
    </div>
    <div>
        <p>
            phone: {{ $attendData[0]->phone_number }}
        </p>
    </div>

    <div class="col-12 d-flex justify-content-end mt-6">
        <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button>
        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.attendance.scanme') }}">Cancel</a>
        <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
    $('#documentID').focus();
    });
</script>

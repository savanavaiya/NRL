@foreach ($rdata as $rdat)
    <div class="checkboxlist">
        <label for="checkbox_1"><span>{{ $rdat }}</span></label>
        <input type="checkbox" name="checkbox[]" id="omcdata" value="{{ $rdat }}">
    </div>
@endforeach                                                
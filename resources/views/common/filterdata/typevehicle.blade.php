@foreach ($rdata3 as $rdat3)
    <div class="checkboxlist">
        <label for="checkbox_1"><span>{{ $rdat3 }}</span></label>
        <input type="checkbox" name="checkbox2[]" id="typeofveh"
            value="{{ $rdat3 }}">
    </div>
@endforeach
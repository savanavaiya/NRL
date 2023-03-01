@foreach ($rdata4 as $rdat4)
    <div class="checkboxlist">
        <label for="checkbox_1"><span>{{ $rdat4 }}</span></label>
        <input type="checkbox" name="checkbox[]" id="auditortyp" value="{{ $rdat4 }}">
    </div>
@endforeach
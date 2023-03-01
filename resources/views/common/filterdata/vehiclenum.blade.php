@foreach ($rdata2 as $rdat2)
    <div class="checkboxlist">
        <label for="checkbox_1"><span>{{ $rdat2 }}</span></label>
        <input type="checkbox" name="checkbox1[]" id="vehinumb"
            value="{{ $rdat2 }}">
    </div>
@endforeach
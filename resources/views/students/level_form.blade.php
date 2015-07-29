Level&nbsp;
	<select name="school_level" id='school_level' style="width:9%;">

		@foreach($level as $v)

			<option value="{{ $v->id }}">{{ $v->school_level }}</option>

		@endforeach

</select>
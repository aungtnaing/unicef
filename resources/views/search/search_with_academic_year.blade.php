State/Region&nbsp;
			<select name="state_id" id='region_id' style="width:20%;">

				<option value="">All</option>

				  	@foreach($state as $st)

				    	<option value="{{ $st->id }}">{{ $st->state_division }}</option>

				    @endforeach

			</select>


		Township&nbsp;
			<select name="township_id" id='township_id' style="width:20%;">
				<option value="">All</option>
			</select>
			
		Academic Year&nbsp;
			<select name="academic_year" id="academic_year" style="width:20%;">

			  	@foreach($academic as $ac)

			    	<option value="{{ $ac->academic_year }}">{{ $ac->academic_year }}</option>

			    @endforeach

			</select>
			
			<input type="submit" value="Search" name="btn_search" class="btn btn-success">
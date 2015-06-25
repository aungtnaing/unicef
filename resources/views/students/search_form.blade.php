		
		State/Region&nbsp;
			<select name="state_id" id='region_id' style="width:20%;">
			
			<?php if(isset($region)) { ?>
	
				<option value="<?php echo $region[0]->state_id; ?>"><?php echo $region[0]->state_division; ?></option>
			<?php } else { ?>
			
				<option value="">--- Select One ---</option>
			
			<?php } ?>
				
				  @foreach($state as $st)

				    	<option value="{{ $st->id }}">{{ $st->state_division }}</option>

				    @endforeach


			</select>

		Township&nbsp;
			<select name="township_id" id='township_id' style="width:20%;">
			
			<?php if(isset($region[0]->township_id)) { ?>
				
				<option value="<?php echo $region[0]->township_id; ?>"><?php echo $region[0]->township_name; ?></option>
				 				
			
			<?php } else { ?>
				
				<option value="">--- Select One ---</option>

				
			<?php } ?>
				
			</select>
			
		Academic Year&nbsp;
			<select name="academic_year" id="academic_year" style="width:12%;">

					<?php if(isset($academic[0]->academic_year)) { ?>
				<option value="<?php echo $academic[0]->academic_year ?>"><?php echo $academic[0]->academic_year ?></option>
			<?php } else { ?>
			
				<option value="">--- Select One ---</option>
			
			<?php } ?>
				
				  @foreach($academic as $ac)

				    	<option value="{{ $ac->academic_year }}">{{ $ac->academic_year }}</option>

				    @endforeach

			</select>
			<!-- <input type="hidden" id="previous_year" name="previous_year" />	 -->		
			
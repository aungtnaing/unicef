		
		State/Region&nbsp;
			<select name="state_id" id='region_id' style="width:20%;">
			
			<?php if(isset($region)) { ?>
	
				@foreach($state as $st)
					
					<option value="<?php echo $st->id; ?>" <?php echo $st->id == $region[0]->state_id ? ' selected="selected"' : ''; ?>>{{ $st->state_division }}</option>
				
				@endforeach
			
			<?php } else { ?>
			
				<option value="">--- Select One ---</option>
				@foreach($state as $st)
					
				    	<option value="{{ $st->id }}">{{ $st->state_division }}</option>

				@endforeach
			
			<?php } ?>
				
		</select>

		Township&nbsp;
			<select name="township_id" id='township_id' style="width:20%;">
			
			<?php if(isset($region[0]->township_id)) { ?>
				
				@foreach($town as $t)
					@if($t->state_divsion_id == $region[0]->state_id)
					
						<option value="<?php echo $t->id; ?>" <?php echo $t->id == $region[0]->township_id ? ' selected="selected"' : ''; ?>>{{ $t->township_name }}</option>
				    	
				    	@endif
				@endforeach			 				
			
			<?php } else { ?>
				
				<option value="">--- Select One ---</option>

			<?php } ?>
				
			</select>
			
		Academic Year&nbsp;
			<select name="academic_year" id="academic_year" style="width:12%;">
				
				<option value="<?php echo Input::get('academic_year'); ?>"><?php echo Input::get('academic_year'); ?></option>
				
			  	@foreach($academic as $ac)

			    	<option value="{{ $ac->academic_year }}">{{ $ac->academic_year }}</option>

			    @endforeach
		
		   </select>	    	
			
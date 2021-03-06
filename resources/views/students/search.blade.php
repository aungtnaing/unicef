	<?php 
		if(Input::get('btn_search')) {
			
			Session::put('state_id', Input::get('state_id'));
			Session::put('academic_year', Input::get('academic_year'));
		} 

	?>
		

		State/Region&nbsp;
			<select name="state_id" id='region_id' style="width:20%;">
			
			<?php if(Session::has('state_id')) { ?>

				@foreach($state as $st)
					
					<option value="<?php echo $st->id; ?>" <?php echo $st->id == Session::get('state_id') ? ' selected="selected"' : ''; ?>>{{ $st->state_division }}</option>
				
				@endforeach
				
			<?php	} else if(isset($region)) { ?>
	
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

		Academic Year&nbsp;
			<select name="academic_year" id="academic_year" style="width:12%;">

				<?php //if(Session::has('academic_year')) { ?>

					<!-- <option value="<?php //echo Session::get('academic_year'); ?>"><?php //echo Session::get('academic_year'); ?></option>
				 -->
				<?php //} else if(Input::get('academic_year')) { ?>

					<!-- <option value="<?php //echo Input::get('academic_year'); ?>"><?php //echo Input::get('academic_year'); ?></option> -->
				
				<?php //} ?>

				<option value="">--- Select One ---</option>
			  	@foreach($academic as $ac)

			    	<option value="{{ $ac->academic_year }}">{{ $ac->academic_year }}</option>

			    @endforeach
		
		   </select>	    	
			
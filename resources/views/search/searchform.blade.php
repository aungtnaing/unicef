<div class="well">
				        @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
 
             <form action="#" method="POST">
              <h4>Search Info</h4>
               
               <div class="form-group" style="padding:14px;">
                
				            <select name="state_id" id='region_id' style="width:20%;">

                    <option value="">All</option>

                    @foreach($states as $st)

                    <option value="{{ $st->id }}">{{ $st->state_division }}</option>

                    @endforeach

                    </select>



                    <select name="township_id" id='township_id' style="width:20%;">
                    <option value="">All</option>
    
                    @foreach($townships as $township)

                    <option value="{{ $township->id }}">{{ $township->township_name }}</option>

                    @endforeach

                    </select>
    

              </div>
              <button class="btn btn-success pull-right" type="summit">Search</button>
            </form>
</div>
     

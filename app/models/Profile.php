<?php
    class Profile extends Eloquent
    {
		protected $table = 'profile';
		protected $fillable = array('name', 'myanmar_name', 'age');
    }
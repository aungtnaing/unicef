<?php
    class Country extends Eloquent
    {
		protected $table = 'country';
		protected $fillable = array('name', 'mm_name');
    }
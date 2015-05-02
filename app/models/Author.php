<?php

class Author extends Eloquent{

	public function book(){

		return $this->belongsTo('Book');
	}

	public function custom_book(){

		$this->whereRaw("");	
	}
}

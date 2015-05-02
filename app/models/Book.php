<?php

class Book extends Eloquent{


	public function author(){
		return $this->hasMany('Author');
	}

}
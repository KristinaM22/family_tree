<?php

class Person
{
	protected $personID, $firstName, $lastName, $birthDate, $gender;

	function __construct( $personID, $firstName, $lastName, $birthDate, $gender )
	{
		$this->personID = $personID;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>


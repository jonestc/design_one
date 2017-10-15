<?php
namespace Jobs;

class Vacancy
{
	public $salaryRange;
	public $skills;

	public function __construct( $salaryRange = [], $skills = [] ) {
		$this->salaryRange = $salaryRange;
		$this->skills = $skills;
	}

	public function getMinSalary() {
		return min($this->salaryRange);
	}

	public function getMaxSalary() {
		return max($this->salaryRange);
	}

}
?>
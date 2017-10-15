<?php
namespace Jobs;

class Candidate
{
	public $candidate;

	public function __construct(\stdClass $candidate) {
		$this->candidate = $candidate;
	}
}
?>
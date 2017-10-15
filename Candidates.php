<?php
namespace Jobs;
use Jobs\Candidate;
use Jobs\Vacancy;

class Candidates
	implements \IteratorAggregate, \Countable
{
	public $allCandidates = [];

	public function __construct(string $filePath) {
		if (!file_exists($filePath)) {
			throw new \Exception("Error Loading Candidates file", 1);
		}
		$candidates = json_decode(file_get_contents($filePath));

		foreach ($candidates->results as $candidate) {
			$this->allCandidates[] = new Candidate($candidate);
		}
	}

	public function getIterator() {
		return new \ArrayIterator($this->allCandidates);
	}

	public function add($candidate) {
		$this->allCandidates[] = $candidate;
	}

	public function count() {
		return count($this->allCandidates);
	}
}
?>
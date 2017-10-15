<?php

require_once 'vendor/autoload.php';
use Jobs\{ Candidates, Candidate, Vacancy };



//var_dump($_SERVER['DOCUMENT_ROOT'] . '/design_one/candidates.json'); //exit();
//echo "<br/>";
//var_dump(file_exists($_SERVER['DOCUMENT_ROOT'] . '/design_one/candidates.json')); exit();
//$candidates = new Candidates($_SERVER['DOCUMENT_ROOT'] . 'candidates.json');
$candidates = new Candidates($_SERVER['DOCUMENT_ROOT'] . '/design_one/candidates.json');
// get candidates that earn over than 40k
$vacancy = new Vacancy([40000]);

//get candidates that earn 20-30k, know php or js
$vacancy2 = new Vacancy([20000, 30000],["php", "js"]);
// get candidates that earn less than 42k and know Ruby and C
$vacancy3 = new Vacancy([42000], ["ruby", "c"]);
// get candidates that know go
$vacancy4 = new Vacancy([], ["go"]);
// get candidates that know one of these languages (elixir, erlang, f#, haskell, lisp)
$vacancy5 = new Vacancy([], ["elixir","erlang","f#","haskell","lisp"]);


/*
check if a candidate knows any/all languages required by a vacancy.
Params: 
$knowsall: boolean to control weather the check is for any, or all languages ( false for any, true for all)
*/
function checkLanguages($candidate, $vacancy, $knowsAll = FALSE){
	//catch in case the vacancy has no skills req
	if(!isset($vacancy->skills ) || 0 == count($vacancy->skills)){
		return true;
	}

	$checkLanguages = [];
	foreach($vacancy->skills AS $k => $v){
		/*var_dump($v);
		echo"<br/>";
		var_dump($candidate->skills->languages);
		echo "<br/>";
		var_dump(array_search($v, $candidate->skills->languages));
		echo "<br/>";*/
		if(FALSE !== array_search($v, $candidate->skills->languages)){
			$checkLanguages[] = $v;
		}
	}

	/*echo("count langs: " . count($checkLanguages));
	echo(" count vacancy: " .count($vacancy->skills));
	echo "<br/> check == vacancy: ";
	var_dump(count($vacancy->skills) == count($checkLanguages));
	echo "<br/> knowsall: ";
	var_dump( $knowsAll);
	echo"<br/>";*/

	//if $knowsAll is false, and $checkLanguages has 1 or more element, return true.
	if(FALSE == $knowsAll && 1 <= count($checkLanguages) ){
		return true;
	}

	//if $knowsAll is true, and $checklanguages has the same number of elements as $vacancy->skills, return true
	if(TRUE == $knowsAll && count($vacancy->skills) === count($checkLanguages) ){
		return true;
	}

	//default to false.
	return false;
}

$earn_over_40k = [];
$between20_30_and_php_or_js = [];
$less_than_42k_ruby_c = [];
$knows_go = [];
$knows_one_of_many_languages = [];

foreach ($candidates as $k => $v) {
	//gets candidates that earn over 40k
	if ($v->candidate->salary > $vacancy->salaryRange[0]) {
		$earn_over_40k[] = $v;
	}
	
	if($v->candidate->salary > $vacancy2->getMinSalary()
		&& $v->candidate->salary <= $vacancy2->getMaxSalary()
		&& checkLanguages($v->candidate, $vacancy2, FALSE)
	){
		$between20_30_and_php_or_js[] = $v;
	}
	if($v->candidate->salary <= $vacancy3->getMaxSalary()
		&& checkLanguages($v->candidate, $vacancy3, TRUE)
	){
		$less_than_42k_ruby_c[] = $v;
	}

	if(checkLanguages($v->candidate, $vacancy4)){
		$knows_go[] = $v;
	}	

	if(checkLanguages($v->candidate, $vacancy5)){
		$knows_one_of_many_languages[] = $v;
	}

}
var_dump($earn_over_40k);
echo "<br/><br/>";
var_dump($between20_30_and_php_or_js);
echo "<br/><br/>";
var_dump($less_than_42k_ruby_c);
echo "<br/><br/>";
var_dump($knows_go);
var_dump($knows_one_of_many_languages);

// get candidates that earn between 20 to 30k and know PHP or JS
// get candidates that earn less than 42k and know Ruby and C
// get candidates that know go
// get candidates that know one of these languages (elixir, erlang, f#, haskell, lisp)

?>

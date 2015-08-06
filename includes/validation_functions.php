<?php 
	function has_presence($value) {
		return isset($value) && $value !== "";
	}
	function has_max_length($value, $max) {
		return strlen($value) <= $max;
	}
	function has_min_length($value, $min) {
		return strlen($value) >= $min;
	}
	function has_exact_length($value, $other) {
		return strlen($value) === $other;
	}
	function has_presence_in($value, $set) {
		return in_array($value, $set);
	}
?>
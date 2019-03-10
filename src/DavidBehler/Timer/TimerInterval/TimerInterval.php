<?php
	namespace DavidBehler\Timer\TimerInterval;

	/**
	 * TimeInterval Interface
	 */
	interface TimerInterval
	{

		/**
		 * Start the time interval
		 */
		public function start();

		/**
		 * Stop the time interval
		 */
		public function stop();

		/**
		 * Get the duration of the time interval. Use current time if no end time set
		 *
		 * @param bool 	$getSeconds Whether to get seconds with microseconds after the decimal point
		 * @param int 	$precision 	The precision of the returned duration
		 *
		 * @return int
		 */
		public function getDuration($getSeconds = false, $precision = 3);

		/**
		 * Get an array with detailed data for this interval
		 *
		 * @param bool 	$getSeconds Whether to get seconds with microseconds after the decimal point
		 * @param int 	$precision 	The precision of the returned duration
		 *
		 * @return array
		 */
		public function getReport($getSeconds = false, $precision = 3);

		/**
		 * Get the current time
		 */
		public function getTime();

		/**
		 * Format the duration
		 *
		 * @param int 	$microseconds
		 * @param bool 	$getSeconds Whether to get seconds with microseconds after the decimal point
		 * @param int 	$precision 	The precision of the returned duration
		 *
		 * @return int
		 */
		public function formatDuration($microseconds, $getSeconds = false, $precision = 3);
	}
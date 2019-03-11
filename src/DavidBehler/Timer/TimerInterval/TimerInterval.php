<?php
	declare(strict_types = 1);

	namespace DavidBehler\Timer\TimerInterval;

	/**
	 * TimeInterval Interface
	 */
	interface TimerInterval
	{

		/**
		 * Start the time interval
		 */
		public function start(): TimerInterval;

		/**
		 * Stop the time interval
		 */
		public function stop(): TimerInterval;

		/**
		 * Get the duration of the time interval in seconds. Use current time if no end time set
		 *
		 * @param int 	$precision 	The precision of the returned duration
		 *
		 * @return int
		 */
		public function getDuration(int $precision = 6): float;

		/**
		 * Get an array with detailed data for this interval
		 *
		 * @param int 	$precision 	The precision of the returned duration
		 *
		 * @return array
		 */
		public function getReport(int $precision = 6): array;
	}
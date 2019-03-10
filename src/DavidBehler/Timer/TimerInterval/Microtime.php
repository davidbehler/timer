<?php
	namespace DavidBehler\Timer\TimerInterval;

	use DavidBehler\Timer\TimerInterval\TimerInterval;
	use DavidBehler\Timer\TimerIntervalException;

	class Microtime implements TimerInterval
	{
		private $start;
		private $end;

		public function __construct($autostart = true)
		{
			if($autostart) {
				$this->start();
			}
		}

		public function start()
		{
			$this->start = $this->getTime();
		}

		public function stop()
		{
			if($this->start) {
				$this->end = $this->getTime();
			} else {
				throw new TimerIntervalException('Interval was not started');
			}
		}

		public function getDuration($getSeconds = false, $precision = 3)
		{
			if($this->start) {
				if($this->end) {
					$compare = $this->end;
				} else {
					$compare = $this->getTime();
				}

				$microseconds = round(($compare - $this->start) * 1000 * 1000, 0);

				return $this->formatDuration($microseconds, $getSeconds, $precision);
			} else {
				throw new TimerIntervalException('Interval was not started');
			}
		}

		public function getReport($getSeconds = false, $precision = 3)
		{
			$start = \DateTime::createFromFormat('U.u', $this->start);

			$report = array(
				'start' => $start->format('Y-m-d H:i:s.u'),
				'duration' => $this->getDuration(),
				'end' => null
			);

			if($this->end) {
				$end = \DateTime::createFromFormat('U.u', $this->end);
				$report['end'] = $end->format('Y-m-d H:i:s.u');
			}

			return $report;
		}

		public function getTime()
		{
			return microtime(true);
		}

		public function formatDuration($microseconds, $getSeconds = false, $precision = 3)
		{
			if($getSeconds) {
				$duration = $microseconds / 1000;
			} else {
				$duration = $microseconds;
			}

			return round($microseconds, $precision);
		}
	}
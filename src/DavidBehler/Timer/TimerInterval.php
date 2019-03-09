<?php
	namespace DavidBehler\Timer;

	use DavidBehler\Timer\TimerIntervalException;

	class TimerInterval
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
			$this->start = $this->getDateTime();
		}

		public function stop()
		{
			if($this->start) {
				$this->end = $this->getDateTime();
			} else {
				throw new TimerIntervalException('Interval was not started');
			}
		}

		public function getDuration()
		{
			if($this->start) {
				if($this->end) {
					$compare = $this->end;
				} else {
					$compare = $this->getDateTime();
				}

				$interval = $this->start->diff($compare);

				$seconds = $compare->getTimestamp() - $this->start->getTimestamp();

				return $seconds * 1000 + $interval->format('%f');
			} else {
				throw new TimerIntervalException('Interval was not started');
			}
		}

		private function getDateTime()
		{
			return new \DateTime;
		}
	}
<?php
	namespace DavidBehler\Timer;

	use DavidBehler\Timer\TimerIntervalException;

	class TimerIntervalMicrotime
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
			$this->start = $this->getMicrotime();
		}

		public function stop()
		{
			if($this->start) {
				$this->end = $this->getMicrotime();
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
					$compare = $this->getMicrotime();
				}

				return round(($compare - $this->start) * 1000 * 1000, 0);
			} else {
				throw new TimerIntervalException('Interval was not started');
			}
		}

		private function getMicrotime()
		{
			return microtime(true);
		}
	}
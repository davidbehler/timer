<?php
	namespace DavidBehler\Timer;

	use DavidBehler\Timer\TimerInterval\DateTime as TimerIntervalDateTime;
	use DavidBehler\Timer\TimerInterval\Microtime as TimerIntervalMicrotime;
	use DavidBehler\Timer\TimerException;

	class Timer
	{
		private $intervals = array();
		private $status = 'stopped';
		private $intervalType = 'datetime';

		public function __construct($autostart = true, $intervalType = 'datetime')
		{
			$this->intervalType = $intervalType;

			if($autostart) {
				$this->start();
			}
		}

		public function start()
		{
			if($this->status == 'running') {
				throw new TimerException('Timer is already running');
			} else {
				if($this->status == 'stopped') {
					$this->intervals = array();
				}

				switch($this->intervalType) {
					case 'datetime':
						$this->intervals[] = new TimerIntervalDateTime;
					break;
					case 'microtime':
						$this->intervals[] = new TimerIntervalMicrotime;
					break;
					default:
						throw new TimerException('Unknown timer interval type: '.$this->intervalType);
					break;
				}

				$this->status = 'running';
			}

			return $this;
		}

		public function stop()
		{
			if($this->status == 'stopped') {
				throw new TimerException('Timer is not running');
			} else {
				$this->intervals[count($this->intervals) - 1]->stop();

				$this->status = 'stopped';
			}

			return $this;
		}

		public function pause()
		{
			if($this->status == 'running') {
				$this->intervals[count($this->intervals) - 1]->stop();

				$this->status = 'paused';
			} else {
				throw new TimerException('Timer is not running');
			}

			return $this;
		}

		public function restart()
		{
			$this->intervals = array();

			$this->status = 'stopped';

			$this->start();
		}

		public function getDuration($getSeconds = false, $precision = 3)
		{
			$duration = 0;

			foreach($this->intervals as $interval) {
				$duration += $interval->getDuration($getSeconds, $precision);
			}

			return $duration;
		}

		public function getReport($getSeconds = false, $precision = 3)
		{
			$report = array(
				'duration' => $this->getDuration($getSeconds, $precision),
				'status' => $this->status,
				'intervalType' => $this->intervalType,
				'intervals' => array()
			);

			foreach($this->intervals as $interval) {
				$report['intervals'][] = $interval->getReport($getSeconds, $precision);
			}

			return $report;
		}
	}
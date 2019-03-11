<?php
	declare(strict_types = 1);

	namespace DavidBehler\Timer;

	use DavidBehler\Timer\TimerInterval\DateTime as TimerIntervalDateTime;
	use DavidBehler\Timer\TimerInterval\Microtime as TimerIntervalMicrotime;
	use DavidBehler\Timer\TimerException;

	class Timer
	{
		const MICROTIME_TYPE = 'microtime';
		const DATETIME_TYPE = 'datetime';

		private $intervals = array();
		private $status = 'stopped';
		private $intervalType = Timer::DATETIME_TYPE;

		public function __construct(bool $autostart = true, string $intervalType = Timer::DATETIME_TYPE)
		{
			if(!in_array($intervalType, array(Timer::DATETIME_TYPE, Timer::MICROTIME_TYPE))) {
				throw new TimerException('Unknown timer interval type: '.$intervalType);
			}

			$this->intervalType = $intervalType;

			if($autostart) {
				$this->start();
			}
		}

		public function start(): Timer
		{
			if($this->status == 'running') {
				throw new TimerException('Timer is already running');
			}

			if($this->status == 'stopped') {
				$this->intervals = array();
			}

			switch($this->intervalType) {
				case Timer::DATETIME_TYPE:
					$this->intervals[] = new TimerIntervalDateTime;
				break;
				case Timer::MICROTIME_TYPE:
					$this->intervals[] = new TimerIntervalMicrotime;
				break;
			}

			$this->status = 'running';

			return $this;
		}

		public function stop(): Timer
		{
			if($this->status == 'stopped') {
				throw new TimerException('Timer is not running');
			}

			$this->intervals[count($this->intervals) - 1]->stop();

			$this->status = 'stopped';

			return $this;
		}

		public function pause(): Timer
		{
			if($this->status != 'running') {
				throw new TimerException('Timer is not running');
			}

			$this->intervals[count($this->intervals) - 1]->stop();

			$this->status = 'paused';

			return $this;
		}

		public function restart(): Timer
		{
			$this->intervals = array();

			$this->status = 'stopped';

			return $this->start();
		}

		public function getDuration(int $precision = 6): float
		{
			$duration = 0;

			foreach($this->intervals as $interval) {
				$duration += $interval->getDuration($precision);
			}

			return $duration;
		}

		public function getReport(int $precision = 6): array
		{
			$report = array(
				'duration' => $this->getDuration($precision),
				'status' => $this->status,
				'intervalType' => $this->intervalType,
				'intervals' => array()
			);

			foreach($this->intervals as $interval) {
				$report['intervals'][] = $interval->getReport($precision);
			}

			return $report;
		}
	}
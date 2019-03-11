<?php
	declare(strict_types = 1);

	namespace DavidBehler\Timer;

	use DavidBehler\Timer\Timer;
	use DavidBehler\Timer\TimerCollectionException;

	class TimerCollection
	{
		private $timers = [];
		private $intervalType = 'datetime';

		public function __construct(string $intervalType = 'datetime')
		{
			$this->intervalType = $intervalType;
		}

		public function start($labels, bool $autostart = true): TimerCollection
		{
			if(!is_array($labels)) {
				$labels = [$labels];
			}

			foreach($labels as $label) {
				if($this->timerExists($label)) {
					throw new TimerCollectionException('Timer already exists');
				}

				$this->timers[$label] = new Timer($autostart, $this->intervalType);
			}

			return $this;
		}

		public function stop($labels): TimerCollection
		{
			if(!is_array($labels)) {
				$labels = [$labels];
			}

			foreach($labels as $label) {
				$timer = $this->getTimer($label);

				$timer->stop();
			}

			return $this;
		}

		public function pause($labels): TimerCollection
		{
			if(!is_array($labels)) {
				$labels = [$labels];
			}

			foreach($labels as $label) {
				$timer = $this->getTimer($label);

				$timer->pause();
			}

			return $this;
		}

		public function restart($labels): TimerCollection
		{
			if(!is_array($labels)) {
				$labels = [$labels];
			}

			foreach($labels as $label) {
				$timer = $this->getTimer($label);

				$timer->restart();
			}

			return $this;
		}

		public function getDuration(string $label, int $precision = 6): float
		{
			$timer = $this->getTimer($label);

			return $timer->getDuration($precision);
		}

		public function getDurations(array $labels, int $precision = 6): array
		{
			$durations = [];

			foreach($labels as $label) {
				$timer = $this->getTimer($label);

				$durations[$label] = $timer->getDuration($precision);
			}

			return $durations;
		}

		public function getReport(string $label, int $precision = 6): array
		{
			$timer = $this->getTimer($label);

			return $timer->getReport($precision);
		}

		public function getReports($labels = null, int $precision = 6): array
		{
			if(!$labels) {
				$labels = array_keys($this->timers);
			}

			$report = [
				'timers' => []
			];

			foreach($labels as $label) {
				$timer = $this->getTimer($label);

				$report['timers'][$label] = $timer->getReport();
			}

			return $report;
		}

		public function getTimer(string $label): Timer
		{
			if(!$this->timerExists($label)) {
				throw new TimerCollectionException('Timer does not exist');
			}

			return $this->timers[$label];
		}

		public function getTimers(bool $labelsOnly = false): array
		{
			if($labelsOnly) {
				return array_keys($this->timers);
			} else {
				return $this->timers;
			}
		}

		protected function timerExists(string $label): bool
		{
			return isset($this->timers[$label]);
		}
	}
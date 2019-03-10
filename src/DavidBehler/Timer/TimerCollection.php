<?php
	namespace DavidBehler\Timer;

	use DavidBehler\Timer\Timer;
	use DavidBehler\Timer\TimerCollectionException;

	class TimerCollection
	{
		private $timers = array();
		private $intervalType = 'datetime';

		public function __construct($intervalType = 'datetime')
		{
			$this->intervalType = $intervalType;
		}

		public function start($labels, $autostart = true)
		{
			if(!is_array($labels)) {
				$labels = array($labels);
			}

			foreach($labels as $label) {
				if($this->timerExists($label)) {
					throw new TimerCollectionException('Timer already exists');
				} else {
					$this->timers[$label] = new Timer($autostart, $this->intervalType);
				}
			}

			return $this;
		}

		public function stop($labels)
		{
			if(!is_array($labels)) {
				$labels = array($labels);
			}

			foreach($labels as $label) {
				if($this->timerExists($label)) {
					$this->timers[$label]->stop();
				} else {
					throw new TimerCollectionException('Timer does not exist');
				}
			}

			return $this;
		}

		public function pause($labels)
		{
			if(!is_array($labels)) {
				$labels = array($labels);
			}

			foreach($labels as $label) {
				if($this->timerExists($label)) {
					$this->timers[$label]->pause();
				} else {
					throw new TimerCollectionException('Timer does not exist');
				}
			}

			return $this;
		}

		public function restart($labels)
		{
			if(!is_array($labels)) {
				$labels = array($labels);
			}

			foreach($labels as $label) {
				if($this->timerExists($label)) {
					$this->timers[$label]->restart();
				} else {
					throw new TimerCollectionException('Timer does not exist');
				}
			}

			return $this;
		}

		public function getDuration($labels, $getSeconds = false, $precision = 3)
		{
			if(!is_array($labels)) {
				$labels = array($labels);
			}

			if(count($labels) == 1) {
				$label = reset($labels);

				if($this->timerExists($label)) {
					return $this->timers[$label]->getDuration($getSeconds, $precision);
				} else {
					throw new TimerCollectionException('Timer does not exist');
				}
			} else {
				$durations = array();

				foreach($labels as $label) {
					if($this->timerExists($label)) {
						$durations[$label] = $this->timers[$label]->getDuration($getSeconds, $precision);
					} else {
						throw new TimerCollectionException('Timer does not exist');
					}
				}

				return $durations;
			}
		}

		public function getReport($labels = null, $getSeconds = false, $precision = 3)
		{
			if(!$labels) {
				$labels = array_keys($this->timers);
			}

			if(count($labels) == 1) {
				$label = reset($labels);

				if($this->timerExists($label)) {
					return $this->timers[$label]->getReport($getSeconds, $precision);
				}
			} else {
				$report = array(
					'timers' => array()
				);

				foreach($this->timers as $label => $timer) {
					$report['timers'][$label] = $timer->getReport();
				}
			}

			return $report;
		}

		public function getTimers($labelsOnly = false)
		{
			if($labelsOnly) {
				return array_keys($this->timers);
			} else {
				return $this->timers;
			}
		}

		protected function timerExists($label)
		{
			return isset($this->timers[$label]);
		}
	}
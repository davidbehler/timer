<?php
	declare(strict_types = 1);

	namespace DavidBehler\Timer\TimerInterval;

	use DavidBehler\Timer\TimerInterval\TimerInterval;
	use DavidBehler\Timer\TimerIntervalException;

	class Microtime implements TimerInterval
	{
		private $start;
		private $end;

		public function __construct(bool $autostart = true)
		{
			if($autostart) {
				$this->start();
			}
		}

		public function start(): TimerInterval
		{
			$this->start = $this->getTime();

			return $this;
		}

		public function stop(): TimerInterval
		{
			if(!$this->start) {
				throw new TimerIntervalException('Interval was not started');

			}

			$this->end = $this->getTime();

			return $this;
		}

		public function getDuration(int $precision = 6): float
		{
			if(!$this->start) {
				throw new TimerIntervalException('Interval was not started');
			}

			if($this->end) {
				$compare = $this->end;
			} else {
				$compare = $this->getTime();
			}

			return round($compare - $this->start, $precision);
		}

		public function getReport(int $precision = 6): array
		{
			$start = \DateTime::createFromFormat('U.u', (string) $this->start);

			$report = array(
				'start' => $start->format('Y-m-d H:i:s.u'),
				'duration' => $this->getDuration(),
				'end' => null
			);

			if($this->end) {
				$end = \DateTime::createFromFormat('U.u', (string) $this->end);
				$report['end'] = $end->format('Y-m-d H:i:s.u');
			}

			return $report;
		}

		public function getTime(): float
		{
			return microtime(true);
		}
	}
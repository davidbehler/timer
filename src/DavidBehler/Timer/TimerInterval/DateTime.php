<?php
	declare(strict_types = 1);

	namespace DavidBehler\Timer\TimerInterval;

	use DavidBehler\Timer\TimerInterval\TimerInterval;
	use DavidBehler\Timer\TimerIntervalException;

	class DateTime implements TimerInterval
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

			$interval = $this->start->diff($compare);

			$seconds = $compare->getTimestamp() - $this->start->getTimestamp();

			return round($seconds + (int) $interval->format('%f') / 1000 / 1000, $precision);
		}

		public function getReport(int $precision = 6): array
		{
			$report = array(
				'start' => $this->start->format('Y-m-d H:i:s.u'),
				'duration' => $this->getDuration(),
				'end' => null
			);

			if($this->end) {
				$report['end'] = $this->end->format('Y-m-d H:i:s.u');
			}

			return $report;
		}

		public function getTime(): \DateTimeImmutable
		{
			return new \DateTimeImmutable;
		}
	}
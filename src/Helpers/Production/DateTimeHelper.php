<?php
namespace LaravelRocket\Foundation\Helpers\Production;

use Carbon\Carbon;
use LaravelRocket\Foundation\Helpers\DateTimeHelperInterface;

class DateTimeHelper implements DateTimeHelperInterface
{
    const PRESENTATION_TIME_ZONE_SESSION_KEY = 'presentation-time-zone';

    public function setPresentationTimeZone(string $timezone = null)
    {
        session()->put(static::PRESENTATION_TIME_ZONE_SESSION_KEY, $timezone);
    }

    public function clearPresentationTimeZone()
    {
        session()->remove(static::PRESENTATION_TIME_ZONE_SESSION_KEY);
    }

    public function dateTime(string $dateTimeStr, \DateTimeZone $timezoneFrom = null, \DateTimeZone $timezoneTo = null): Carbon
    {
        $timezoneFrom = empty($timezoneFrom) ? $this->timezoneForPresentation() : $timezoneFrom;
        $timezoneTo   = empty($timezoneTo) ? $this->timezoneForStorage() : $timezoneTo;

        return Carbon::parse($dateTimeStr, $timezoneFrom)->setTimezone($timezoneTo);
    }

    public function dateTimeWithFormat(string $format, string $dateTimeStr, ?\DateTimeZone $timezoneFrom = null, ?\DateTimeZone $timezoneTo = null): Carbon {
        $timezoneFrom = empty($timezoneFrom) ? $this->timezoneForPresentation() : $timezoneFrom;
        $timezoneTo   = empty($timezoneTo) ? $this->timezoneForStorage() : $timezoneTo;

        return Carbon::createFromFormat($format, $dateTimeStr, $timezoneFrom)->setTimezone($timezoneTo);
    }

    public function timezoneForPresentation(): \DateTimeZone
    {
        return new \DateTimeZone($this->getPresentationTimeZoneString());
    }

    public function getPresentationTimeZoneString(): string
    {
        $timezone = session()->get(static::PRESENTATION_TIME_ZONE_SESSION_KEY);
        if (empty($timezone)) {
            $timezone = config('app.default_presentation_timezone', 'UTC');
        }

        return $timezone;
    }

    public function timezoneForStorage(): \DateTimeZone
    {
        return new \DateTimeZone(config('app.timezone'));
    }

    public function fromTimestamp(int $timeStamp, \DateTimeZone $timezone = null): Carbon
    {
        $timezone = empty($timezone) ? $this->timezoneForStorage() : $timezone;

        $datetime = Carbon::now($timezone);
        $datetime->setTimestamp($timeStamp);

        return $datetime;
    }

    public function formatDate(\DateTime $dateTime, \DateTimeZone $timezone = null): string
    {
        $viewDateTime = clone $dateTime;
        $timezone     = empty($timezone) ? $this->timezoneForPresentation() : $timezone;
        $viewDateTime->setTimeZone($timezone);

        return $viewDateTime->format('Y-m-d');
    }

    public function formatTime(\DateTime $dateTime, \DateTimeZone $timezone = null): string
    {
        $viewDateTime = clone $dateTime;
        $timezone     = empty($timezone) ? $this->timezoneForPresentation() : $timezone;
        $viewDateTime->setTimeZone($timezone);

        return $viewDateTime->format('H:i');
    }

    public function formatDateTime(?\DateTime $dateTime, string $format = 'Y-m-d H:i', \DateTimeZone $timezone = null): string
    {
        if (empty($dateTime)) {
            $dateTime = $this->now();
        }
        $viewDateTime = clone $dateTime;
        $timezone     = empty($timezone) ? $this->timezoneForPresentation() : $timezone;
        $viewDateTime->setTimeZone($timezone);

        return $viewDateTime->format($format);
    }

    public function now(\DateTimeZone $timezone = null): Carbon
    {
        $timezone = empty($timezone) ? $this->timezoneForStorage() : $timezone;

        return Carbon::now($timezone);
    }

    public function getDateFormatByLocale(string $locale = null): string
    {
        return trans('config.datetime.format', 'Y-m-d');
    }

    public function convertToStorageDateTime(string $dateTimeString): \DateTime
    {
        $viewDateTime = new Carbon($dateTimeString, $this->timezoneForPresentation());
        $dateTime     = clone $viewDateTime;
        $dateTime->setTimeZone($this->timezoneForStorage());

        return $dateTime;
    }

    public function changeToPresentationTimeZone(\DateTime $dateTime): \DateTime
    {
        return $dateTime->setTimezone($this->timezoneForPresentation());
    }

    public function getTimeDifferenceStringFromTimeZone(\DateTimeZone|string $timezone): string
    {
        if (!($timezone instanceof \DateTimeZone)) {
            if (!is_string($timezone)) {
                $timezone = '';
            }
            try {
                $timezone = new \DateTimeZone($timezone);
            } catch (\Exception $e) {
                $timezone = new \DateTimeZone('UTC');
            }
        }

        return $this->now($timezone)->format('P');
    }
}

<?php
namespace LaravelRocket\Foundation\Helpers;

use Carbon\Carbon;

interface DateTimeHelperInterface
{
    /**
     * Get default TimeZone for storage.
     *
     * @return \DateTimeZone
     */
    public function timezoneForStorage(): \DateTimeZone;

    /**
     * @param string|null $timezone
     */
    public function setPresentationTimeZone(string $timezone = null): void;

    /**
     */
    public function clearPresentationTimeZone(): void;

    /**
     * @return string
     */
    public function getPresentationTimeZoneString(): string;

    /**
     * Get default TimeZone for showing on the view.
     *
     * @return \DateTimeZone
     */
    public function timezoneForPresentation(): \DateTimeZone;

    /**
     * Get Current DateTime.
     *
     * @param \DateTimeZone|null $timezone
     *
     * @return Carbon
     */
    public function now(\DateTimeZone $timezone = null): Carbon;

    /**
     * Convert Unix TimeStamp to Carbon(DateTime).
     *
     * @param int $timeStamp
     * @param \DateTimeZone|null $timezone
     *
     * @return Carbon
     */
    public function fromTimestamp(int $timeStamp, \DateTimeZone $timezone = null): Carbon;

    /**
     * Get DateTime Object from string.
     *
     * @param string $dateTimeStr
     * @param \DateTimeZone|null $timezoneFrom
     * @param \DateTimeZone|null $timezoneTo
     *
     * @return Carbon
     */
    public function dateTime(string $dateTimeStr, \DateTimeZone $timezoneFrom = null, \DateTimeZone $timezoneTo = null): Carbon;

    /**
     * Get DateTime Object from string.
     *
     * @param string $format
     * @param string $dateTimeStr
     * @param \DateTimeZone|null $timezoneFrom
     * @param \DateTimeZone|null $timezoneTo
     *
     * @return Carbon
     */
    public function dateTimeWithFormat(string $format, string $dateTimeStr, ?\DateTimeZone $timezoneFrom = null, ?\DateTimeZone $timezoneTo = null): Carbon;

    /**
     * @param \DateTime $dateTime
     * @param \DateTimeZone|null $timezone
     *
     * @return string
     */
    public function formatDate(\DateTime $dateTime, ?\DateTimeZone $timezone = null): string;

    /**
     * @param \DateTime $dateTime
     * @param \DateTimeZone|null $timezone
     *
     * @return string
     */
    public function formatTime(\DateTime $dateTime, ?\DateTimeZone $timezone = null): string;

    /**
     * @param \DateTime|null $dateTime
     * @param string $format
     * @param \DateTimeZone|null $timezone
     *
     * @return string
     */
    public function formatDateTime(?\DateTime $dateTime, string $format = 'Y-m-d H:i', ?\DateTimeZone $timezone = null): string;

    /**
     * @param string|null $locale
     *
     * @return string
     */
    public function getDateFormatByLocale(string $locale = null): string;

    /**
     * @param string $dateTimeString
     *
     * @return \DateTime
     */
    public function convertToStorageDateTime(string $dateTimeString): \DateTime;

    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTime
     */
    public function changeToPresentationTimeZone(\DateTime $dateTime): \DateTime;

    /**
     * @param \DateTimeZone|string $timezone
     *
     * @return string
     */
    public function getTimeDifferenceStringFromTimeZone(\DateTimeZone|string $timezone): string;
}

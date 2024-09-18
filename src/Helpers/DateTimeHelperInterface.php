<?php

namespace LaravelRocket\Foundation\Helpers;

use Carbon\Carbon;

interface DateTimeHelperInterface
{
    /**
     * Get default TimeZone for storage.
     */
    public function timezoneForStorage(): \DateTimeZone;

    public function setPresentationTimeZone(?string $timezone = null): void;

    public function clearPresentationTimeZone(): void;

    public function getPresentationTimeZoneString(): string;

    /**
     * Get default TimeZone for showing on the view.
     */
    public function timezoneForPresentation(): \DateTimeZone;

    /**
     * Get Current DateTime.
     */
    public function now(?\DateTimeZone $timezone = null): Carbon;

    /**
     * Convert Unix TimeStamp to Carbon(DateTime).
     */
    public function fromTimestamp(int $timeStamp, ?\DateTimeZone $timezone = null): Carbon;

    /**
     * Get DateTime Object from string.
     */
    public function dateTime(string $dateTimeStr, ?\DateTimeZone $timezoneFrom = null, ?\DateTimeZone $timezoneTo = null): Carbon;

    /**
     * Get DateTime Object from string.
     */
    public function dateTimeWithFormat(string $format, string $dateTimeStr, ?\DateTimeZone $timezoneFrom = null, ?\DateTimeZone $timezoneTo = null): Carbon;

    public function formatDate(\DateTime $dateTime, ?\DateTimeZone $timezone = null): string;

    public function formatTime(\DateTime $dateTime, ?\DateTimeZone $timezone = null): string;

    public function formatDateTime(?\DateTime $dateTime, string $format = 'Y-m-d H:i', ?\DateTimeZone $timezone = null): string;

    public function getDateFormatByLocale(?string $locale = null): string;

    public function convertToStorageDateTime(string $dateTimeString): \DateTime;

    public function changeToPresentationTimeZone(\DateTime $dateTime): \DateTime;

    public function getTimeDifferenceStringFromTimeZone(\DateTimeZone|string $timezone): string;
}

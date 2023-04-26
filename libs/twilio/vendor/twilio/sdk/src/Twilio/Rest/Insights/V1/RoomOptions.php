<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Insights\V1;

use Twilio\Options;
use Twilio\Values;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
abstract class RoomOptions {
    /**
     * @param string[] $roomType Type of room.
     * @param string[] $codec Codecs used by participants in the room.
     * @param string $roomName Room friendly name.
     * @param \DateTime $createdAfter Only read rooms that started on or after this
     *                                ISO 8601 timestamp.
     * @param \DateTime $createdBefore Only read rooms that started before this ISO
     *                                 8601 timestamp.
     * @return ReadRoomOptions Options builder
     */
    public static function read(array $roomType = Values::ARRAY_NONE, array $codec = Values::ARRAY_NONE, string $roomName = Values::NONE, \DateTime $createdAfter = Values::NONE, \DateTime $createdBefore = Values::NONE): ReadRoomOptions {
        return new ReadRoomOptions($roomType, $codec, $roomName, $createdAfter, $createdBefore);
    }
}

class ReadRoomOptions extends Options {
    /**
     * @param string[] $roomType Type of room.
     * @param string[] $codec Codecs used by participants in the room.
     * @param string $roomName Room friendly name.
     * @param \DateTime $createdAfter Only read rooms that started on or after this
     *                                ISO 8601 timestamp.
     * @param \DateTime $createdBefore Only read rooms that started before this ISO
     *                                 8601 timestamp.
     */
    public function __construct(array $roomType = Values::ARRAY_NONE, array $codec = Values::ARRAY_NONE, string $roomName = Values::NONE, \DateTime $createdAfter = Values::NONE, \DateTime $createdBefore = Values::NONE) {
        $this->options['roomType'] = $roomType;
        $this->options['codec'] = $codec;
        $this->options['roomName'] = $roomName;
        $this->options['createdAfter'] = $createdAfter;
        $this->options['createdBefore'] = $createdBefore;
    }

    /**
     * Type of room. Can be `go`, `peer_to_peer`, `group`, or `group_small`.
     *
     * @param string[] $roomType Type of room.
     * @return $this Fluent Builder
     */
    public function setRoomType(array $roomType): self {
        $this->options['roomType'] = $roomType;
        return $this;
    }

    /**
     * Codecs used by participants in the room. Can be `VP8`, `H264`, or `VP9`.
     *
     * @param string[] $codec Codecs used by participants in the room.
     * @return $this Fluent Builder
     */
    public function setCodec(array $codec): self {
        $this->options['codec'] = $codec;
        return $this;
    }

    /**
     * Room friendly name.
     *
     * @param string $roomName Room friendly name.
     * @return $this Fluent Builder
     */
    public function setRoomName(string $roomName): self {
        $this->options['roomName'] = $roomName;
        return $this;
    }

    /**
     * Only read rooms that started on or after this ISO 8601 timestamp.
     *
     * @param \DateTime $createdAfter Only read rooms that started on or after this
     *                                ISO 8601 timestamp.
     * @return $this Fluent Builder
     */
    public function setCreatedAfter(\DateTime $createdAfter): self {
        $this->options['createdAfter'] = $createdAfter;
        return $this;
    }

    /**
     * Only read rooms that started before this ISO 8601 timestamp.
     *
     * @param \DateTime $createdBefore Only read rooms that started before this ISO
     *                                 8601 timestamp.
     * @return $this Fluent Builder
     */
    public function setCreatedBefore(\DateTime $createdBefore): self {
        $this->options['createdBefore'] = $createdBefore;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $options = \http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Insights.V1.ReadRoomOptions ' . $options . ']';
    }
}
<?php

namespace App\Entity;

class ParcSearch
{
    /**
     *
     * @var integer|null
     */
    private $distance;
    
    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var string|null
     */
    private $address;

    /**
     *
     * @return integer|null
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     *
     * @param integer $distance
     * @return ParcSearch
     */
    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
    
    /**
     *
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     *
     * @param float|null $lat
     * @return ParcSearch
     */
    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }
    
    /**
     *
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     *
     * @param float|null $lng
     * @return ParcSearch
     */
    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return ParcSearch
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }
}

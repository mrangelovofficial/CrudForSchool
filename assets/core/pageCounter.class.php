<?php

  require_once "db.class.php";

  Class PageCounter extends DB {
    private $pageCounter      = 0;
    private $pageCropOn       = 0;
    private $maxReachPage     = 0;
    private $maxReachNumber   = 0;
    private $countPeople      = 0;
    private $pageCounterCrop  = 0;

    // Init variables
    public function pageCounterSet($counter)
    {
      $this->pageCounter = intval($counter);
    }

    public function pageCounterGet()
    {
      return $this->pageCounter;
    }

    public function pageCounterCropSet()
    {
      $this->pageCounterCrop = $this->pageCounter + $this->pageCropOn;
    }

    public function pageCounterCropGet(){
      $this->pageCounterCropSet();
      return $this->pageCounterCrop;
    }

    public function pageCropOnSet($counter)
    {
      $this->pageCropOn = intval($counter);
    }

    public function pageCropOnGet()
    {
      return $this->pageCropOn;
    }

    public function dataCount($queryData)
    {
        return $this->countPeople = $queryData[0]->number;
    }

    public function maxReachNumberGet()
    {

      if($this->countPeople % $this->pageCropOn == 0)
      {
        $this->maxReachNumber = $this->countPeople;
      }
      else
      {
        $this->maxReachNumber = ceil($this->countPeople / $this->pageCropOn) * $this->pageCropOn;
      }
      return $this->maxReachNumber;
    }

    public function maxReachPageGet()
    {
        return $this->maxReachPage = $this->maxReachNumber / $this->pageCropOn;
    }

    public function checkNumber($parse)
    {
      $number = intval($parse);
      if( is_int ( $number ))
      {

        if( $number % $this->pageCropOn )
        {
          $this->pageCounterSet($number);
        }else
        {
          $calculateNumber = $number - ($number % $this->pageCropOn);
          $this->pageCounterSet( $calculateNumber );
        }

        if($number > $this->maxReachNumber - $this->pageCropOn)
        {
          $this->pageCounterSet( $this->maxReachNumber - $this->pageCropOn );
        }
        return $this->pageCounterGet();
      }

    }

  }

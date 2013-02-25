<?php

class IconImageResource extends ClassCore
{

    // VARIABLES


    private $empty = "image/icon/1x1.png";
    private $spinnerBar = "image/icon/spinner_bar.gif";
    private $spinnerCircle = "image/icon/spinner_circle.gif";
    private $facebook = "image/icon/facebook.png";
    private $google = "image/icon/google.png";
    private $favicon = "favicon.ico";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getSpinnerBar()
    {
        return $this->spinnerBar;
    }

    public function getSpinnerCircle()
    {
        return $this->spinnerCircle;
    }

    // /FUNCTIONS


    public function getEmpty()
    {
        return $this->empty;
    }

    /**
     * @return the $facebook
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @return the $google
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * @return the $facivon
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

}

?>
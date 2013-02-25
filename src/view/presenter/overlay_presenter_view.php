<?php

class OverlayPresenterView extends AbstractPresenterView
{

    // VARIABLES


    public static $OVERLAY_CANCEL = "overlay_cancel";
    public static $OVERLAY_OK = "overlay_ok";

    /**
     * @var string Id
     */
    private $id;
    /**
     * @var string Title
     */
    private $title;
    /**
     * @var array Buttons
     */
    private $buttons = array ();
    /**
     * @var AbstractXhtml
     */
    private $content;
    /**
     * @var string Fit to parent
     */
    private $fitToParent = "true";
    /**
     * @var boolean
     */
    private $fitWidth = false;
    /**
     * @var boolean
     */
    private $background = true;
    /**
     * @var boolean
     */
    private $bottom = false;
    /**
     * @var boolean
     */
    private $middle = false;
    /**
     * @var int
     */
    private $index = false;
    /**
     * @var string
     */
    private $class;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @return AbstractXhtml
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function setTitle( $title )
    {
        $this->title = $title;
    }

    public function getFitToParent()
    {
        return $this->fitToParent;
    }

    public function setFitToParent( $fitToParent )
    {
        $this->fitToParent = $fitToParent;
    }

    /**
     * @return boolean
     */
    public function isBackground()
    {
        return $this->background;
    }

    /**
     * @param boolean $background
     */
    public function setBackground( $background )
    {
        $this->background = $background;
    }

    /**
     * @return boolean
     */
    public function isBottom()
    {
        return $this->bottom;
    }

    /**
     * @param boolean $bottom
     */
    public function setBottom( $bottom )
    {
        $this->bottom = $bottom;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex( $index )
    {
        $this->index = $index;
    }

    public function isFitWidth()
    {
        return $this->fitWidth;
    }

    public function setFitWidth( $fitWidth )
    {
        $this->fitWidth = $fitWidth;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass( string $class )
    {
        $this->class = $class;
    }

    /**
     * @return boolean
     */
    public function isMiddle()
    {
        return $this->middle;
    }

    /**
     * @param boolean $middle
     */
    public function setMiddle( boolean $middle )
    {
        $this->middle = $middle;
    }

    // ... /GETTERS/SETTERS


    // ... ADD


    /**
     * @param AbstractXhtml $button
     */
    public function addButton( AbstractXhtml $button )
    {
        $this->buttons[] = $button;
    }

    /**
     * @param AbstractXhtml $content
     */
    public function addContent( AbstractXhtml $content )
    {
        $this->content[] = $content;
    }

    // ... ADD


    public function draw( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->class_( "overlay_wrapper", Resource::css()->getHide() )->id(
                sprintf( "%s_overlay", $this->getId() ) );
        if ( !$this->isBackground() )
            $wrapper->attr( "data-background", "false" );
        if ( $this->isBottom() )
            $wrapper->attr( "data-bottom", "true" );
        if ( $this->isMiddle() )
            $wrapper->attr( "data-middle", "true" );
        if ( $this->getIndex() )
            $wrapper->style( sprintf( "z-index: %d;", $this->getIndex() ) );
//         if ( $this->isFitWidth() )
//             $wrapper->attr( "data-fitparent-width", $this->getFitToParent() );
//         else
//             $wrapper->attr( "data-fitparent", $this->getFitToParent() );
        if ( $this->getClass() )
            $wrapper->addClass( $this->getClass() );
        $overlay = Xhtml::div()->class_( "overlay" );

        $header = Xhtml::div()->class_( "overlay_header" );
        $isHeader = $this->getTitle() || $this->getButtons();
        $headerTitle = Xhtml::div( $this->getTitle() )->class_( "overlay_header_title" );

        $headerButtons = Xhtml::div()->class_( "overlay_header_buttons_container" );
        foreach ( $this->getButtons() as $i => $button )
        {
            if ( $i > 0 )
                $headerButtons->addContent(
                        Xhtml::div( Xhtml::img( Resource::image()->icon()->getEmpty() ) )->class_( "spacer" ) );
            $headerButtons->addContent( $button );
        }

        $header->addContent( $headerTitle );
        $header->addContent( Xhtml::div( $headerButtons )->class_( "overlay_header_buttons" ) );

        $content = Xhtml::div( implode( "", $this->getContent() ) )->class_( "overlay_content" );

        if ( $isHeader )
            $overlay->addContent( $header );
        $overlay->addContent( $content );
        $wrapper->addContent( Xhtml::div( $overlay ) );
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>
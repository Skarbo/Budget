<?php

class TabsPresenterView extends AbstractPresenterView
{

    // VARIABLES


    private $id = null;
    private $tabs = array ();
    private $content = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function setId( $id )
    {
        $this->id = $id;
    }

    public function addTab( $tabId, AbstractXhtml $tab, AbstractXhtml $content )
    {
        $tab->attr( "data-tab", $tabId );
        $content->attr( "data-tab-content", $tabId );

        $this->tabs[] = $tab;
        $this->content[] = $content;
    }

    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->class_( "tabs_wrapper" )->id( $this->id );
        $containerWrapper = Xhtml::div()->class_( "tabs_container_wrapper" )->attr( "data-width-parent",
                sprintf( ".tabs_wrapper%s", $this->id ? sprintf( "#%s", $this->id ) : null ) );
        $container = Xhtml::div()->class_( "tabs_container" );
        $contents = Xhtml::div()->class_( "tabs_content" );

        foreach ( $this->tabs as $tab )
        {
            $container->addContent( $tab );
        }

        foreach ( $this->content as $content )
        {
            $contents->addContent( $content );
        }

        $containerWrapper->addContent( $container );
        $wrapper->addContent( $containerWrapper );
        $wrapper->addContent( $contents );
        $root->addContent( $wrapper );
    }

    // /FUNCTIONS


}

?>
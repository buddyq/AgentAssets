<<<<<<< HEAD
<<<<<<< HEAD
<?php
/**
 *
 *
 */
require_once "class.field_factory.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Franko
 */
class WPToolset_Field_Textfield extends FieldFactory
{
    public function metaform()
    {
        $metaform = array();
        $metaform[] = array(
            '#type'			=> 'textfield',
            '#title'		=> $this->getTitle(),
            '#description'	=> $this->getDescription(),
            '#name'			=> $this->getName(),
            '#value'		=> $this->getValue(),
            '#validate'		=> $this->getValidationData(),
            '#repetitive'	=> $this->isRepetitive(),
            '#attributes'	=> $this->getAttr(),
            'wpml_action'	=> $this->getWPMLAction(),
        );
        return $metaform;
    }

}
=======
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
<?php
/**
 *
 *
 */
require_once "class.field_factory.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Franko
 */
class WPToolset_Field_Textfield extends FieldFactory
{
    public function metaform()
    {
        $metaform = array();
        $metaform[] = array(
            '#type'			=> 'textfield',
            '#title'		=> $this->getTitle(),
            '#description'	=> $this->getDescription(),
            '#name'			=> $this->getName(),
            '#value'		=> $this->getValue(),
            '#validate'		=> $this->getValidationData(),
            '#repetitive'	=> $this->isRepetitive(),
            '#attributes'	=> $this->getAttr(),
            'wpml_action'	=> $this->getWPMLAction(),
        );
        return $metaform;
    }

}
<<<<<<< HEAD
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6

<?php
/* 
 * @package     Pure PHP5 Templates (Templating Libary)
 * @author      Dan Goldsmith
 * @copyright   Dan Goldsmith 2012
 * @link        http://d2g.org.uk/
 * @version     {SUBVERSION_BUILD_NUMBER}
 * 
 * @licence     MPL 2.0
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 */

require_once(dirname(__FILE__) . "/simple_block.class.php");

class simple_template
{
    private $block              = null;    
    private $parent             = null;    
    private $name               = null;
    
    private static $templates   = array(); 
    
    public function __construct($template_name = null,$start_template = true)
    {
        if($template_name == null)
        {
            //Template is definatly the running template
            $backtrace = debug_backtrace();            
            $template_name = basename($backtrace[0]["file"]);
        }

        if(array_key_exists($template_name, simple_template::$templates))
        {
            return simple_template::$templates[$template_name];
        }
        else
        {
            $this->setName($template_name);
            if($start_template)
            {
                $this->startTemplate();
            }
            
            simple_template::$templates[$template_name] = $this;
            return simple_template::$templates[$template_name];
        }
    }
    
    private function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function startTemplate()
    {
        $this->block = new simple_block(null,$this);
        $this->block->startBlock();
    }
    
    public function endTemplate()
    {
        //End of template
        $this->block->endBlock();
        return $this->getContent();        
    }
    
    public function startBlock($name)
    {
        $this->block->startBlock($name);
    }
    
    public function endBlock()
    {
        $this->block->endBlock();
    }
    
    public function getContent()
    {
        if($this->getParent() !== null)
        {
            //Actually we have to build the output from the extended template
            $parent = $this->getParent();
            $parent->mergeDown($this);
            return $parent->getContent();
        }
        
        return $this->block->getContent();
    }

    public function getBlock()
    {
        return $this->block;
    }
    
    public function mergeDown($template)
    {
        //Overwite all blocks in this template with the one passed
        $block = $template->getBlock();
        $this->block->merge($block);
    }
    
    public static function extendTemplate($extended_template_name)
    {
        //We need to check the extended file is already loaded.
        if(!array_key_exists($extended_template_name, simple_template::$templates))
        {
            if(is_file($extended_template_name))
            {
                require_once($extended_template_name);
            }
            else
            {
                //Parent Template has not been loaded
                throw new Exception("Parent Template Not loaded");
            }
        }
        
        $parent_template = simple_template::$templates[$extended_template_name];
        $parent_template->endTemplate(); //Ends the parent Template if it's not been ended.
        
        //We have to do this here because on class construction the backtrace changes to this function.
        $backtrace = debug_backtrace();            
        $template_name = basename($backtrace[0]["file"]);
        
        $template = new simple_template($template_name);
        $template->setParent($parent_template);
        return $template;
    }     
    
    public static function getTemplate($template_name)
    {
        return simple_template::$templates[$template_name];
    }
    
}

?>
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

class simple_block
{
    private $blocks     = null;
    private $name       = null;
    private $parent     = null;
    
    private $isStarted = null;
    
    public function __construct($name = null,$parent = null)
    {
        $this->blocks = array();
        $this->isStarted = false;
        $this->setName($name);
        $this->setParent($parent);
    }
    
    public function setName($name)
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

    public function isStarted()
    {
        return $this->isStarted;
    }
    
    public function setStarted($bool)
    {
        $this->isStarted = $bool;
    }
    
    public function startBlock($block_name = null)
    {
        //If were already running
        if($this->isStarted())
        {
            //Needs to be a child
            //Create the new child
            $new_child = new simple_block($block_name,$this);
            
            
            //New child must be marked as running or the end closes the parent block (although at the moment it's not running
            $new_child->setStarted(true);
            $this->blocks[] = $new_child;
            
            //End the current block
            $this->endBlock();
            
            //The child block and the block just closed are the wrond way round.
            $tmp = $this->blocks[count($this->blocks) - 1];
            $this->blocks[count($this->blocks) - 1] = $this->blocks[count($this->blocks) - 2]; //Move the child one block forward
            $this->blocks[count($this->blocks) - 2] = $tmp;//put the other block back
            
            //Undo the fake child running
            $new_child->setStarted(false);
            
            $new_child->startBlock($block_name);
            return true;            
        }
        
        /*
         * Ahh we may be getting a callbcak from a child.
         * If this is the case we are restarting a block so the count wont be 0.
         */
        
        if(count($this->blocks) == 0) //&& !$this->isStarted()) 
        {
            //Ok We've just started this block            
            ob_start(array($this,'endblockCallback'));
            $this->isStarted = true;
            return true;
        }
        else if($this->isRunning() === false) //Were not running and none of our children our
        {
            //Ok We just restarted this block after a child finished.
            ob_start(array($this,'endblockCallback'));
            $this->isStarted = true;
            return true;
        }
        else
        {
            
            //It's with the last child block
            for($i=(count($this->blocks)-1);$i>=0;$i--)
            {
                if($this->blocks[$i] instanceof simple_block)
                {
                    $result = $this->blocks[$i]->startBlock($block_name);
                    if($result === true)
                    {
                        return true;
                    }                    
                }
            }
                        
        }
        return false;
    }
    
    public function endBlock()
    {
        if($this->isRunning() == true)
        {
            if($this->isStarted())
            {
                //It's us running
                
                //We're not running now.
                $this->isStarted = false;
                ob_end_clean();
                
                //Tell our parent to start
                //So if no child is running && we have a parent
                if(!$this->isRunning() && $this->getParent() !== null)
                {
                    $parent = $this->getParent();

                    if($parent instanceof simple_block)
                    {
                        $parent->startBlock();
                    }

                    if($parent instanceof simple_template)
                    {
                        //$parent->endTemplate();
                    }
                }                
                return true;
            }
            
            //If were running we need to end
            foreach($this->blocks as $child)
            {
                if($child instanceof simple_block)
                {
                    if($child->isRunning())
                    {
                        return $child->endBlock();
                    }
                }                
            }                        
        }
        //we dont need to end.
        return false;
    }
    
    public function endBlockCallBack()
    {
        $this->blocks[] = ob_get_contents();
        
        
        if($this->isStarted())
        {
            //We didn't close nicely
            $this->isStarted = false;

            //It might be that we ended the template without end template.
            $parent = $this->getParent();

            if($parent instanceof simple_template)
            {
                return $parent->endTemplate();
            }
        }        
    }

    public function getContent()
    {
        $html = '';
        
        foreach($this->blocks as $block)
        {
            if($block instanceof simple_block)
            {
                $html .= $block->getContent();
            }
            else
            {
                $html .= $block;
            }
        }
        
        return $html;
    }
    
    public function isRunning()
    {
        if($this->isStarted())
        {
            return true;
        }
        else 
        {
            foreach($this->blocks as $block)
            {
                if($block instanceof simple_block)
                {
                    if($block->isRunning())
                    {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

    public function getChildren()
    {
        $children = array(); //Assoc where key is name and last is always used (if same key on may blocks)
        foreach($this->blocks as $child)
        {
            if($child instanceof simple_block)
            {
                if($child->getName() != null)
                {
                    $children[$child->getName()] = $child;
                }                
                $children = array_merge($children, $child->getChildren());
            }
        }
        return $children;
    }
    
    public function merge($block)
    {
        $overwite = $block->getChildren();
        
        for($i=0;$i<count($this->blocks);$i++)
        {
            if($this->blocks[$i] instanceof simple_block)
            {
                if(array_key_exists($this->blocks[$i]->getName(), $overwite))
                {
                    //overwite the child
                    $this->blocks[$i] = $overwite[$this->blocks[$i]->getName()];
                }
                else
                {
                    //Process children
                    $this->blocks[$i]->merge($block);
                }
            }
        }
    }
    
    
}


?>